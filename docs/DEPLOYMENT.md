# Deployment Guide - Plexora ERP

## Server Requirements

| Component | Minimum | Production Recommended |
|-----------|---------|------------------------|
| OS | Ubuntu 20.04+ / CentOS 8+ | Ubuntu 22.04 |
| PHP | 8.2 | 8.3 |
| MySQL | 8.0 | 8.0+ |
| RAM | 2GB | 4GB+ |
| CPU | 1 core | 2+ cores |
| Storage | 20GB | 50GB+ |

## Deployment Options

### Option 1: VPS Deployment (Ubuntu)

#### 1. Server Setup

```bash
# Update system
apt update && apt upgrade -y

# Install Nginx
apt install -y nginx

# Install MySQL
apt install -y mysql-server
mysql_secure_installation

# Install PHP 8.2
apt install -y php8.2 php8.2-cli php8.2-fpm php8.2-gd php8.2-mysql \
    php8.2-mbstring php8.2-xml php8.2-zip php8.2-curl php8.2-intl \
    php8.2-bcmath php8.2-soap

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Node.js and NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

# Verify installations
php -v
mysql --version
nginx -v
```

#### 2. Database Setup

```bash
mysql -u root -p

# Create database and user
CREATE DATABASE plexora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'plexora'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON plexora.* TO 'plexora'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### 3. Application Setup

```bash
# Create web directory
mkdir -p /var/www/plexora-erp
chown -R www-data:www-data /var/www/plexora-erp

# Clone application (via git or upload)
cd /var/www/plexora-erp

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Edit .env file
nano .env

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed

# Create storage symlink
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 4. Nginx Configuration

```bash
# Create configuration
nano /etc/nginx/sites-available/plexora
```

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/plexora-erp/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header Referrer-Policy "no-referrer-when-downgrade";

    # Security headers
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_script_name;
        fastcgi_param SCRIPT_NAME /index.php;
    }

    location ~ /\.(env|git|svn|htaccess|ini|md|log)$ {
        deny all;
        return 404;
    }

    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    access_log /var/log/nginx/plexora_access.log;
    error_log /var/log/nginx/plexora_error.log;
}
```

```bash
# Enable site
ln -s /etc/nginx/sites-available/plexora /etc/nginx/sites-enabled/

# Test configuration
nginx -t

# Restart Nginx
systemctl restart nginx
```

#### 5. Queue Worker Setup

```bash
# Install Supervisor
apt install -y supervisor

# Create configuration
nano /etc/supervisor/conf.d/plexora-queue.conf
```

```ini
[program:plexora-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/plexora-erp/artisan queue:work database --queue=default,automation,campaigns,support --timeout=120 --sleep=3
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/plexora-erp/storage/logs/queue.log
stopwaitsecs=3600
```

```bash
# Enable and start
supervisorctl reread
supervisorctl update
supervisorctl start plexora-queue:*

# Enable on boot
systemctl enable supervisor
```

#### 6. Cron Job

```bash
# Add to crontab
crontab -e
```

```cron
* * * * * php /var/www/plexora-erp/artisan schedule:run >> /dev/null 2>&1
```

### Option 2: cPanel Deployment

#### 1. Upload Files

1. Create ZIP of project (excluding vendor, node_modules, storage)
2. Upload via cPanel File Manager
3. Extract to `public_html` or subdirectory

#### 2. Database Setup

1. Navigate to **MySQL Databases**
2. Create new database
3. Create user and add to database
4. Note credentials for .env

#### 3. Configure Environment

1. Edit `.env` file via cPanel File Manager
2. Update database credentials
3. Generate APP_KEY via Laravel Tinker or online generator

#### 4. Run Artisan Commands

Use **SSH Access** or **Terminal** in cPanel:

```bash
# Navigate to project
cd public_html

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed

# Create storage symlink
php artisan storage:link
```

#### 5. Setup Cron Jobs

Create a cron job in cPanel:

```
* * * * * /usr/local/bin/php /home/username/public_html/artisan schedule:run >> /dev/null 2>&1
```

This single cron job is enough on shared hosting. The application scheduler will:

- run all Laravel scheduled tasks
- process queued jobs from `default,automation,campaigns,support`
- handle campaign dispatch, support automation, and cleanup jobs

You do not need a separate forever-running `php artisan queue:work` command on cPanel/shared hosting.

### Option 3: Docker Deployment

#### Docker Compose

```yaml
# docker-compose.yml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: plexora-app
    ports:
      - "8000:8000"
    volumes:
      - ./storage:/var/www/html/storage
      - ./bootstrap/cache:/var/www/html/bootstrap/cache
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
      - APP_URL=http://localhost:8000
      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=plexora
      - DB_USERNAME=plexora
      - DB_PASSWORD=secret
      - QUEUE_CONNECTION=database
    depends_on:
      - db

  db:
    image: mysql:8.0
    container_name: plexora-db
    ports:
      - "3306:3306"
    environment:
      - MYSQL_DATABASE=plexora
      - MYSQL_USER=plexora
      - MYSQL_PASSWORD=secret
      - MYSQL_ROOT_PASSWORD=root_password
    volumes:
      - mysql_data:/var/lib/mysql

  queue:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: plexora-queue
    volumes:
      - ./storage:/var/www/html/storage
      - ./bootstrap/cache:/var/www/html/bootstrap/cache
    environment:
      - APP_ENV=production
      - QUEUE_CONNECTION=database
    command: php artisan queue:work database --queue=default,automation,campaigns,support
    depends_on:
      - db

volumes:
  mysql_data:
```

```bash
# Build and run
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate --force

# Run seeders
docker-compose exec app php artisan db:seed
```

## SSL Configuration (HTTPS)

### Let's Encrypt

```bash
# Install Certbot
apt install -y certbot python3-certbot-nginx

# Get certificate
certbot --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal
systemctl enable certbot.timer
```

### Manual SSL Configuration

Update Nginx config with SSL:

```nginx
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name your-domain.com;

    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:...;
    ssl_prefer_server_ciphers off;

    # ... rest of configuration
}
```

## Environment Configuration

### Production Settings (.env)

```env
APP_NAME=PlexoraERP
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
APP_TIMEZONE=UTC
APP_LOCALE=en
APP_KEY=base64:your-app-key-here

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plexora
DB_USERNAME=plexora
DB_PASSWORD=your-secure-password

BROADCAST_CONNECTION=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@your-domain.com
MAIL_FROM_NAME="Plexora ERP"
```

## Security Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Set `APP_ENV=production`
- [ ] Use strong `APP_KEY`
- [ ] Set strong database passwords
- [ ] Configure HTTPS/SSL
- [ ] Set proper file permissions
- [ ] Block sensitive file access via web server
- [ ] Enable application firewall
- [ ] Configure rate limiting
- [ ] Set up log monitoring
- [ ] Enable backup schedule

## Backup Strategy

### Database Backup (Daily)

```bash
# Create backup script
nano /opt/backup-plexora.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u plexora -p'password' plexora > /backup/plexora_$DATE.sql
gzip /backup/plexora_$DATE.sql

# Keep only last 30 days
find /backup -name "plexora_*.sql.gz" -mtime +30 -delete
```

```bash
# Make executable
chmod +x /opt/backup-plexora.sh

# Add to crontab
crontab -e
```

```cron
0 2 * * * /opt/backup-plexora.sh
```

### Storage Backup

```bash
# Backup uploads
tar -czf /backup/plexora_storage_$(date +%Y%m%d).tar.gz /var/www/plexora-erp/storage/app/public
```

## Monitoring

### Laravel Telescope (Development Only)

```bash
composer require --dev laravel/telescope
php artisan telescope:install
php artisan migrate
```

### Log Monitoring

```bash
# Tail application logs
tail -f storage/logs/laravel.log

# Monitor queue worker
tail -f storage/logs/queue.log
```

### Health Check Endpoint

```bash
# Access: https://your-domain.com/up
# Returns: "Laravel is running."
```

## Performance Tuning

### PHP Configuration

```ini
# php.ini
memory_limit = 512M
post_max_size = 20M
upload_max_filesize = 20M
max_execution_time = 300
max_input_time = 300
```

### MySQL Configuration

```ini
# my.cnf
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
max_connections = 500
query_cache_size = 64M
```

### Laravel Optimization

```bash
# Production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

---

**Version:** 1.0.0  
**Last Updated:** May 2026

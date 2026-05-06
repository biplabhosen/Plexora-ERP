# Installation Guide - Plexora ERP

## System Requirements

| Component | Minimum | Recommended |
|-----------|---------|-------------|
| PHP | 8.2 | 8.3 |
| MySQL | 8.0 | 8.0+ |
| Composer | 2.0 | 2.5+ |
| Node.js | 18.x | 20.x |
| NPM | 9.x | 10.x |
| RAM | 2GB | 4GB+ |
| Storage | 20GB | 50GB+ |

## Quick Start

```bash
# Clone repository
git clone https://github.com/your-username/plexora-erp.git
cd plexora-erp

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Configure database (edit .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plexora
DB_USERNAME=root
DB_PASSWORD=your_password

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed

# Start queue worker (in background)
php artisan queue:work --queue=automation --timeout=60 &

# Start development server
php artisan serve --host=0.0.0.0 --port=8000
```

Visit `http://localhost:8000` to access the application.

---

## Detailed Installation

### Step 1: Server Preparation

#### Ubuntu/Debian

```bash
# Update system
apt update && apt upgrade -y

# Install required packages
apt install -y \
    nginx \
    mysql-server \
    php8.2 \
    php8.2-cli \
    php8.2-fpm \
    php8.2-gd \
    php8.2-mysql \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-zip \
    php8.2-curl \
    php8.2-intl \
    php8.2-bcmath \
    php8.2-soap \
    composer \
    nodejs \
    npm

# Start services
systemctl start mysql
systemctl enable mysql
systemctl start php8.2-fpm
systemctl enable php8.2-fpm
```

#### CentOS/RHEL

```bash
# Install EPEL and Remi repositories
dnf install epel-release
dnf install https://rpms.remirepo.net/enterprise/remi-release-$(rpm -E %rhel).rpm

# Install PHP 8.2
dnf module reset php
dnf module enable php:remi-8.2
dnf install php php-cli php-fpm php-mysqlnd php-gd php-mbstring php-xml php-zip php-curl php-intl php-bcmath php-soap

# Install MySQL
dnf install mysql-server
systemctl start mysqld
systemctl enable mysqld

# Install Node.js
dnf module install nodejs:20
```

### Step 2: Database Configuration

```bash
# Secure MySQL installation
mysql_secure_installation

# Create database
mysql -u root -p
CREATE DATABASE plexora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'plexora'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON plexora.* TO 'plexora'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 3: Application Configuration

#### Environment File

Edit `.env`:

```env
APP_NAME=PlexoraERP
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plexora
DB_USERNAME=plexora
DB_PASSWORD=strong_password

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

FILE_STORAGE_DISK=public
```

#### Generate Application Key

```bash
php artisan key:generate
```

### Step 4: Run Migrations

```bash
# Run all migrations
php artisan migrate --force

# Expected output:
# Migrating: 2026_05_03_105118_create_roles_table
# Migrating: 2026_05_03_105230_add_role_id_to_users_table
# Migrating: 2026_05_03_105437_create_suppliers_table
# ...
# Migrated: 25 migrations (126 migrations in total)
```

### Step 5: Database Seeding

```bash
# Run seeders
php artisan db:seed

# Expected output:
# Seeding: RoleSeeder
# Seeding: SettingSeeder
# Seeding: AutomationRuleSeeder
# Seeding: CampaignSeeder
# Seeding: SupportSeeder
```

### Step 6: Storage Configuration

```bash
# Create storage links
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Step 7: Queue Worker Setup

#### Option A: Run Manually (Development)

```bash
php artisan queue:work --queue=automation
```

#### Option B: Supervisor (Production)

Create `/etc/supervisor/conf.d/plexora-queue.conf`:

```ini
[program:plexora-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/plexora-erp/artisan queue:work database --queue=automation --timeout=60 --sleep=3
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

Enable and start:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start plexora-queue:*
```

### Step 8: Schedule Cron Job

Add to crontab (`sudo crontab -e`):

```cron
* * * * * php /var/www/plexora-erp/artisan schedule:run >> /dev/null 2>&1
```

### Step 9: Nginx Configuration

Create `/etc/nginx/sites-available/plexora`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/plexora-erp/public;
    index index.php;

    # SSL Configuration (optional)
    # listen 443 ssl http2;
    # listen [::]:443 ssl http2;
    # ssl_certificate /etc/ssl/certs/plexora.crt;
    # ssl_certificate_key /etc/ssl/private/plexora.key;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header Referrer-Policy "no-referrer-when-downgrade";

    # Security headers
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()";
    add_header X-XSS-Protection "1; mode=block";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Laravel Sanctum token endpoint
    location = /sanctum/csrf-cookie {
        internal;
        auth_basic off;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_script_name;
        fastcgi_param SCRIPT_NAME /index.php;
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

    # Cache static assets
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Logging
    access_log /var/log/nginx/plexora_access.log;
    error_log /var/log/nginx/plexora_error.log;
}
```

Enable and restart:

```bash
ln -s /etc/nginx/sites-available/plexora /etc/nginx/sites-enabled/
nginx -t
systemctl restart nginx
```

---

## Post-Installation

### First Admin User

Create first admin user:

```bash
php artisan tinker

>>> $role = \App\Models\Role::where('name', 'admin')->first();
>>> $user = \App\Models\User::create([
        'name' => 'Admin User',
        'email' => 'admin@your-domain.com',
        'password' => Hash::make('your_secure_password'),
        'role_id' => $role->id,
        'status' => 'active'
    ]);
>>> echo "Admin created: " . $user->email;
```

### Verify Installation

```bash
# Test application health
curl http://localhost/up

# Expected: "Laravel is running."
```

### Default Data

| Role | Email | Description |
|------|-------|-------------|
| admin | admin@your-domain.com | Full system access |
| supplier | supplier@your-domain.com | Supplier portal |
| user (buyer) | user@your-domain.com | Customer portal |

---

## Troubleshooting

### Migration Errors

```bash
# Rollback and re-run
php artisan migrate:rollback --step=1
php artisan migrate

# If foreign key issues
php artisan migrate:fresh --seed
```

### Permission Issues

```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Queue Not Processing

```bash
# Check queue jobs
php artisan queue:table

# Restart worker
php artisan queue:restart
php artisan queue:work --queue=automation
```

### Mail Not Sending

```bash
# Test mail configuration
php artisan tinker
>>> Mail::to('your-email@example.com')->send(new \App\Mail\CustomerWorkflowMail([
    'subject' => 'Test',
    'body' => 'Test message'
]));
```

---

## Update Existing Installation

```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Restart queue worker
php artisan queue:restart
```

---

## Security Hardening

### .env Protection

```nginx
# Already in Nginx config - blocks access to .env
location ~ /\.(env|git|svn|htaccess|ini|md|log)$ {
    deny all;
    return 404;
}
```

### App Key Rotation

```bash
# Generate new key
php artisan key:generate

# Update .env with new key
APP_KEY=new_base64_key_here
```

### SSL/HTTPS

Use Let's Encrypt:

```bash
apt install certbot python3-certbot-nginx
certbot --nginx -d your-domain.com
```

---

**Version:** 1.0.0  
**Last Updated:** May 2026

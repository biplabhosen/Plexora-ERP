# Plexora ERP - B2B E-Commerce & Business Automation Platform

A scalable multi-module business automation platform that integrates E-commerce operations, CRM, social media management, and workflow-based automation.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-green.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue.svg)](https://mysql.com)

## Table of Contents

- [Features](#features)
- [Architecture](#architecture)
- [Modules](#modules)
- [Installation](#installation)
- [Configuration](#configuration)
- [Deployment](#deployment)
- [Database Schema](#database-schema)
- [API Documentation](#api-documentation)
- [Support](#support)

## Features

### Core Capabilities

| Feature | Description |
|---------|-------------|
| **Multi-Role Access** | Admin, Supplier, Buyer, Marketing Manager, Support Agent roles |
| **E-commerce** | Multi-vendor marketplace, product management, order system |
| **CRM** | Customer profiling, lead management, segmentation |
| **Social Media** | Schedule posts, content calendar, campaign management |
| **Marketing Automation** | Trigger-based campaigns, email/SMS workflows |
| **Workflow Engine** | Rule-based automation with condition-action pairs |
| **Support System** | Ticketing, auto-responses, chatbot integration |

### Automation Features

- **Trigger Events**: Order placed, RFQ created, Low stock, Customer registered
- **Actions**: Send email, Notify supplier, Notify admin, Log only
- **Condition System**: IF condition → THEN action pattern
- **Queue Processing**: Asynchronous job handling for scalability

## Architecture

### System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Presentation Layer                       │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │
│  │  Web UI     │  │  API Layer  │  │  Queue Workers      │  │
│  │ (Blade)     │  │ (Laravel)   │  │ (Queue)             │  │
│  └─────────────┘  └─────────────┘  └─────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                          │
┌─────────────────────────────────────────────────────────────┐
│                     Business Logic Layer                     │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │
│  │ Services    │  │ Controllers │  │ Automation Engine   │  │
│  └─────────────┘  └─────────────┘  └─────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                          │
┌─────────────────────────────────────────────────────────────┐
│                     Data Layer                               │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │
│  │ Models      │  │  Database   │  │  Queue Storage      │  │
│  └─────────────┘  └─────────────┘  └─────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### Technology Stack

| Layer | Technology |
|-------|------------|
| **Framework** | Laravel 10+ (PHP 8.2+) |
| **Database** | MySQL 8.0+ |
| **Frontend** | Bootstrap 5 / Tailwind CSS |
| **Queue** | Laravel Queue (Database driver) |
| **Mail** | Laravel Mailables |
| **Deployment** | VPS / cPanel |

## Modules

### 1. E-Commerce Module

Multi-vendor marketplace with product management and order processing.

**Key Features:**
- Product CRUD with SKU management
- Inventory tracking with MOQ thresholds
- Bulk pricing support
- Order management (cart → checkout → confirmation)
- Invoice generation
- Stock movement tracking

**Database Tables:**
- `products` - Product catalog
- `orders` - Customer orders
- `order_items` - Order line items
- `suppliers` - Seller/vendor profiles

### 2. CRM Module

Customer relationship management with lead tracking and segmentation.

**Key Features:**
- Customer registration and profiling
- Purchase history tracking
- Lead management pipeline
- Customer notes and interactions
- Customer segmentation

**Database Tables:**
- `customers` - Customer profiles
- `leads` - Lead management
- `customer_notes` - Interaction history

### 3. Social Media Automation

Schedule and manage social media posts across platforms.

**Key Features:**
- Facebook and Instagram integration
- Content calendar system
- Auto-posting workflow engine
- Campaign management
- Engagement tracking

**Database Tables:**
- `social_accounts` - Platform account connections
- `campaigns` - Social media campaigns

### 4. Marketing Automation

Trigger-based marketing campaigns with email and SMS support.

**Key Features:**
- Template-based email/SMS campaigns
- Trigger events: New customer, Order placed, RFQ created
- Campaign scheduling
- Automation rule engine

**Database Tables:**
- `campaigns` - Marketing campaigns
- `campaign_logs` - Campaign execution logs
- `message_templates` - Email/SMS templates

### 5. Workflow Automation Engine

Rule-based automation with condition-action pairs.

**Key Features:**
- IF condition → THEN action pattern
- Events: order_placed, rfq_created, stock_low
- Actions: send_email, notify_supplier, notify_admin
- Workflow logging for audit trails
- Duplicate prevention with time windows

**Database Tables:**
- `automation_rules` - Rule definitions
- `workflow_logs` - Execution history

### 6. Admin Panel

Role-based access control and platform management.

**Key Features:**
- Module control (enable/disable features)
- User management
- Role configuration
- Dashboard monitoring

**Roles:**
| Role | Permissions |
|------|-------------|
| `admin` | Full access, module control, user management |
| `supplier` | Manage products, view orders, respond to RFQs |
| `buyer` | View products, place orders, create RFQs |
| `marketing_manager` | Campaigns, social media, automation |
| `support_agent` | Support tickets, customer communication |

## Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM >= 9.x

### Steps

```bash
# Clone the repository
git clone https://github.com/your-username/plexora-erp.git
cd plexora-erp

# Install dependencies
composer install
npm install
npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Database configuration (edit .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plexora
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed

# Start queue worker (for automation)
php artisan queue:work --queue=automation

# Start development server
php artisan serve
```

### Production Setup

```bash
# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (production)
php artisan migrate --force

# Queue worker as systemd service or supervisor
php artisan queue:work --queue=automation --timeout=60
```

## Configuration

### Environment Variables (.env)

```env
# Application
APP_NAME=PlexoraERP
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plexora
DB_USERNAME=root
DB_PASSWORD=

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Plexora ERP"

# Queue
QUEUE_CONNECTION=database

# Social Media (API Keys - Optional)
FACEBOOK_APP_ID=
FACEBOOK_APP_SECRET=
INSTAGRAM_ACCESS_TOKEN=
```

### Module Control

Modules can be enabled/disabled via the Admin Panel or database:

```sql
-- Disable a module
UPDATE settings SET value = 0 WHERE key = 'module.suppliers';

-- Enable a module
UPDATE settings SET value = 1 WHERE key = 'module.suppliers';
```

## Deployment

### VPS Deployment

1. **Server Requirements:**
   - Ubuntu 20.04+ or CentOS 8+
   - 2GB+ RAM
   - 2+ CPU cores
   - 20GB+ storage

2. **Installation Script:**
```bash
# Install dependencies
apt update && apt upgrade -y
apt install -y nginx mysql-server php8.2 php8.2-{cli,gd,mysql,mbstring,xml,zip,curl,intl,bcmath,soap}

# Configure MySQL
mysql_secure_installation

# Clone and configure
git clone https://github.com/your-username/plexora-erp.git
cd plexora-erp
composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed

# Configure Nginx (see nginx.conf below)
ln -s /etc/nginx/sites-available/plexora /etc/nginx/sites-enabled/
nginx -t && systemctl restart nginx

# Setup queue worker
php artisan queue:work --queue=automation --timeout=60
```

3. **Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/plexora-erp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_script_name;
    }

    location ~ /\.(env|git|svn|gitlab|htaccess|ini|md|log)$ {
        deny all;
    }
}
```

### Database Backup

```bash
# Create backup
mysqldump -u root -p plexora > plexora_backup_$(date +%Y%m%d).sql

# Restore
mysql -u root -p plexora < plexora_backup.sql
```

## Database Schema

### Core Tables

| Table | Description |
|-------|-------------|
| `users` | System users |
| `roles` | Role definitions (admin, supplier, buyer, etc.) |
| `customers` | Customer profiles |
| `suppliers` | Supplier/vendor information |
| `products` | Product catalog |
| `orders` | Customer orders |
| `order_items` | Order line items |
| `stock_movements` | Inventory movement logs |

### Automation Tables

| Table | Description |
|-------|-------------|
| `automation_rules` | Rule definitions (IF-THEN patterns) |
| `workflow_logs` | Execution history |
| `campaigns` | Marketing campaigns |
| `campaign_logs` | Campaign execution logs |
| `social_accounts` | Social media account connections |
| `message_templates` | Email/SMS templates |

### Support Tables

| Table | Description |
|-------|-------------|
| `support_tickets` | Support ticket records |
| `support_replies` | Ticket conversation thread |
| `rfqs` | Request for quotation |

## API Documentation

### Support Bot API

The platform includes a chatbot-ready API endpoint.

**Endpoint:** `POST /api/support/chat`

**Request:**
```json
{
    "message": "Where is my order?"
}
```

**Response:**
```json
{
    "reply": "Please share your order number."
}
```

### API Authentication

All API endpoints (except the public support bot) require authentication via Laravel Sanctum:

```
Authorization: Bearer {token}
```

## Support & Maintenance

### Logs

Laravel logs are stored at `storage/logs/laravel.log`.

### Queue Monitoring

```bash
# Check queue status
php artisan queue:table

# Monitor jobs
php artisan queue:work --queue=automation
```

### Common Commands

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Clear failed jobs
php artisan queue:flush

# List failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry {id}
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/          # API controllers
│   │   ├── Admin/        # Admin panel controllers
│   │   ├── Buyer/        # Buyer dashboard controllers
│   │   └── Supplier/     # Supplier dashboard controllers
│   └── Middleware/       # Custom middleware
├── Models/               # Eloquent models
├── Services/             # Business logic services
├── Jobs/                 # Queue jobs for automation
├── Mail/                 # Mailable classes
└── Providers/            # Service providers
database/
├── migrations/           # Database migrations
└── seeders/              # Database seeders
resources/
├── views/                # Blade templates
└── js/                   # Frontend JavaScript
routes/
├── web.php               # Web routes
└── api.php               # API routes
```

## Contributing

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Commit your changes: `git commit -m 'Add some feature'`
3. Push to the branch: `git push origin feature/your-feature`
4. Create a Pull Request

## License

This project is proprietary and confidential.

## Contact

For support, contact: support@plexora.com

---

**Version:** 1.0.0  
**Last Updated:** May 2026  
**Developer:** Biplab Hosen

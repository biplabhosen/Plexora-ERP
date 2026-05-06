# Plexora ERP Documentation Index

Welcome to the Plexora ERP documentation. This guide covers everything from installation to advanced usage.

## Getting Started

| Document | Description |
|----------|-------------|
| [README](../README.md) | Project overview, features, and quick links |
| [QUICKSTART](QUICKSTART.md) | Get running in 5 minutes |
| [INSTALLATION](INSTALLATION.md) | Detailed installation guide |

## Core Documentation

| Document | Description |
|----------|-------------|
| [DATABASE](DATABASE.md) | Complete database schema reference |
| [API](API.md) | REST API documentation |
| [AUTOMATION](AUTOMATION.md) | Workflow automation engine guide |
| [MODULES](MODULES.md) | Module configuration and management |
| [DEPLOYMENT](DEPLOYMENT.md) | Production deployment guide |

## For Developers

| Document | Description |
|----------|-------------|
| [DEVELOPER](DEVELOPER.md) | Development guide, coding standards |
| Project Structure | `app/`, `database/`, `resources/` |

## Quick Links

### Common Tasks

| Task | Documentation |
|------|---------------|
| Add new product | [QUICKSTART](QUICKSTART.md) |
| Create automation rule | [AUTOMATION](AUTOMATION.md) |
| Set up email campaign | [API](API.md) |
| Deploy to production | [DEPLOYMENT](DEPLOYMENT.md) |
| Configure module | [MODULES](MODULES.md) |
| Add new module | [DEVELOPER](DEVELOPER.md) |

### Reference Tables

| Resource | Location |
|----------|----------|
| Database Schema | [DATABASE](DATABASE.md) |
| API Endpoints | [API](API.md) |
| Events & Actions | [AUTOMATION](AUTOMATION.md) |

## Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                    Presentation Layer                   │
│  ┌──────────┐  ┌──────────┐  ┌──────────────────────┐  │
│  │  Web UI  │  │   API    │  │   Queue Workers    │  │
│  │ (Blade)  │  │ (JSON)   │  │    (Jobs)          │  │
│  └──────────┘  └──────────┘  └──────────────────────┘  │
└─────────────────────────────────────────────────────────┘
                        │
┌─────────────────────────────────────────────────────────┐
│                  Business Logic Layer                   │
│  ┌──────────┐  ┌──────────┐  ┌──────────────────────┐  │
│  │ Services │  │ Controls │  │   Automation Engine  │  │
│  └──────────┘  └──────────┘  └──────────────────────┘  │
└─────────────────────────────────────────────────────────┘
                        │
┌─────────────────────────────────────────────────────────┐
│                      Data Layer                         │
│  ┌──────────┐  ┌──────────┐  ┌──────────────────────┐  │
│  │ Models   │  │ Database │  │   Queue Storage      │  │
│  └──────────┘  └──────────┘  └──────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

## Role-Based Access

| Role | Permissions |
|------|-------------|
| **Admin** | Full system access, module control, user management |
| **Supplier** | Manage products, view orders, respond to RFQs |
| **Buyer** | View products, place orders, create RFQs |
| **Marketing Manager** | Campaigns, social media, automation |
| **Support Agent** | Support tickets, customer communication |

## Technology Stack

| Layer | Technology |
|-------|------------|
| Framework | Laravel 10+ (PHP 8.2+) |
| Database | MySQL 8.0+ |
| Frontend | Bootstrap 5 / Tailwind CSS |
| Queue | Laravel Queue (Database driver) |
| Deployment | VPS / cPanel / Docker |

## Support & Resources

- **Documentation:** See `docs/` folder
- **API Docs:** `docs/API.md`
- **Database Schema:** `docs/DATABASE.md`
- **Automation Guide:** `docs/AUTOMATION.md`

## Quick Commands

```bash
# Install dependencies
composer install
npm install

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed

# Start development server
php artisan serve

# Queue worker
php artisan queue:work --queue=automation

# Clear cache
php artisan config:clear
php artisan cache:clear
```

## Files and Directories

```
plexora-erp/
├── app/                          # Application code
├── database/                     # Database files
├── docs/                         # Documentation (this folder)
├── public/                       # Public assets
├── resources/                    # Views, lang, js
├── routes/                       # Route definitions
├── storage/                      # Generated files
├── tests/                        # Test files
├── .env                          # Environment config
└── README.md                     # Project overview
```

## License

This project is proprietary and confidential.

## Contact

For support, contact: support@plexora.com

---

**Version:** 1.0.0  
**Last Updated:** May 2026

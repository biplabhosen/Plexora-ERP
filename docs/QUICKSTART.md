# Quick Start Guide - Plexora ERP

## Installation (5 Minutes)

```bash
# 1. Clone repository
git clone https://github.com/your-username/plexora-erp.git
cd plexora-erp

# 2. Install dependencies
composer install
npm install
npm run build

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Edit .env with your database credentials
# DB_DATABASE=plexora
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Run migrations and seed
php artisan migrate --force
php artisan db:seed

# 6. Start development server
php artisan serve
```

**Access:** http://localhost:8000

---

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@plexora.com | password |
| Supplier | supplier@plexora.com | password |
| Buyer | buyer@plexora.com | password |

**Change these after first login!**

---

## Quick Features

### 1. Add Product

1. Navigate to **Products** (Admin or Supplier)
2. Click **Add Product**
3. Fill in:
   - Name, SKU, Price
   - Stock quantity
   - MOQ (Minimum Order Quantity)
4. Save

### 2. Create Order

1. Navigate to **Orders** (Buyer)
2. Click **Create Order**
3. Select product and quantity
4. Confirm order

### 3. Set Up Automation

1. Go to **Admin > Automation Rules**
2. Click **Add Rule**
3. Configure:
   - Event: Select trigger (Order placed, RFQ created, Low stock)
   - Condition: (Optional) Add rules like "stock < 10"
   - Action: Choose (Send email, Notify supplier, Notify admin)
4. Save and enable

### 4. Configure Campaigns

1. Go to **Marketing > Campaigns**
2. Click **Add Campaign**
3. Configure:
   - Name, Type (Marketing/Social)
   - Channel (Email/SMS/Facebook/Instagram)
   - Content template
   - Schedule date
4. Run campaign

---

## Common Tasks

### View Low Stock

**Admin Panel:** Inventory > Low Stock

**Command Line:**
```bash
php artisan tinker
>>> \App\Models\Product::lowStock()->get();
```

### Check Automation Logs

**Admin Panel:** Automation > Logs

**Command Line:**
```bash
php artisan tinker
>>> \App\Models\WorkflowLog::latest()->limit(20)->get();
```

### Manage Support Tickets

1. Navigate to **Support Tickets**
2. Filter by status, priority, or category
3. Reply to customer
4. Update status (Open → Pending → Resolved → Closed)

---

## Troubleshooting

### "Class not found" Error

```bash
composer dump-autoload
```

### Queue Not Processing

```bash
php artisan queue:work --queue=automation
```

### Cache Issues

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Permission Denied

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## Need Help?

- **Documentation:** See `docs/` folder
- **API Docs:** `docs/API.md`
- **Database Schema:** `docs/DATABASE.md`
- **Automation Guide:** `docs/AUTOMATION.md`

---

**Happy Building!** 🚀

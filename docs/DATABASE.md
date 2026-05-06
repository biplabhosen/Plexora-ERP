# Database Documentation - Plexora ERP

## Overview

This document provides a comprehensive reference for the Plexora ERP database schema, including all tables, relationships, and data integrity constraints.

## Database Diagram

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   users     │     │   roles     │     │  settings   │
└──────┬──────┘     └─────────────┘     └─────────────┘
       │
       │role_id
       ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ customers   │     │ suppliers   │     │   leads     │
└──────┬──────┘     └──────┬──────┘     └─────────────┘
       │                   │
       │user_id            │user_id
       ▼                   ▼
┌─────────────┐     ┌─────────────┐
│  orders     │     │ products    │
└──────┬──────┘     └──────┬──────┘
       │                   │
       │customer_id        │supplier_id
       ▼                   ▼
┌─────────────┐     ┌─────────────┐
│ order_items │     │  stock_     │
└─────────────┘     │   movements │
                    └─────────────┘

┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ rfqs        │     │  campaigns  │     │campaign_logs│
└─────────────┘     └─────────────┘     └─────────────┘
       │
       │buyer_id
       ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ support_    │     │  automation │     │ workflow_   │
│  tickets    │     │    rules    │     │   logs      │
└─────────────┘     └─────────────┘     └─────────────┘
       │
       │customer_id/supplier_id
       ▼
┌─────────────┐
│support_replies│
└─────────────┘

┌─────────────┐     ┌─────────────┐
│social_accts │     │message_temp │
└─────────────┘     └─────────────┘

┌─────────────┐
│customer_notes│
└─────────────┘
```

## Core Tables

### users

System users who access the platform.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| name | varchar(255) | NO | | | User display name |
| email | varchar(255) | NO | UNI | | Email address |
| email_verified_at | timestamp | YES | | NULL | Verification timestamp |
| password | varchar(255) | NO | | | Hashed password |
| role_id | bigint | YES | MUL | NULL | User role (admin, supplier, buyer) |
| status | varchar(20) | NO | | 'active' | User status |
| remember_token | varchar(100) | YES | | NULL | Password reset token |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Indexes:**
- `PRIMARY KEY (id)`
- `UNIQUE KEY users_email_unique (email)`
- `KEY users_role_id_foreign (role_id)`

**Foreign Keys:**
- `role_id` → `roles(id)` - User role assignment

---

### roles

Role definitions for access control.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| name | varchar(255) | NO | UNI | | Role name |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Pre-seeded Roles:**
- `admin` - Full system access
- `supplier` - Supplier portal access
- `user` (Buyer) - Customer portal access
- `marketing_manager` - Marketing automation access
- `support_agent` - Support ticket handling

---

### customers

Customer profile information.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| user_id | bigint | YES | MUL | NULL | Associated user account |
| name | varchar(255) | NO | | | Customer name |
| email | varchar(255) | YES | | | Customer email |
| phone | varchar(50) | YES | | | Phone number |
| address | text | YES | | | Shipping address |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Foreign Keys:**
- `user_id` → `users(id)` - Link to user account

---

### suppliers

Supplier/vendor profiles and onboarding information.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| user_id | bigint | NO | UNI | | Associated user (supplier) |
| company_name | varchar(255) | NO | | | Company/legal name |
| contact_person | varchar(255) | NO | | | Primary contact name |
| phone | varchar(50) | NO | | | Contact phone |
| email | varchar(255) | NO | | | Contact email |
| address | text | YES | | | Business address |
| business_type | varchar(100) | YES | | | B2B/B2C/etc |
| trade_license | varchar(255) | YES | | | License number |
| status | varchar(50) | NO | | 'pending' | Approval status |
| approved_by | bigint | YES | MUL | NULL | Admin approver |
| approved_at | timestamp | YES | | NULL | Approval timestamp |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Foreign Keys:**
- `user_id` → `users(id)`
- `approved_by` → `users(id)`

---

### products

Product catalog with inventory and pricing.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| supplier_id | bigint | NO | MUL | | Product owner |
| sku | varchar(100) | NO | UNI | | Stock keeping unit |
| name | varchar(255) | NO | | | Product name |
| description | text | YES | | | Product details |
| price | decimal(10,2) | NO | | | Selling price |
| stock | int | NO | | 0 | Current quantity |
| moq | int | NO | | 1 | Minimum order quantity |
| status | tinyint(1) | NO | | 1 | Active/inactive flag |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Foreign Keys:**
- `supplier_id` → `suppliers(id)`

**Special Attributes:**
- `is_low_stock` (accessor): Returns true when stock <= moq

---

### orders

Customer order records.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| customer_id | bigint | NO | MUL | | Order customer |
| order_number | varchar(100) | NO | UNI | | Unique order ID |
| subtotal | decimal(10,2) | NO | | | Subtotal before discounts |
| discount | decimal(10,2) | NO | | 0.00 | Discount amount |
| tax | decimal(10,2) | NO | | 0.00 | Tax amount |
| grand_total | decimal(10,2) | NO | | | Final total |
| status | varchar(50) | NO | | 'pending' | Order status |
| notes | text | YES | | | Customer notes |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Status Values:** pending, confirmed, processing, shipped, delivered, cancelled, refunded

**Foreign Keys:**
- `customer_id` → `customers(id)`

---

### order_items

Order line items.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| order_id | bigint | NO | MUL | | Parent order |
| product_id | bigint | NO | MUL | | Ordered product |
| quantity | int | NO | | | Quantity ordered |
| unit_price | decimal(10,2) | NO | | | Price at time of order |
| total | decimal(10,2) | NO | | | Line total |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Foreign Keys:**
- `order_id` → `orders(id)` ON DELETE CASCADE
- `product_id` → `products(id)`

---

### stock_movements

Inventory movement tracking.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| product_id | bigint | NO | MUL | | Affected product |
| quantity | int | NO | | | Change amount (+/-) |
| type | varchar(50) | NO | | | Movement type |
| reference_type | varchar(50) | YES | | NULL | Related model |
| reference_id | bigint | YES | | NULL | Related record ID |
| notes | text | YES | | | Movement description |
| created_at | timestamp | NO | | | Creation timestamp |

**Movement Types:**
- `incoming` - Stock increase
- `outgoing` - Stock decrease
- `adjustment` - Manual adjustment
- `restock` - Supplier restock

---

### automation_rules

Rule definitions for IF-THEN automation.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| name | varchar(255) | NO | | | Rule name |
| event | varchar(100) | NO | MUL | | Trigger event |
| condition | text | YES | | NULL | Condition expression |
| action | varchar(100) | NO | | | Action to execute |
| target | varchar(255) | YES | | NULL | Target email/user |
| is_active | tinyint(1) | NO | | 1 | Enable/disable |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Event Types:**
- `order_placed` - Order creation
- `rfq_created` - RFQ submission
- `stock_low` - Inventory low

**Actions:**
- `send_email` - Email notification
- `notify_supplier` - Supplier alert
- `notify_admin` - Admin alert
- `log_only` - Record event only

---

### workflow_logs

Automation rule execution history.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| automation_rule_id | bigint | YES | MUL | NULL | Triggering rule |
| event | varchar(255) | NO | | | Event type |
| status | varchar(50) | NO | | | Execution status |
| message | text | NO | | | JSON details |
| created_at | timestamp | NO | | | Creation timestamp |

**Status Values:** pending, success, failed

**Foreign Keys:**
- `automation_rule_id` → `automation_rules(id)`

---

### campaigns

Marketing and social media campaigns.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| name | varchar(255) | NO | | | Campaign name |
| type | varchar(50) | NO | MUL | | Campaign type |
| channel | varchar(50) | NO | MUL | | Delivery channel |
| audience | text | YES | | NULL | Target audience |
| subject | varchar(255) | YES | | NULL | Email subject |
| content | text | NO | | | Message content |
| media_path | varchar(255) | YES | | NULL | Image/video path |
| scheduled_at | timestamp | YES | | NULL | Send time |
| status | varchar(50) | NO | | 'draft' | Campaign status |
| trigger_event | varchar(100) | YES | | NULL | Trigger event |
| is_active | tinyint(1) | NO | | 1 | Enable/disable |
| created_by | bigint | YES | MUL | NULL | Creator user |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Campaign Types:** marketing, social

**Channels:** email, sms, facebook, instagram

**Status Values:** draft, scheduled, processing, sent, failed

**Foreign Keys:**
- `created_by` → `users(id)`

---

### campaign_logs

Campaign execution records.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| campaign_id | bigint | NO | MUL | | Campaign reference |
| recipient | varchar(255) | NO | | | Target recipient |
| status | varchar(50) | NO | | | Delivery status |
| message | text | YES | | NULL | Response/error |
| created_at | timestamp | NO | | | Creation timestamp |

**Foreign Keys:**
- `campaign_id` → `campaigns(id)` ON DELETE CASCADE

---

### social_accounts

Social media platform connections.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| platform | varchar(50) | NO | MUL | | Platform name |
| account_name | varchar(255) | NO | | | Account handle |
| access_token | varchar(500) | YES | | NULL | API access token |
| is_active | tinyint(1) | NO | | 1 | Enabled flag |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Platforms:** facebook, instagram

---

### message_templates

Reusable email/SMS templates.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| name | varchar(255) | NO | | | Template name |
| type | varchar(50) | NO | MUL | | Template type |
| channel | varchar(50) | NO | | | Delivery channel |
| subject | varchar(255) | YES | | NULL | Email subject |
| content | text | NO | | | Template content |
| is_active | tinyint(1) | NO | | 1 | Enable/disable |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

---

### support_tickets

Support ticket management.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| customer_id | bigint | NO | MUL | | Ticket originator |
| order_id | bigint | YES | MUL | NULL | Related order |
| supplier_id | bigint | YES | MUL | NULL | Related supplier |
| subject | varchar(255) | NO | | | Ticket title |
| message | text | NO | | | Issue description |
| category | varchar(50) | NO | MUL | | Ticket category |
| priority | varchar(50) | NO | MUL | 'medium' | Priority level |
| status | varchar(50) | NO | MUL | 'open' | Current status |
| assigned_to | bigint | YES | MUL | NULL | Assigned agent |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Categories:** order, payment, delivery, supplier, general

**Priorities:** low, medium, high, urgent

**Status Values:** open, pending, resolved, closed

**Foreign Keys:**
- `customer_id` → `customers(id)`
- `order_id` → `orders(id)`
- `supplier_id` → `suppliers(id)`
- `assigned_to` → `users(id)`

---

### support_replies

Ticket conversation thread.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| support_ticket_id | bigint | NO | MUL | | Parent ticket |
| author_id | bigint | NO | MUL | | Reply author |
| message | text | NO | | | Reply content |
| is_private | tinyint(1) | NO | | 0 | Internal note flag |
| created_at | timestamp | NO | | | Creation timestamp |

**Foreign Keys:**
- `support_ticket_id` → `support_tickets(id)` ON DELETE CASCADE
- `author_id` → `users(id)`

---

### rfqs

Request for quotation submissions.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| buyer_id | bigint | NO | MUL | | RFQ originator |
| supplier_id | bigint | NO | MUL | | Target supplier |
| title | varchar(255) | NO | | | RFQ title |
| description | text | YES | | | Requirements details |
| quantity | int | NO | | | Required quantity |
| status | varchar(50) | NO | | 'pending' | RFQ status |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Status Values:** pending, accepted, declined, completed

**Foreign Keys:**
- `buyer_id` → `users(id)`
- `supplier_id` → `suppliers(id)`

---

### leads

Lead management pipeline.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| name | varchar(255) | NO | | | Lead name |
| company | varchar(255) | YES | | NULL | Company name |
| email | varchar(255) | YES | | NULL | Contact email |
| phone | varchar(50) | YES | | NULL | Contact phone |
| source | varchar(100) | YES | | NULL | Lead source |
| status | varchar(50) | NO | MUL | 'new' | Lead status |
| assigned_to | bigint | YES | MUL | NULL | Sales rep |
| notes | text | YES | | NULL | Additional notes |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Status Values:** new, contacted, qualified, converted, lost

**Foreign Keys:**
- `assigned_to` → `users(id)`

---

### customer_notes

Interaction history with customers.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| customer_id | bigint | NO | MUL | | Customer reference |
| user_id | bigint | NO | MUL | NULL | Author |
| note | text | NO | | | Note content |
| is_private | tinyint(1) | NO | | 0 | Internal flag |
| created_at | timestamp | NO | | | Creation timestamp |

**Foreign Keys:**
- `customer_id` → `customers(id)` ON DELETE CASCADE
- `user_id` → `users(id)`

---

### settings

Platform configuration.

| Column | Type | Null | Key | Default | Description |
|--------|------|------|-----|---------|-------------|
| id | bigint | NO | PRI | | Primary key |
| key | varchar(255) | NO | UNI | | Configuration key |
| value | text | NO | | | Configuration value |
| created_at | timestamp | NO | | | Creation timestamp |
| updated_at | timestamp | NO | | | Last update timestamp |

**Common Keys:**
- `module.suppliers` - Supplier module enabled
- `module.crm` - CRM module enabled
- `module.marketing` - Marketing module enabled
- `module.workflow` - Workflow engine enabled

---

## Relationships Summary

```
users
 ├─ has_many → customers
 ├─ has_many → suppliers
 ├─ has_many → leads (assigned_to)
 ├─ has_many → campaigns (created_by)
 ├─ has_many → support_tickets (assigned_to)
 ├─ has_many → support_replies (author_id)
 └─ has_many → customer_notes (user_id)
     has_one → role (roles)

suppliers
 └─ has_many → products

customers
 ├─ has_many → orders
 ├─ has_many → support_tickets
 ├─ has_many → rfqs (buyer_id)
 └─ has_many → customer_notes

orders
 ├─ belongs_to → customer
 └─ has_many → order_items

products
 ├─ belongs_to → supplier
 └─ has_many → stock_movements

automation_rules
 └─ has_many → workflow_logs

campaigns
 └─ has_many → campaign_logs

support_tickets
 ├─ belongs_to → customer
 ├─ belongs_to → order
 ├─ belongs_to → supplier
 └─ has_many → support_replies
```

## Migration Order

Run migrations in this order to maintain foreign key integrity:

1. `0001_01_01_000000_create_users_table` - Base users table
2. `0001_01_01_000001_create_cache_table` - Cache support
3. `0001_01_01_000002_create_jobs_table` - Queue jobs
4. `2026_05_03_105118_create_roles_table` - Role definitions
5. `2026_05_03_105230_add_role_id_to_users_table` - User-role link
6. `2026_05_03_105437_create_suppliers_table` - Supplier profiles
7. `2026_05_03_105603_create_products_table` - Product catalog
8. `2026_05_03_110301_create_orders_table` - Orders
9. `2026_05_03_110325_create_order_items_table` - Order items
10. `2026_05_03_125034_create_customers_table` - Customer profiles
11. `2026_05_05_000000_create_stock_movements_table` - Inventory tracking
12. `2026_05_05_010000_create_automation_rules_table` - Rules
13. `2026_05_05_010100_create_workflow_logs_table` - Execution logs
14. `2026_05_05_010200_create_rfqs_table` - RFQs
15. `2026_05_05_150000_create_leads_table` - Lead management
16. `2026_05_05_150100_create_customer_notes_table` - Notes
17. `2026_05_05_200000_create_campaigns_table` - Campaigns
18. `2026_05_05_200100_create_campaign_logs_table` - Campaign logs
19. `2026_05_05_200200_create_message_templates_table` - Templates
20. `2026_05_05_200300_create_social_accounts_table` - Social accounts
21. `2026_05_05_171221_create_personal_access_tokens_table` - API tokens
22. `2026_05_05_231000_create_support_tickets_table` - Tickets
23. `2026_05_05_231100_create_support_replies_table` - Ticket replies
24. `2026_05_06_010000_create_settings_table` - Settings
25. `2026_05_06_010100_add_status_to_users_table` - User status

## Data Integrity Constraints

All foreign key constraints use:
- **ON DELETE SET NULL** for optional relationships
- **ON DELETE CASCADE** for dependent records
- **ON UPDATE CASCADE** for id changes

## Indexing Strategy

| Table | Indexed Columns | Purpose |
|-------|----------------|---------|
| users | email | Login lookup |
| users | role_id | Role-based access |
| products | supplier_id | Supplier catalog view |
| products | name, sku | Search |
| products | stock, moq | Low stock alerts |
| orders | customer_id | Customer orders |
| orders | order_number | Order lookup |
| orders | status | Status filtering |
| automation_rules | event | Event-based rules |
| campaigns | scheduled_at | Scheduled sends |
| campaigns | status | Status filtering |
| support_tickets | status, category | Ticket queue |
| support_tickets | priority | Priority filtering |
| campaign_logs | campaign_id | Campaign tracking |
| workflow_logs | automation_rule_id | Rule history |
| rfqs | supplier_id | Supplier RFQs |

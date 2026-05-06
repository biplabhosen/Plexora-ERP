# Automation Engine Documentation - Plexora ERP

## Overview

The Plexora ERP includes a powerful workflow automation engine that enables rule-based business logic without custom code. This document explains how to configure and use the automation engine.

## Architecture

### Flow Diagram

```
Event Trigger
    │
    ▼
Automation Service
    │
    ├─→ Load Active Rules for Event
    │
    ├─→ Evaluate Condition (IF)
    │   ├─→ Pass → Execute Action (THEN)
    │   └─→ Fail → Skip Rule
    │
    ├─→ Check Duplicate Window
    │   ├─→ Skip if duplicate within window
    │   └─→ Proceed if not duplicate
    │
    ├─→ Execute Action
    │   ├─→ send_email → SendCustomerEmailJob
    │   ├─→ notify_supplier → NotifySupplierJob
    │   ├─→ notify_admin → NotifyAdminJob
    │   └─→ log_only → Log to file
    │
    └─→ Record Workflow Log
```

### Queue System

All automation actions use Laravel's queue system:

```
Queue Name: automation
Queue Driver: Database
Workers: php artisan queue:work --queue=automation
```

---

## Trigger Events

### Order Placed (`order_placed`)

Fired when a new order is created.

**Payload Context:**
```php
[
    'order_id' => 1,
    'order_number' => 'ORD-2026-001',
    'customer_id' => 3,
    'customer_name' => 'John Doe',
    'customer_email' => 'john@example.com',
    'grand_total' => '161.97',
    'status' => 'confirmed'
]
```

**Use Cases:**
- Send order confirmation email
- Notify supplier of new order
- Update inventory allocation

---

### RFQ Created (`rfq_created`)

Fired when a Request for Quotation is submitted.

**Payload Context:**
```php
[
    'rfq_id' => 1,
    'rfq_title' => 'Bulk Order Request',
    'buyer_id' => 3,
    'buyer_name' => 'Jane Smith',
    'buyer_email' => 'jane@example.com',
    'supplier_id' => 5,
    'supplier_name' => 'Supplier Inc.',
    'quantity' => 500,
    'status' => 'pending'
]
```

**Use Cases:**
- Notify supplier of new RFQ
- Alert procurement team
- Log for analytics

---

### Low Stock (`stock_low`)

Fired when a product's stock reaches or falls below MOQ.

**Payload Context:**
```php
[
    'product_id' => 1,
    'product_name' => 'Widget A',
    'stock' => 3,
    'moq' => 10,
    'supplier_id' => 5,
    'supplier_name' => 'Supplier Inc.',
    'supplier_email' => 'supplier@example.com'
]
```

**Special Condition:** `unresolved_24h`

This condition checks if the low stock issue has remained unresolved for 24 hours.

---

### Customer Registered (`customer_registered`)

Fired when a new customer account is created.

**Payload Context:**
```php
[
    'customer_id' => 3,
    'customer_name' => 'John Doe',
    'customer_email' => 'john@example.com',
    'registration_date' => '2026-05-06 10:30:00'
]
```

**Use Cases:**
- Send welcome email
- Add to marketing list
- Trigger onboarding campaign

---

## Action Types

### Send Email (`send_email`)

Sends an email to the specified recipient.

**Configuration:**
- **Action:** `send_email`
- **Target:** Email address or `null` (uses customer_email from context)

**Email Template Variables:**
```
{customer_name} - Customer display name
{order_number} - Order reference
{grand_total} - Order total
{product_name} - Product name
{status} - Current status
```

**Template:** Uses `CustomerWorkflowMail` mailable

---

### Notify Supplier (`notify_supplier`)

Sends an email to the supplier associated with the transaction.

**Configuration:**
- **Action:** `notify_supplier`
- **Target:** Email address or `null` (uses supplier_email from context)

**Use Cases:**
- New order notification
- RFQ notification
- Low stock warning

**Template:** Uses `SupplierWorkflowMail` mailable

---

### Notify Admin (`notify_admin`)

Sends an email to all admin users.

**Configuration:**
- **Action:** `notify_admin`
- **Target:** Email address or `null` (sends to all admins)

**Use Cases:**
- Escalation alerts
- Fraud detection
- System warnings

**Template:** Uses `AdminWorkflowMail` mailable

---

### Log Only (`log_only`)

Records the automation execution in the workflow_logs table without sending emails.

**Configuration:**
- **Action:** `log_only`
- **Target:** Not applicable

**Use Cases:**
- Tracking for analytics
- Audit trail
- Debugging rules

---

## Condition Syntax

### Supported Operators

| Operator | Description | Example |
|----------|-------------|---------|
| `=` or `==` | Equals | `status == 'pending'` |
| `!=` | Not equals | `priority != 'low'` |
| `>` | Greater than | `stock > 100` |
| `<` | Less than | `stock < 5` |
| `>=` | Greater or equal | `quantity >= 50` |
| `<=` | Less or equal | `quantity <= 10` |

### Predefined Conditions

#### `unresolved_24h`

Checks if a low stock issue has remained unresolved for 24 hours.

**Use Case:** Escalate to admin if supplier doesn't respond to low stock alerts.

**Example Rule:**
```
Event: stock_low
Condition: unresolved_24h
Action: notify_admin
```

### Custom Conditions

Conditions are evaluated as expressions in the `AutomationService::passesCondition()` method.

**Example:**
```php
'condition' => 'stock < 10'
'condition' => 'quantity >= 100'
'condition' => 'grand_total >= 500'
'condition' => 'status == "pending"'
```

---

## Duplicate Prevention

The system prevents duplicate automation actions within configurable time windows:

| Event | Default Window |
|-------|----------------|
| stock_low | 24 hours |
| Other events | 1 hour |

**Duplicate Fingerprint:**
```json
{
    "order_id": 1,
    "product_id": null,
    "supplier_id": 5,
    "customer_id": 3
}
```

**Logic:**
1. Generate fingerprint from context keys
2. Check workflow_logs for same rule + event + fingerprint within window
3. Skip if duplicate found

---

## Workflow Logs

### Log Structure

```json
{
    "automation_rule_id": 1,
    "event": "order_placed",
    "status": "success",
    "message": {
        "rule": "Order placed email confirmation",
        "action": "send_email",
        "context": {
            "order_id": 1,
            "customer_email": "john@example.com"
        }
    }
}
```

### Log Status Values

- `success` - Rule executed successfully
- `failed` - Rule failed (recorded for debugging)

---

## Setting Up Automation Rules

### Via Admin Panel

1. Navigate to **Admin > Automation Rules**
2. Click **Create Rule**
3. Fill in the form:

| Field | Description |
|-------|-------------|
| **Name** | Descriptive rule name |
| **Event** | Trigger event |
| **Condition** | Optional condition expression |
| **Action** | Action to perform |
| **Target** | Email for action (optional) |
| **Active** | Enable/disable rule |

### Via Database

```sql
-- Create a new rule
INSERT INTO automation_rules (name, event, condition, action, target, is_active)
VALUES (
    'Low stock alert to supplier',
    'stock_low',
    'stock < 5',
    'notify_supplier',
    NULL,
    1
);

-- View rules
SELECT * FROM automation_rules WHERE is_active = 1;
```

---

## Rule Examples

### Example 1: Order Confirmation

| Field | Value |
|-------|-------|
| Name | Order confirmation email |
| Event | order_placed |
| Condition | (leave empty) |
| Action | send_email |
| Target | (leave empty - uses customer_email) |
| Active | Yes |

**Result:** Every new order triggers a confirmation email to the customer.

---

### Example 2: RFQ Supplier Alert

| Field | Value |
|-------|-------|
| Name | RFQ created notification |
| Event | rfq_created |
| Condition | (leave empty) |
| Action | notify_supplier |
| Target | (leave empty - uses supplier_email) |
| Active | Yes |

**Result:** All suppliers receive notifications when they are assigned an RFQ.

---

### Example 3: Low Stock Alert (First)

| Field | Value |
|-------|-------|
| Name | Low stock supplier alert |
| Event | stock_low |
| Condition | (leave empty) |
| Action | notify_supplier |
| Target | (leave empty) |
| Active | Yes |

**Result:** Supplier notified immediately when stock drops to MOQ or below.

---

### Example 4: Low Stock Escalation (24h)

| Field | Value |
|-------|-------|
| Name | Low stock admin escalation |
| Event | stock_low |
| Condition | unresolved_24h |
| Action | notify_admin |
| Target | (leave empty) |
| Active | Yes |

**Result:** If low stock issue remains after 24 hours, admins are notified.

---

### Example 5: VIP Customer Discount

| Field | Value |
|-------|-------|
| Name | VIP customer order discount |
| Event | order_placed |
| Condition | grand_total >= 500 |
| Action | send_email |
| Target | vip@example.com |
| Active | Yes |

**Result:** VIP team notified for large orders.

---

## Monitoring Automation

### Check Rule Status

```sql
-- Active rules
SELECT * FROM automation_rules WHERE is_active = 1;

-- Rules with failures
SELECT r.name, w.status, w.message, w.created_at
FROM workflow_logs w
JOIN automation_rules r ON r.id = w.automation_rule_id
WHERE w.status = 'failed'
ORDER BY w.created_at DESC;
```

### Manual Rule Test

```bash
php artisan tinker

# Load a rule and test
$rule = \App\Models\AutomationRule::find(1);
$service = new \App\Services\AutomationService();
$payload = \App\Models\Order::find(1);
$service->run('order_placed', $payload);
```

### View Workflow Logs

```bash
php artisan tinker

# Last 10 logs
\App\Models\WorkflowLog::latest()->limit(10)->get();
```

---

## Troubleshooting

### Rules Not Firing

1. **Check if rule is active:**
```sql
SELECT * FROM automation_rules WHERE event = 'order_placed';
```

2. **Verify automation service is being called:**
```php
// In controller after order creation
app(\App\Services\AutomationService::class)->run('order_placed', $order);
```

3. **Check queue worker is running:**
```bash
php artisan queue:work --queue=automation
```

### Duplicate Notifications

Adjust the duplicate window in `AutomationService::duplicateWindow()`:

```php
private function duplicateWindow(AutomationRule $rule): ?DateInterval
{
    if ($rule->event !== AutomationRule::EVENT_STOCK_LOW) {
        return new DateInterval('PT30M'); // Changed from 1 hour to 30 minutes
    }
    // ...
}
```

### Debugging Failures

```bash
# View failed logs
php artisan tinker

\App\Models\WorkflowLog::where('status', 'failed')->get();
```

---

## Performance Considerations

### Optimization Tips

1. **Index on automation_rules**
```sql
ALTER TABLE automation_rules ADD INDEX idx_event_active (event, is_active);
```

2. **Regular cleanup of old workflow logs**
```sql
-- Keep 90 days of logs
DELETE FROM workflow_logs WHERE created_at < NOW() - INTERVAL 90 DAY;
```

3. **Queue priority**
```bash
# Process automation queue with higher priority
php artisan queue:work --queue=automation,high,default
```

---

## Best Practices

### Rule Design

1. **Be specific with conditions** - Avoid overly broad conditions
2. **Use descriptive names** - Rule name should explain what it does
3. **Test in development** - Verify rules work before enabling in production
4. **Monitor regularly** - Check workflow logs for failures

### Security

1. **Never expose sensitive data in payloads** - Context only contains necessary fields
2. **Validate recipient emails** - Use Laravel's email validation
3. **Rate limit automation** - Prevent spam via duplicate windows

---

**Version:** 1.0.0  
**Last Updated:** May 2026

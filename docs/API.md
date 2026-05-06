# API Documentation - Plexora ERP

## Overview

This document describes the RESTful API endpoints available in the Plexora ERP system. All endpoints use JSON for request/response bodies.

**Base URL:** `https://your-domain.com/api`

**Authentication:** Bearer Token (Laravel Sanctum)

**Content-Type:** `application/json`

---

## Authentication

### Login

Authentication is handled via Laravel Breeze authentication endpoints.

**Endpoint:** `POST /api/login`

**Request:**
```json
{
    "email": "user@example.com",
    "password": "your-password",
    "remember": false
}
```

**Response (Success):**
```http
HTTP/1.1 200 OK
{
    "token": "1|abcdefghij1234567890",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com",
        "role": {
            "id": 2,
            "name": "supplier"
        }
    }
}
```

**Response (Error):**
```http
HTTP/1.1 401 Unauthorized
{
    "message": "These credentials do not match our records."
}
```

### Logout

**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```http
HTTP/1.1 200 OK
{
    "message": "Successfully logged out"
}
```

### Get Current User

**Endpoint:** `GET /api/user`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```http
HTTP/1.1 200 OK
{
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "role": {
        "id": 2,
        "name": "supplier",
        "label": "Supplier"
    },
    "status": "active"
}
```

---

## Support Bot API

### Send Chat Message

**Endpoint:** `POST /api/support/chat`

**Note:** This endpoint does NOT require authentication. It's designed for public-facing customer support chat.

**Request:**
```json
{
    "message": "Where is my order?"
}
```

**Response (Success):**
```http
HTTP/1.1 200 OK
{
    "reply": "Please share your order number."
}
```

**Response (Validation Error):**
```http
HTTP/1.1 422 Unprocessable Entity
{
    "message": "The message field is required.",
    "errors": {
        "message": ["The message field is required."]
    }
}
```

**Behavior:**
- Message is processed by `SupportBotService`
- Returns keyword-matched reply
- Default reply: "Support team will contact you soon."

---

## E-Commerce API

### List Products

**Endpoint:** `GET /api/products`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| search | string | Search by name or SKU |
| supplier_id | int | Filter by supplier |
| min_stock | int | Filter products with stock below value |
| status | boolean | Filter by active status |

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "supplier_id": 5,
            "sku": "PRD-001",
            "name": "Premium Widget",
            "description": "High quality widget",
            "price": "29.99",
            "stock": 150,
            "moq": 10,
            "status": true,
            "is_low_stock": false,
            "created_at": "2026-05-01T10:30:00.000000Z",
            "updated_at": "2026-05-06T08:15:00.000000Z"
        }
    ],
    "links": {
        "first": "/api/products?page=1",
        "last": "/api/products?page=5",
        "prev": null,
        "next": "/api/products?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "path": "/api/products",
        "per_page": 15,
        "to": 15
    }
}
```

### Get Product Details

**Endpoint:** `GET /api/products/{id}`

**Response:**
```http
HTTP/1.1 200 OK
{
    "id": 1,
    "supplier_id": 5,
    "sku": "PRD-001",
    "name": "Premium Widget",
    "description": "<p>High quality widget with features</p>",
    "price": "29.99",
    "stock": 150,
    "moq": 10,
    "status": true,
    "supplier": {
        "id": 5,
        "company_name": "Widget Supplier Inc."
    },
    "created_at": "2026-05-01T10:30:00.000000Z"
}
```

### Create Product

**Endpoint:** `POST /api/products`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**
```json
{
    "name": "New Product",
    "sku": "PRD-002",
    "description": "Product description",
    "price": "49.99",
    "stock": 100,
    "moq": 5,
    "status": true
}
```

**Response:**
```http
HTTP/1.1 201 Created
{
    "id": 2,
    "supplier_id": 5,
    "name": "New Product",
    "sku": "PRD-002",
    "description": "Product description",
    "price": "49.99",
    "stock": 100,
    "moq": 5,
    "status": true,
    "created_at": "2026-05-06T09:00:00.000000Z"
}
```

### Update Product

**Endpoint:** `PUT/PATCH /api/products/{id}`

**Request:** Same as create, fields to update

### Delete Product

**Endpoint:** `DELETE /api/products/{id}`

**Response:**
```http
HTTP/1.1 200 OK
{
    "message": "Product deleted successfully"
}
```

---

## Order API

### List Orders

**Endpoint:** `GET /api/orders`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| status | string | Filter by status |
| customer_id | int | Filter by customer |
| order_number | string | Filter by order number |

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "customer_id": 3,
            "order_number": "ORD-2026-001",
            "subtotal": "149.97",
            "discount": "0.00",
            "tax": "12.00",
            "grand_total": "161.97",
            "status": "confirmed",
            "notes": "Leave at front door",
            "items": [
                {
                    "id": 1,
                    "product_id": 1,
                    "quantity": 3,
                    "unit_price": "49.99",
                    "total": "149.97"
                }
            ],
            "created_at": "2026-05-06T10:00:00.000000Z"
        }
    ]
}
```

### Get Order Details

**Endpoint:** `GET /api/orders/{id}`

**Response:**
```http
HTTP/1.1 200 OK
{
    "id": 1,
    "customer_id": 3,
    "customer": {
        "id": 3,
        "name": "Jane Smith",
        "email": "jane@example.com"
    },
    "order_number": "ORD-2026-001",
    "subtotal": "149.97",
    "discount": "0.00",
    "tax": "12.00",
    "grand_total": "161.97",
    "status": "confirmed",
    "notes": "Leave at front door",
    "items": [
        {
            "id": 1,
            "product_id": 1,
            "product": {
                "id": 1,
                "sku": "PRD-001",
                "name": "Premium Widget"
            },
            "quantity": 3,
            "unit_price": "49.99",
            "total": "149.97"
        }
    ],
    "created_at": "2026-05-06T10:00:00.000000Z"
}
```

### Create Order

**Endpoint:** `POST /api/orders`

**Request:**
```json
{
    "customer_id": 3,
    "items": [
        {
            "product_id": 1,
            "quantity": 3
        }
    ],
    "notes": "Customer request"
}
```

### Update Order Status

**Endpoint:** `PUT /api/orders/{id}/status`

**Request:**
```json
{
    "status": "shipped"
}
```

---

## Automation API

### List Automation Rules

**Endpoint:** `GET /api/automation`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "name": "Order placed email confirmation",
            "event": "order_placed",
            "condition": null,
            "action": "send_email",
            "target": null,
            "is_active": true,
            "created_at": "2026-05-01T00:00:00.000000Z"
        }
    ]
}
```

### Create Automation Rule

**Endpoint:** `POST /api/automation`

**Request:**
```json
{
    "name": "Low stock alert",
    "event": "stock_low",
    "condition": "stock < 5",
    "action": "notify_supplier",
    "target": "supplier@example.com",
    "is_active": true
}
```

### Execute Rule Logically (Run Rule)

**Endpoint:** `POST /api/automation/{id}/run`

**Response:**
```http
HTTP/1.1 200 OK
{
    "message": "Rule executed successfully",
    "results": [
        {
            "rule": "Low stock alert",
            "status": "success",
            "target": "supplier@example.com"
        }
    ]
}
```

### View Automation Logs

**Endpoint:** `GET /api/automation/logs`

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "automation_rule_id": 1,
            "event": "order_placed",
            "status": "success",
            "message": "{\"order_id\":1,\"order_number\":\"ORD-2026-001\"}",
            "created_at": "2026-05-06T10:05:00.000000Z"
        }
    ]
}
```

---

## Campaign API

### List Campaigns

**Endpoint:** `GET /api/campaigns`

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| type | string | marketing, social |
| channel | string | email, sms, facebook |
| status | string | draft, scheduled, sent |

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "name": "New Customer Welcome",
            "type": "marketing",
            "channel": "email",
            "subject": "Welcome to Plexora!",
            "content": "Hi {customer_name}, welcome to our platform!",
            "status": "sent",
            "scheduled_at": "2026-05-06T09:00:00.000000Z",
            "created_by": 1,
            "created_at": "2026-05-01T10:00:00.000000Z"
        }
    ]
}
```

### Create Campaign

**Endpoint:** `POST /api/campaigns`

**Request:**
```json
{
    "name": "Abandoned Cart Reminder",
    "type": "marketing",
    "channel": "email",
    "subject": "Don't forget your cart!",
    "content": "Hi {customer_name}, items in your cart are waiting.",
    "trigger_event": "campaign_scheduled",
    "is_active": true
}
```

### Run Campaign

**Endpoint:** `POST /api/campaigns/{id}/run`

**Response:**
```http
HTTP/1.1 200 OK
{
    "message": "Campaign started",
    "queued": 150
}
```

---

## Support Ticket API

### List Support Tickets

**Endpoint:** `GET /api/support/tickets`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| status | string | open, pending, resolved |
| priority | string | low, medium, high, urgent |
| category | string | order, payment, delivery |

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "customer_id": 3,
            "order_id": 1,
            "subject": "Order delivery issue",
            "message": "Package not received",
            "category": "delivery",
            "priority": "high",
            "status": "open",
            "customer": {
                "id": 3,
                "name": "Jane Smith"
            },
            "created_at": "2026-05-06T08:00:00.000000Z"
        }
    ]
}
```

### Create Ticket

**Endpoint:** `POST /api/support/tickets`

**Request:**
```json
{
    "customer_id": 3,
    "order_id": 1,
    "subject": "Order delivery issue",
    "message": "Package was not delivered on time",
    "category": "delivery",
    "priority": "high"
}
```

### Reply to Ticket

**Endpoint:** `POST /api/support/tickets/{id}/reply`

**Request:**
```json
{
    "message": "We're investigating this issue.",
    "is_private": false
}
```

### Update Ticket Status

**Endpoint:** `PATCH /api/support/tickets/{id}/status`

**Request:**
```json
{
    "status": "resolved"
}
```

---

## RFQ (Request for Quotation) API

### List RFQs

**Endpoint:** `GET /api/rfqs`

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "buyer_id": 3,
            "supplier_id": 5,
            "title": "Bulk Order Request",
            "description": "Need 500 units",
            "quantity": 500,
            "status": "pending",
            "created_at": "2026-05-06T07:00:00.000000Z"
        }
    ]
}
```

### Create RFQ

**Endpoint:** `POST /api/rfqs`

**Request:**
```json
{
    "supplier_id": 5,
    "title": "Bulk Widget Order",
    "description": "Need 1000 units for upcoming sale",
    "quantity": 1000
}
```

---

## Reporting & Analytics API

### Low Stock Report

**Endpoint:** `GET /api/inventory/low-stock`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 2,
            "name": "Economy Widget",
            "sku": "PRD-003",
            "stock": 3,
            "moq": 10,
            "is_low_stock": true,
            "supplier": {
                "company_name": "Widget Supplier Inc."
            }
        }
    ],
    "total": 5,
    "summary": {
        "total_products": 150,
        "low_stock_count": 5,
        "total_low_stock_value": "149.95"
    }
}
```

### Customer Sales Report

**Endpoint:** `GET /api/reports/sales-by-customer`

**Response:**
```http
HTTP/1.1 200 OK
{
    "data": [
        {
            "customer_id": 3,
            "customer_name": "Jane Smith",
            "order_count": 15,
            "total_spent": "2459.85",
            "avg_order_value": "163.99"
        }
    ]
}
```

---

## Webhook Endpoints

### Support Bot Webhook (Incoming)

**Endpoint:** `POST /api/support/chat`

This endpoint receives messages from external chat platforms.

**Request:**
```json
{
    "platform": "facebook",
    "sender_id": "user123",
    "message": "Where is my order?"
}
```

**Response:**
```http
HTTP/1.1 200 OK
{
    "recipient_id": "user123",
    "message": "Please share your order number.",
    "action": "awaiting_order_number"
}
```

---

## Error Responses

### Validation Error

```http
HTTP/1.1 422 Unprocessable Entity
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "message": ["The message field is required."]
    }
}
```

### Authorization Error

```http
HTTP/1.1 403 Forbidden
{
    "message": "This action is unauthorized."
}
```

### Not Found

```http
HTTP/1.1 404 Not Found
{
    "message": "No query results for model [App\\Models\\Product] 999."
}
```

### Server Error

```http
HTTP/1.1 500 Internal Server Error
{
    "message": "Server error message"
}
```

---

## Rate Limiting

API requests are rate limited by default:

- **Authenticated:** 60 requests per minute
- **Unauthenticated:** 10 requests per minute

Exceeding limits returns:
```http
HTTP/1.1 429 Too Many Requests
{
    "message": "Too many requests."
}
```

---

## Versioning

Current API version: **v1**

All endpoints are under `/api` prefix. Future versions will use `/api/v2`.

---

## Postman Collection

A Postman collection is available at:
`/docs/postman-collection.json`

To import:
1. Open Postman
2. Click "Import"
3. Select the JSON file
4. Set environment variable `BASE_URL`

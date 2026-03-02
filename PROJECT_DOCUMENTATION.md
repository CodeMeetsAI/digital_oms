# Project Documentation: Multi-Tenant Order Management System (OMS)

## 1. Project Architecture

The project is a high-performance **Multi-Tenant Order Management System (OMS)** built on the **Laravel** framework. It leverages the `stancl/tenancy` package to provide a robust multi-database multi-tenancy architecture.

### Core Architectural Patterns:
- **Multi-Tenancy (Database-per-Tenant)**: Each tenant has its own isolated database, ensuring data security and performance scalability.
- **Domain-Based Identification**: Tenants are identified via subdomains or custom domains (e.g., `tenant1.oms.com`).
- **Service-Oriented Integrations**: Specialized services for interacting with third-party APIs (WooCommerce, Daraz, Leopards).
- **Reactive UI**: Uses **Laravel Livewire** for dynamic forms and real-time updates without full page reloads.

---

## 2. Folder Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── API/             # API endpoints
│   │   ├── Central/         # Central domain logic (registration, tenant lookup)
│   │   ├── Integrations/    # Platform-specific sync logic (WooCommerce, Daraz)
│   │   ├── Order/           # Order management logic
│   │   └── Tenancy/         # Tenant-specific lifecycle controllers
│   ├── Livewire/            # Reactive components (OrderForm, ProductCart)
│   └── Middleware/          # Tenancy and Auth filters
├── Models/                  # Eloquent models (Tenant, Order, Product, etc.)
├── Providers/               # TenancyServiceProvider, AppServiceProvider
└── Services/                # External API Clients (WooCommerceClient, DarazClient)

database/
├── migrations/              # Central database migrations (tenants, domains)
└── migrations/tenant/       # Tenant-specific migrations (orders, products)

routes/
├── web.php                  # Central domain routes
├── tenant.php               # Business logic routes for tenants
└── api.php                  # API routes
```

---

## 3. Database Schema

### Central Database
- **tenants**: Stores tenant metadata and database connection info.
- **domains**: Maps domains/subdomains to specific tenants.
- **integrations**: Global list of available platforms.

### Tenant Database (Isolated)
- **users**: Tenant-specific administrators and staff.
- **products / categories / units**: Inventory management.
- **bundles / bundle_items**: Composite products.
- **customers / suppliers**: CRM and Vendor management.
- **orders / order_details**: Sales transactions and line items.
- **purchases / purchase_details**: Procurement from suppliers.
- **quotations**: Customer price estimates.
- **chart_of_accounts**: Basic financial tracking.
- **woo_integrations / daraz_integrations**: Tenant-specific API credentials.

---

## 4. Full System Workflow

### User Interaction Flow
1.  **Registration**: A new user registers on the central domain.
2.  **Provisioning**: The system creates a new database and runs tenant-specific migrations automatically.
3.  **Initialization**: The user is redirected to their own subdomain (e.g., `user.localhost`).
4.  **Configuration**: User configures products, suppliers, and external store integrations.
5.  **Operation**:
    - **Pull**: Orders are pulled from WooCommerce/Daraz (Planned/In-Progress).
    - **Process**: Orders are managed through "Pending", "Processing", and "Completed" states.
    - **Stock**: Inventory levels are updated automatically upon order completion.
    - **Invoice**: PDF invoices are generated for customers.

---

## 5. Integration Systems

The project includes specialized logic for connecting to external marketplaces and shipping providers:

- **WooCommerce**: Connects via REST API (Consumer Key/Secret). Supports syncing products and orders.
- **Daraz**: Connects via Daraz Open Platform API. Handles store-specific orders and inventory.
- **Leopards**: Shipping integration for automated tracking and fulfillment.

*Note: The current implementation focuses on credential management and testing. Full automated background synchronization logic is handled via scheduled tasks in `Console/Kernel.php`.*

---

## 6. Authentication System

- **Multi-Auth aware**: Uses standard Laravel authentication but scoped to the current tenant context.
- **Security**: Tenant-specific sessions and cookies prevent cross-tenant access.
- **Middleware**: `InitializeTenancyByDomain` ensures that every request is routed to the correct database before authentication is checked.

---

## 7. Developer Summary & Issues

### Current Status:
The system is highly modular and prepared for scale. Core OMS features (Orders, Products, Customers) are fully functional.

### Identified Improvements:
1.  **Integration Depth**: Need to expand the background sync jobs for WooCommerce/Daraz to handle edge cases in stock synchronization.
2.  **Automation Module**: The `Automation` feature is a skeleton and requires implementation of "If-This-Then-That" logic for order workflows.
3.  **Refactoring**: Several controllers (`OrderController`, `PurchaseController`) contain legacy logic that can be moved into Service classes for better testability.
4.  **Error Handling**: API interaction with Daraz/WooCommerce needs more robust logging and retry mechanisms.

---
*Documentation generated on: 2026-03-02*

# OneTech E-Commerce Platform

A modern e-commerce platform built with Laravel 12, providing a complete shopping experience including product management, category management, shopping cart, wishlist, order processing, user authentication, role management, email verification, password recovery, and Paymob payment integration.

---

## Features

### Authentication & Authorization

* User Registration
* User Login
* User Logout
* Email Verification
* Forgot Password
* Password Reset
* Role-Based Access Control (RBAC)
* Spatie Laravel Permission Integration

### Product Management

* Product CRUD Operations
* Product Image Management
* Product Import
* Product Export
* Download Import Templates

### Category Management

* Category CRUD Operations
* Product Categorization

### Shopping Experience

* Shopping Cart
* Wishlist
* Product Search
* Product Details Page
* Category Filtering

### Orders & Checkout

* Checkout Process
* Order Placement
* Order Tracking
* Order Management

### Payments

* Paymob Payment Gateway Integration
* Payment Success Callback
* Payment Webhook Processing

### User Account

* Account Dashboard
* Order History
* Order Details

### Localization

* Multi-language Support
* Dynamic Language Switching

---

## Tech Stack

### Backend

* Laravel 12
* PHP 8.4
* MySQL

### Frontend

* Blade Templates
* Bootstrap 5
* JavaScript
* jQuery
* AJAX

### Authentication

* Laravel Authentication
* Email Verification
* Password Reset

### Authorization

* Spatie Laravel Permission

### Mail

* Laravel Mailables
* Queue Support

### Payments

* Paymob

---

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── FrontendController.php
│   │   ├── DashboardController.php
│   │   ├── AccountController.php
│   │   ├── CartController.php
│   │   ├── WishlistController.php
│   │   ├── CheckoutController.php
│   │   ├── ProductController.php
│   │   ├── CategoryController.php
│   │   ├── OrderController.php
│   │   ├── PaymentController.php
│   │   └── PaymobWebhookController.php
│   │
│   ├── Middleware/
│   ├── Requests/
│   └── Services/
│
├── Mail/
├── Models/
├── Jobs/
├── Notifications/
│
database/
├── migrations/
├── seeders/
│
resources/
├── views/
│
routes/
├── web.php
```

---

## Core Modules

### Authentication Module

Responsible for:

* Registration
* Login
* Logout
* Email Verification
* Password Recovery

Features:

* Email verification required before login
* Signed URLs for verification links
* Password hashing
* Session regeneration after login
* Login rate limiting

---

### Authorization Module

Powered by Spatie Laravel Permission.

Default Roles:

* admin
* user

Middleware:

```php
role
permission
role_or_permission
```

Example:

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    //
});
```

---

### Product Module

Features:

* Create Products
* Edit Products
* Delete Products
* Manage Product Images
* Product Import
* Product Export

---

### Category Module

Features:

* Create Categories
* Edit Categories
* Delete Categories
* Category Sorting

---

### Cart Module

Features:

* Add To Cart
* Remove From Cart
* Update Quantity
* Guest Cart Support
* Cart Synchronization After Login

---

### Wishlist Module

Features:

* Add To Wishlist
* Remove From Wishlist
* Wishlist Synchronization After Login

---

### Checkout Module

Features:

* Review Cart
* Calculate Totals
* Create Orders
* Redirect To Payment Gateway

---

### Order Module

Features:

* Order Management
* Order Status Tracking
* Customer Order History
* Order Details

---

### Payment Module

Provider:

* Paymob

Features:

* Payment Initialization
* Payment Verification
* Success Callback
* Webhook Processing

---

### Localization Module

Features:

* Dynamic Language Switching
* Session-Based Locale Storage

Example:

```url
/lang/en
/lang/ar
```

---

## Installation

### Clone Repository

```bash
git clone https://github.com/your-username/onetech.git
cd onetech
```

### Install Dependencies

```bash
composer install
npm install
```

### Environment Configuration

Copy the environment file:

```bash
cp .env.example .env
```

Configure your environment variables:

```env
APP_NAME=OneTech

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=

PAYMOB_API_KEY=
PAYMOB_INTEGRATION_ID=
PAYMOB_IFRAME_ID=

ADMIN_NAME=Admin
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=ChangeMe123
```

### Generate Application Key

```bash
php artisan key:generate
```

### Run Migrations

```bash
php artisan migrate
```

### Seed Database

```bash
php artisan db:seed
```

### Create Storage Link

```bash
php artisan storage:link
```

### Build Frontend Assets

```bash
npm run build
```

### Run Development Server

```bash
php artisan serve
```

---

## Default Admin Account

The default administrator account is created using environment variables.

```env
ADMIN_NAME=Admin
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=ChangeMe123
```

The account is generated through:

```php
AdminUserSeeder
```

---

## Queue Worker

Required for:

* Sending Emails
* Background Jobs
* Notifications

Run locally:

```bash
php artisan queue:work
```

Production environments should use Supervisor.

Example Supervisor command:

```bash
php artisan queue:work --tries=3 --timeout=90
```

---

## Email Features

### Verification Email

Sent after successful registration.

### Password Reset Email

Uses:

* Temporary Signed URLs
* Expiration Time
* Secure Verification Flow

Example:

```php
Mail::to($user->email)
    ->queue(
        new ForgetPassword($url)
    );
```

---

## Security Features

* CSRF Protection
* Password Hashing
* Signed URLs
* Email Verification
* Session Regeneration
* Login Rate Limiting
* Role-Based Authorization
* Permission-Based Authorization

---

## Main Routes

### Authentication

```text
/register
/login
/logout
/forgot-password
/reset-password
/email/verify
```

### Store

```text
/
/products
/product-details/{slug}
/cart
/wishlist
/checkout
```

### User Account

```text
/account
/orders
/order-details/{id}
```

### Dashboard

```text
/dashboard
/categories
/products
/orders
/users
```

### Localization

```text
/lang/{locale}
```

---

## Database Seeders

### RolesSeeder

Creates application roles.

```text
admin
user
```

### PermissionsSeeder

Creates application permissions.

### AdminUserSeeder

Creates the default administrator account.

---

## Development Standards

### Authentication

* Email verification required.
* Passwords stored using Laravel hashing.
* Session regenerated after successful login.

### Authorization

* Use Roles for user classification.
* Use Permissions for fine-grained access control.

### Mail

* Queue-enabled Mailables.
* Blade-based email templates.

### Database

* Use migrations for schema changes.
* Use seeders for default data.

---

## Future Improvements

* Coupons & Discounts
* Product Reviews
* Inventory Management
* Notifications Center
* Activity Logs
* Advanced Reporting
* REST API
* Mobile Application Support
* Multi-Vendor Marketplace
* SEO Management

---

## License

This project is available for educational and commercial use. Modify and extend it according to your business requirements.

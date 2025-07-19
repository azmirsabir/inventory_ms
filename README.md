# Inventory Management System (Laravel)

A backend API for a **Multi-Warehouse, Multi-Country Inventory Management System** built using Laravel. This system allows the management of inventory, suppliers, and transactions across multiple warehouses located in various countries, with a strong emphasis on maintainable architecture and clear documentation.

---

### Code Structure

* Follows **SOLID** principles
* Uses **Repository Pattern**, **Service Layer**, and **Resource Controllers**

---

## 📁 Project Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/azmirsabir/inventory_ms.git
cd inventory_ms
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update the following environment variables in `.env`:

### 4. Change Database Configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=root
DB_PASSWORD=secret
```

### 5. Change Mail Configuration:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=admin@example.com
MAIL_FROM_NAME="Inventory System"
```

### 6. Change Slack Notification URL(for low stock report):

```env
SLACK_URL=https://hooks.slack.com/services/your/webhook/url
```

### 7. Low Stock Report Email:

```env
LOW_STOCK_REPORT_MAIL=manager@example.com
```

### 8. Migrations & Seeders

```bash
php artisan migrate --seed
```

### 9. Serve App

```bash
php artisan serve
```

---

## Testing & Scheduler

Note: test the unit testing on .env.testing environment
```bash
php artisan test  # manual run
```

## Scheduler
To enable scheduler:

```bash
0 0 * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1
```

---

## Admin Login (Test)

```text
Email: test@example.com
Password: password
```

---

## 📦 Deliverables

* GitHub Repository with:

    * Clean Laravel Project
    * Setup Instructions in README
    * Unit Tests
    * Swagger Documentation
* Postman Collection

---

## Contact

For questions, email `azmirsabir1@gmail.com`
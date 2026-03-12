# Smart Invoice & Client Management System

A production-ready Laravel 11 application for freelancers and small businesses to manage clients, invoices, payments, and reporting with ease.

## 🚀 Features

- **Client Management**: Full CRUD operations for managing client profiles and history.
- **Invoice Management**: 
  - Dynamic line items with auto-calculations.
  - Automatic status tracking (Draft, Sent, Paid, Overdue).
  - PDF generation using DomPDF.
  - One-click email delivery with PDF attachments.
- **Payment Tracking**: Record and track payments against invoices with automatic balance updates.
- **Role-Based Access Control (RBAC)**:
  - **Admin**: Full access to all modules, reports, and administrative tasks.
  - **Staff**: Manage clients and invoices, but restricted from sensitive reports and deletions.
- **Reporting Dashboard**:
  - Revenue analytics.
  - Outstanding balances tracking.
  - Tax and discount summaries.
- **RESTful API**: Secure API endpoints for integration with other services.

## 🛠️ Technology Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Database**: MySQL
- **Frontend**: Blade Templates, Tailwind CSS
- **Authentication**: Laravel Breeze
- **PDF Generation**: DomPDF
- **Email**: Laravel Mail (Mailhog/Mailtrap ready)

## 📦 Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/client-management-system.git
   cd client-management-system
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**:
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=client_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

## 🔐 Default Credentials

- **Admin Account**: `admin@example.com` / `password`
- **Staff Account**: `staff@example.com` / `password`

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

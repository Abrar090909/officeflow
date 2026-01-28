# OfficeFlow – Employee Task & Approval System (Pro Version)

OfficeFlow is a robust, full-stack Task & Approval system built with **Laravel 12**, **MySQL/SQLite**, and **jQuery AJAX**. This project is structured with professional design patterns suitable for a Full-stack Developer interview.

## 🚀 Key Features
- **Role-Based Workflows**: Dedicated dashboards for Employees and Managers.
- **Service Layer Pattern**: Business logic is decoupled from controllers into `TaskService`.
- **Policy-Based Authorization**: Fine-grained access control using Laravel Policies.
- **AJAX-First Interaction**: Create, delete, and update tasks/comments without page reloads.
- **File Attachments**: Support for image and document uploads for task context.
- **Visual Analytics**: Interactive dashboard statistics for both roles.

## 🛠 Tech Stack
- **Backend**: Laravel 12 (Service Pattern, Policies, Form Requests)
- **Database**: SQLite (Zero-config) or MySQL
- **Frontend**: Blade, Bootstrap 5, jQuery 3.7 (AJAX & FormData)

## 📁 Architecture Highlights
- **Service Layer**: `app/Services/TaskService.php` centralizes data persistence and file handling.
- **Authorization**: `app/Policies/TaskPolicy.php` ensures employees only manage their own tasks.
- **Validation**: `app/Http/Requests/StoreTaskRequest.php` handles clean input sanitization.
- **Middleware**: Custom `RoleMiddleware.php` protects routes based on user types.

## 🚀 Setup Instructions

1. **Clone & Install**:
   ```bash
   composer install
   npm install
   ```

2. **Environment**:
   The project is pre-configured for **SQLite**. To use MySQL, update `.env`.

3. **Database Setup & Seed (Critical for Demo)**:
   This will reset the DB and create professional sample data.
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Default Credentials**:
   - **Manager**: `manager@officeflow.com` (pw: `password`)
   - **Employee**: `employee@officeflow.com` (pw: `password`)

5. **Start Server**:
   ```bash
   php artisan serve
   ```

## 📝 Note to Interviewer
This project demonstrates proficiency in Laravel's ecosystem beyond basic CRUD, specifically focusing on **logic centralization**, **modular validation**, and **asynchronous frontend interactions**.

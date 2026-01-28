# OfficeFlow - Task Management System

A professional Laravel-based task management system with role-based access control, real-time status updates, and comprehensive activity tracking.

## 🌟 Features

### Core Functionality
- **Dual Role System**: Separate interfaces for Employees and Managers
- **Task Management**: Create, update, delete, and track tasks with priorities
- **Status Workflow**: Pending → In Review → Approved/Rejected
- **Real-time Updates**: AJAX-powered interface for seamless user experience
- **File Attachments**: Support for task-related documents and images

### Advanced Features
- **Task Deadlines**: Due date tracking with overdue indicators
- **Categories**: Organize tasks by Bug, Feature, Support, or General
- **Activity Feed**: System-wide activity stream tracking all task events
- **Advanced Filtering**: Multi-criteria search and filtering on dashboards
- **Priority Management**: High, Medium, Low priority levels with visual badges

### Security & Architecture
- **Authentication**: Secure login/registration with password hashing
- **Authorization**: Laravel Policies for resource-level access control
- **Service Layer**: Clean separation of business logic and controllers
- **RESTful API**: Formal REST API endpoints for all operations
- **Form Requests**: Strict validation with custom request classes

## 🚀 Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Bootstrap 5, jQuery, Blade Templates
- **Database**: SQLite (easily switchable to MySQL/PostgreSQL)
- **Authentication**: Laravel Auth with session management

## 📦 Local Installation

```bash
# Clone the repository
git clone https://github.com/Abrar090909/officeflow.git
cd officeflow

# Install dependencies
composer install

# Create environment file
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```

Visit `http://127.0.0.1:8000`

### Demo Accounts

- **Manager**: `manager@officeflow.com` / `password`
- **Employee**: `employee@officeflow.com` / `password`

## 🚂 Railway Deployment

### Quick Deploy

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/Abrar090909/officeflow)

### Manual Deployment

1. **Create Railway Account**
   - Go to [railway.app](https://railway.app)
   - Sign up with GitHub

2. **Create New Project**
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose `Abrar090909/officeflow`

3. **Configure Environment Variables**
   
   Railway will auto-detect Laravel, but add these variables:
   
   ```
   APP_NAME=OfficeFlow
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:QBgOwLW0AoJKUHwzomU7Cwg7mxRSEGtscdzpMwy1eBU=
   APP_URL=https://your-app.railway.app
   
   DB_CONNECTION=sqlite
   
   SESSION_DRIVER=cookie
   SESSION_LIFETIME=120
   
   CACHE_DRIVER=file
   QUEUE_CONNECTION=sync
   
   LOG_CHANNEL=stderr
   ```

4. **Deploy**
   - Railway auto-deploys on every push to `main`
   - First deployment runs migrations and seeders automatically
   - Check logs for deployment status

5. **Access Your App**
   - Railway provides a public URL: `https://officeflow-production.up.railway.app`
   - Login with demo credentials

### Post-Deployment (Optional)

If you need to re-run migrations or seeders:

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link to your project
railway link

# Run commands
railway run php artisan migrate:fresh --seed
```

## 📁 Project Structure

```
office-flow/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # MVC Controllers
│   │   ├── Middleware/      # Custom middleware (RoleMiddleware)
│   │   └── Requests/        # Form Request validation classes
│   ├── Models/              # Eloquent models
│   ├── Policies/            # Authorization policies
│   └── Services/            # Business logic layer
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/             # Demo data seeders
├── resources/
│   └── views/
│       ├── auth/            # Login & Registration
│       ├── employee/        # Employee dashboard
│       ├── manager/         # Manager dashboard
│       └── layouts/         # Shared layouts
└── routes/
    ├── web.php              # Web routes
    └── api.php              # REST API routes
```

## 🎯 Key Highlights

### For Interview Discussion

1. **Architecture**:
   - Service Layer Pattern for business logic encapsulation
   - Repository-like data access through Eloquent ORM
   - Policy-based authorization for fine-grained access control

2. **Code Quality**:
   - PSR-12 compliant PHP code
   - Form Request validation classes
   - Clean, commented, maintainable codebase

3. **Modern Features**:
   - RESTful API architecture
   - AJAX-powered SPA-like experience
   - Real-time activity feed
   - Advanced filtering and search

4. **UI/UX**:
   - Responsive Bootstrap 5 design
   - Clean, professional WordPress-inspired aesthetic
   - Intuitive role-specific interfaces

## 🔒 Security Features

- Password hashing with Bcrypt
- CSRF protection on all forms
- Session management with regeneration
- Input validation and sanitization
- Role-based access control

## 🛠️ Troubleshooting

### Common Issues

**Database not found:**
```bash
railway run php artisan migrate:fresh --seed
```

**File permissions:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Clear cache:**
```bash
railway run php artisan cache:clear
railway run php artisan config:clear
```

## 📝 License

This project is open-source and available for educational and commercial use.

## 👨‍💻 Author

**Abrar Ahmed**
- GitHub: [@Abrar090909](https://github.com/Abrar090909)

---

Built with ❤️ using Laravel

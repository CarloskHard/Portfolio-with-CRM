# DevPortfolio CMS - Full Stack & Project Guide

## 📌 What is This Project?

A professional portfolio management system with an integrated **CRM** (Customer Relationship Management). It has two faces:

1. **Public Portfolio** - A beautiful landing page showing your projects and allowing people to contact you
2. **Admin Dashboard** - A complete management system where you organize clients, projects, messages, and contacts

---

## 🛠️ Full Technology Stack Explained

### **Backend: Laravel + PHP**

**What is Laravel?** A PHP framework that makes building web applications easier. Think of it as a blueprint system that organizes your code.

- **PHP 8.2** - The programming language (modern, fast, type-safe)
- **Laravel 12** - The framework (handles routing, database, authentication, security)
- **Key concepts:**
  - **MVC Pattern** - Models (data), Views (pages), Controllers (logic)
  - **Eloquent ORM** - Easy way to talk to the database using PHP code instead of raw SQL
  - **Middleware** - Security checks that run before your page loads

### **Frontend: Blade Templates + Alpine.js + Tailwind CSS**

**Why not React/Vue?** This is a server-rendered app, not a Single-Page Application (SPA). Each navigation refreshes the page, which is simpler and perfectly fine for a CRM.

| Technology | Purpose |
|---|---|
| **Blade** | Template engine (PHP + HTML). Server generates the HTML, sends it to browser. |
| **Alpine.js** | Lightweight JavaScript for small interactive features (dark mode toggle, form validation) without needing a heavy framework. |
| **Tailwind CSS** | Utility-first CSS - pre-made classes for styling (no custom CSS needed). Fast to build responsive designs. |

### **Database: MySQL 8.0**

Relational database that stores all your data:
- Users (admin accounts)
- Projects (your portfolio work)
- Clients (companies/people you've worked with)
- Contacts (employees within companies)
- Messages (inquiries from your website)
- Technologies (tech stack tags for projects)

**Why relational?** Relationships matter: a project belongs to a client, a contact belongs to a company, messages link to clients. MySQL enforces these relationships.

### **Environment: Docker + Laravel Sail**

**Docker** = Virtual machine that packages everything (PHP, MySQL, Node.js) so your app runs identically everywhere.

**Laravel Sail** = Simple command wrapper around Docker. Instead of typing complex Docker commands, you type `./vendor/bin/sail artisan migrate`.

**What happens when you run `./vendor/bin/sail up -d`:**
1. Starts PHP 8.2 container (your app)
2. Starts MySQL container (database)
3. Starts PHPMyAdmin container (database GUI for debugging)
4. Starts Mailpit container (catches test emails)

---

## 🏗️ Project Architecture

### **Database Relationships (How Data Connects)**

```
User (Admin)
  ↓
  └── Projects (many)
      ├── Technologies (many-to-many pivot table)
      ├── Client (belongs to one)
      └── Messages (many incoming from website)

Client (Company/Individual)
  ├── Contacts (many) [employees, decision makers]
  │   └── Contact Methods (email, phone, etc.)
  └── Messages (many) [incoming inquiries]
```

### **Folder Structure (What Lives Where)**

```
app/
├── Http/Controllers/
│   ├── ProjectController.php     ← Add, edit, delete projects
│   ├── ClientController.php      ← Manage clients (CRM)
│   ├── ContactController.php     ← Manage contacts within clients
│   ├── MessageController.php     ← Inbox management
│   └── PortfolioController.php   ← Public portfolio display
├── Models/
│   ├── Project.php               ← Project data structure
│   ├── Client.php                ← Client data structure
│   ├── Contact.php               ← Contact data structure
│   ├── Message.php               ← Message data structure
│   ├── Technology.php            ← Tech tags
│   └── User.php                  ← Admin user
└── Services/
    └── Notifications/            ← Email/SMS/Telegram alerts

resources/views/                  ← HTML pages (Blade templates)
├── auth/                         ← Login, register
├── dashboard/                    ← Admin dashboard
├── projects/                     ← Project management pages
├── clients/                      ← Client management pages
├── messages/                     ← Inbox pages
└── portfolio/                    ← Public website pages

database/migrations/              ← Database schema versions
```

---

## 🔄 How It Works: User Flow

### **For Someone Visiting Your Website:**

1. They land on `yourportfolio.com` (public page)
2. See your projects, bio, tech stack
3. Click "Contact Me" → fill form
4. Submit message

### **For You (Admin):**

1. Log in at `/login` (admin@admin.com / password)
2. Dashboard shows:
   - Total projects
   - Unread messages count
   - Total clients
3. Check inbox for new messages
4. Convert message to client (CRM feature)
5. Manage projects CRUD operations:
   - Add new project with images, tech stack, client
   - Edit existing projects
   - Mark as public/draft
   - Assign technologies
6. Manage clients:
   - Add company/individual
   - Add contacts (employees) within company
   - Track communication history

---

## 🚀 Development Workflow

### **Starting Development**

```bash
# 1. Start Docker containers
./vendor/bin/sail up -d

# 2. Run migrations (setup database)
./vendor/bin/sail artisan migrate:fresh --seed

# 3. Start dev servers (runs everything concurrently)
composer run dev

# This runs:
# - Laravel app server on http://localhost
# - Vite frontend build watcher on http://localhost:5173
# - Queue listener for background jobs
# - Laravel Pail for logs
```

### **Development URLs**

| URL | Purpose |
|---|---|
| http://localhost | Your app (public + admin) |
| http://localhost:8080 | PHPMyAdmin (browse database) |
| http://localhost:8025 | Mailpit (view test emails) |

### **Common Dev Commands**

```bash
# Run migrations (update database schema)
./vendor/bin/sail artisan migrate

# Reset database completely
./vendor/bin/sail artisan migrate:fresh --seed

# Create database seeder data
./vendor/bin/sail artisan db:seed

# Access database shell
./vendor/bin/sail mysql -u root -p

# Run tests
./vendor/bin/sail artisan test

# Format code with Pint
./vendor/bin/sail artisan pint

# Interactive PHP shell (Tinker)
./vendor/bin/sail artisan tinker
```

---

## 🌐 Production Deployment (Your Ionos VPS)

### **Why Docker in Development, Traditional Installation in Production?**

**Development:** Docker keeps your PC clean and gives everyone identical environments.

**Production:** On your Ionos Linux VPS, Docker adds overhead. Traditional install is simpler, faster, and uses fewer resources.

### **Production Setup on Ionos Linux VPS**

**Steps:**

1. **SSH into your VPS**
   ```bash
   ssh root@your-vps-ip
   ```

2. **Install system dependencies**
   ```bash
   apt update && apt install -y nginx php8.2 php8.2-fpm php8.2-mysql composer mysql-server nodejs npm
   ```

3. **Clone your repository**
   ```bash
   cd /var/www
   git clone https://github.com/CarlosBTav/Portfolio-with-CRM.git
   cd Portfolio-with-CRM
   ```

4. **Install dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   ```

5. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --force
   ```

6. **Configure Nginx** (Web server)
   - Point to `public/` directory
   - Set PHP-FPM to handle requests

7. **Setup SSL certificate** (HTTPS)
   ```bash
   # Use Let's Encrypt (free)
   apt install certbot python3-certbot-nginx
   certbot --nginx -d yourdomain.com
   ```

8. **Setup cron for background jobs** (if using notifications)
   ```bash
   * * * * * cd /var/www/Portfolio-with-CRM && php artisan schedule:run >> /dev/null 2>&1
   ```

### **Important: Production Checklist**

- [ ] `.env` has production database credentials
- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Database backups enabled
- [ ] SSL certificate installed (HTTPS)
- [ ] File uploads directory writable
- [ ] Log directory writable
- [ ] Disable default admin account after first login (create your real account)
- [ ] Setup email service (SendGrid, Mailgun, etc.) for real emails
- [ ] Monitor database size and backups

---

## 🎯 Key Features Explained

| Feature | What It Does |
|---|---|
| **Project CRUD** | Add, view, edit, delete your portfolio projects |
| **Client Management** | Track companies/individuals you've worked with |
| **Contact Management** | Store employees within a client (John - CEO, Jane - CTO) |
| **Inbox System** | Receive messages from your website contact form |
| **Lead Conversion** | Convert anonymous message → link to existing client |
| **Dark/Light Mode** | Website theme toggle (persists with cookies) |
| **Image Upload** | Upload project images (stored in storage folder) |
| **Technology Tags** | Assign tech stack to projects (Laravel, React, etc.) |
| **Authentication** | Login system for admin dashboard |
| **Message History** | See all communications linked to a client |

---

## 💡 Best Practices in This Project

### **Code Organization**
- **Controllers** handle HTTP requests
- **Models** handle database logic
- **Views** are HTML templates
- **Services** contain reusable business logic
- Separation of concerns = easier to maintain

### **Database Design**
- **Foreign keys** enforce relationships
- **Timestamps** track when records created/updated
- **Soft deletes** (optional) let you "delete" without losing data
- **Pivot tables** for many-to-many relationships

### **Security**
- **Laravel Breeze** handles authentication properly
- **CSRF protection** on all forms
- **SQL injection prevention** via Eloquent ORM
- **Password hashing** automatic
- **Middleware** validates permissions before accessing pages

---

## 🔧 Common Development Tasks

### **Add a New Field to Project**

1. Create migration: `./vendor/bin/sail artisan make:migration add_field_to_projects`
2. Edit migration file, add your field
3. Run: `./vendor/bin/sail artisan migrate`
4. Update Model `app/Models/Project.php` (add to $fillable array)
5. Update Controller to accept field
6. Update View to display field

### **Add a New Page**

1. Create route in `routes/web.php`
2. Create Controller method
3. Create Blade view file in `resources/views/`
4. Controller returns `view('page-name', $data)`

### **Debug an Issue**

1. Check logs: `tail -f storage/logs/laravel.log`
2. Use Tinker: `./vendor/bin/sail artisan tinker`
3. Query database: `App\Models\Project::first();`
4. Check PHPMyAdmin: `http://localhost:8080`

---

## 📚 Technology Versions (Current)

| Technology | Version | Purpose |
|---|---|---|
| PHP | 8.2+ | Language |
| Laravel | 12.x | Framework |
| MySQL | 8.0+ | Database |
| Node.js | 18+ | Frontend tooling |
| Tailwind CSS | 3.x | Styling |
| Alpine.js | 3.x | Interactivity |
| Vite | 7.x | Frontend build tool |

---

## 🎓 Learning Path

If you're new to Laravel:

1. **Understand MVC** - Models, Views, Controllers
2. **Learn Eloquent** - Database queries using PHP
3. **Routes & Controllers** - How requests are handled
4. **Blade Templates** - HTML with PHP embedded
5. **Middleware** - Security checks
6. **Testing** - Write tests for your code

Resources:
- [Laravel Official Docs](https://laravel.com/docs)
- [Laravel Breeze Authentication](https://laravel.com/docs/breeze)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

---

## ⚡ Quick Reference: Essential Commands

```bash
# Development
./vendor/bin/sail up -d              # Start containers
./vendor/bin/sail down               # Stop containers
composer run dev                      # Run full dev stack

# Database
./vendor/bin/sail artisan migrate    # Run migrations
./vendor/bin/sail artisan seed       # Seed sample data
./vendor/bin/sail artisan tinker     # Interactive shell

# Code Quality
./vendor/bin/sail artisan pint       # Format code
./vendor/bin/sail artisan test       # Run tests

# Utilities
./vendor/bin/sail artisan make:migration <name>  # Create migration
./vendor/bin/sail artisan make:model <name>      # Create model
./vendor/bin/sail artisan make:controller <name> # Create controller
```

---

## 🚨 Common Pitfalls

| Problem | Solution |
|---|---|
| "Class not found" error | Run `./vendor/bin/sail composer dump-autoload` |
| Database not migrating | Check `.env` database credentials match compose.yaml |
| Uploads not saving | Check `storage/` folder permissions: `chmod 775 storage/` |
| Emails not sending | In dev, check Mailpit at `http://localhost:8025` |
| Vite assets not loading | Run `npm run build` after changes |
| Port already in use | Change port in `.env` (APP_PORT, VITE_PORT) |

---

**Last Updated:** 2026-04-29  
**Project Status:** Ready for development & production deployment


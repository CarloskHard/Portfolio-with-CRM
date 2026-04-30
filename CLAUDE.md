# Portfolio-with-CRM: Project Documentation

**Project Type:** Full-Stack Web Application (Laravel + Blade + Alpine.js)  
**Language:** PHP 8.2, JavaScript (ES6+)  
**Framework:** Laravel 12  
**Frontend:** Blade Templates, Tailwind CSS 3, Alpine.js 3  
**Database:** MySQL 8.0  
**Environment:** Docker (Laravel Sail), WSL2

---

## 📋 Project Overview

**DevPortfolio CMS** is a professional portfolio management system with integrated CRM capabilities. It serves two main purposes:

1. **Public Portfolio:** Dynamic landing page showcasing projects, with dark/light mode support
2. **Admin CRM System:** Complete management system for projects, clients, contacts, and communications

### Key Features

- Full-featured admin dashboard with real-time metrics
- Project CRUD with image uploads and technology associations
- Client management (companies/individuals)
- Contact management within clients (employees with roles, phones, notes)
- Inbox system for incoming messages with lead-to-contact conversion
- Message history linked to clients
- Authentication & authorization (Laravel Breeze)
- Dark/Light theme persistence

---

## 🏗️ Architecture & Structure

### MVC Pattern (Laravel)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/               # Authentication controllers
│   │   ├── ClientController    # Client CRUD & CRM
│   │   ├── ContactController   # Contact management within clients
│   │   ├── MessageController   # Inbox & message handling
│   │   ├── ProjectController   # Project CRUD
│   │   └── PortfolioController # Public portfolio display
│   └── Requests/               # Form validation requests
├── Models/
│   ├── User.php               # Authentication
│   ├── Project.php            # Portfolio projects
│   ├── Client.php             # Company/Individual clients
│   ├── Contact.php            # Employees within clients
│   ├── Message.php            # Inbox messages
│   ├── Technology.php         # Project tech stack (pivot relation)
│   └── ContactMethod.php      # Contact info (phone, email, etc.)
├── Jobs/
│   └── SendNewContactAlert.php # Queue jobs for notifications
├── Services/
│   └── Notifications/
│       ├── TelegramNotifier.php
│       └── WhatsAppNotifier.php
└── Providers/
    └── AppServiceProvider.php  # Service registration
```

### Key Models & Relationships

- **User** → has many Projects (admin user)
- **Project** ↔ **Technology** (Many-to-Many with pivot table)
- **Project** → belongs to Client
- **Client** ↔ **Contact** (One-to-Many: employees within company)
- **Client** ← **Message** (One-to-Many: received communications)
- **Contact** → **ContactMethod** (One-to-Many: multiple phone/email)

### Frontend Structure

```
resources/
├── views/
│   ├── layouts/               # Shared layouts (AppLayout.php)
│   ├── auth/                  # Login, register pages
│   ├── dashboard/             # Admin dashboard
│   ├── projects/              # Project management pages
│   ├── clients/               # Client management pages
│   ├── messages/              # Inbox pages
│   └── portfolio/             # Public-facing pages
├── css/
│   └── app.css               # Tailwind CSS imports
└── js/
    └── app.js                # Alpine.js components
```

### Database Schema Highlights

- **projects:** id, title, description, image_path, is_public, user_id, client_id, created_at
- **clients:** id, name, type (individual|company), email, phone, website, created_at
- **contacts:** id, first_name, last_name, role, notes, client_id, created_at
- **messages:** id, name, email, message, is_read, client_id, created_at
- **technologies:** id, name, icon (pivot table: project_technology with project_id, technology_id)

---

## 🔧 Development Setup

### Initial Setup

```bash
# Clone & install
git clone <repo>
cd Portfolio-with-CRM

# Install PHP dependencies via Docker
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" \
  -w /var/www/html laravelsail/php82-composer:latest \
  composer install --ignore-platform-reqs

# Copy environment file
cp .env.example .env

# Start containers
./vendor/bin/sail up -d

# Generate app key & migrate
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed

# Install & build frontend assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### Development Commands

```bash
# Run entire stack (server + queue + logs + vite)
composer run dev

# Just the dev server
./vendor/bin/sail artisan serve

# Watch frontend assets
./vendor/bin/sail npm run dev

# Run tests
composer run test

# Database operations
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan tinker

# Code quality
./vendor/bin/sail artisan pint  # Laravel Pint (code formatter)
./vendor/bin/sail artisan test
```

### Demo Credentials

- **URL:** http://localhost/login
- **Email:** admin@admin.com
- **Password:** password

---

## 💻 Technology Decisions

### Frontend: Blade + Alpine.js (Not SPA)

**Why:** Laravel Breeze includes server-rendered Blade templates with Alpine.js for lightweight interactivity. This is intentional—not a React/Vue SPA.

- **Advantages:** Simpler server-side logic, Laravel auth built-in, less JS overhead
- **Trade-off:** Full-page refreshes for navigation (acceptable for this admin tool)
- **Best for:** Content management systems, admin dashboards

### Styling: Tailwind CSS 3

- Latest utility-first CSS framework
- Plugin: `@tailwindcss/vite` for optimized builds
- Forms styling via `@tailwindcss/forms` plugin

### Database: MySQL (Relational)

- Structured data (clients, projects, messages)
- Foreign key constraints
- No need for NoSQL given current schema

### Notifications: Queue-based

- Uses Laravel Jobs (in-memory queue for dev)
- Telegram & WhatsApp notifier services available
- Can integrate with Redis for production queues

---

## 🎯 Key Code Patterns

### Model Relationships (Eloquent)

```php
// Project has many technologies (N:M pivot)
public function technologies() {
    return $this->belongsToMany(Technology::class);
}

// Client has many contacts
public function contacts() {
    return $this->hasMany(Contact::class);
}

// Message belongs to client (optional for leads)
public function client() {
    return $this->belongsTo(Client::class)->nullable();
}
```

### Form Validation (Form Requests)

Located in `app/Http/Requests/` - centralized validation rules. Example: `ProjectUpdateRequest` validates image, title, description before processing.

### Controller Pattern (CRUD)

Controllers follow standard Laravel naming:
- `index()` → List view
- `create()` → Create form
- `store()` → Save from form
- `show()` → Detail view
- `edit()` → Edit form
- `update()` → Update from form
- `destroy()` → Delete

### Service Layer (Optional)

`Services/Notifications/` for reusable business logic (Telegram, WhatsApp notifications). Can be expanded for image processing, email templates, etc.

---

## 🔐 Authentication & Authorization

- **Method:** Laravel Breeze (session-based)
- **Default:** Single admin user (seeded in migrations)
- **Model:** User model with Illuminate guards
- **Middleware:** `auth` required on all admin routes (defined in `routes/web.php`)

---

## 📊 Database Seeding

Run `./vendor/bin/sail artisan migrate:fresh --seed` to:
1. Create default admin user (email: admin@admin.com, password: password)
2. Seed sample projects, clients, technologies
3. Reset all data (careful in production!)

Seeder locations: `database/seeders/`

---

## 🚀 Deployment Notes

### Environment Variables

Critical `.env` variables:
- `APP_URL` - App base URL
- `DB_HOST`, `DB_DATABASE` - Database config
- `MAIL_FROM_ADDRESS` - Email sender
- Telegram/WhatsApp API keys (if using notifications)

### Docker (Sail)

The `compose.yaml` includes:
- Laravel app container (PHP 8.2)
- MySQL database
- (Optional) Redis, Memcached, Milvus services

### Asset Pipeline

- **Frontend assets** compiled via Vite
- **CSS** processed through Tailwind (JIT)
- **JS** minified & split by routes
- Built files: `public/build/`

---

## ⚠️ Known Limitations & Future Improvements

### Current Gaps
1. **Image storage:** Uses local storage (`storage/app/public`). Should migrate to S3/cloud for production.
2. **Notifications:** Telegram/WhatsApp notifiers exist but may need endpoint verification.
3. **Email:** No custom email templates for notifications yet.
4. **Real-time:** No WebSockets—messages don't auto-refresh (polling needed).

### Recommended Enhancements
1. **API layer:** Add REST API (`/api/*`) for mobile/external integrations
2. **Testing:** Expand PHPUnit test suite (currently minimal)
3. **Soft deletes:** Use `softDeletes()` on critical models for data recovery
4. **Search:** Add Elasticsearch or Scout for full-text search
5. **Real-time updates:** Implement Laravel Echo + Pusher/Soketi for WebSocket notifications
6. **Rate limiting:** Add `ThrottleRequests` middleware on contact form

---

## 📚 Important Files & Commands

| File/Command | Purpose |
|---|---|
| `routes/web.php` | All web route definitions |
| `routes/api.php` | API routes (if adding REST API) |
| `config/database.php` | Database configuration |
| `app/Http/Middleware` | Custom middleware (auth, cors, etc.) |
| `database/migrations` | Schema version control |
| `vite.config.js` | Frontend build configuration |
| `.env.example` | Template for environment variables |
| `artisan` | Laravel CLI tool |

---

## 🔍 Debugging Tips

- **Debug toolbar:** Install `barryvdh/laravel-debugbar` for development profiling
- **Log location:** `storage/logs/laravel.log`
- **Tinker:** `./vendor/bin/sail artisan tinker` for interactive REPL
- **Database inspection:** `./vendor/bin/sail mysql --user=root --password=password` (check `.env` for actual creds)
- **Queue inspection:** Monitor jobs via `storage/logs/` or `./vendor/bin/sail artisan queue:listen`

---

## 📖 References

- [Laravel Docs](https://laravel.com/docs)
- [Laravel Breeze](https://laravel.com/docs/breeze)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [MySQL Docs](https://dev.mysql.com/doc/)

---

**Last Updated:** 2026-04-29  
**Laravel Version:** 12.x  
**PHP Version:** 8.2+

# Student Course Hub

A university programme marketing application built with **Slim 4**, **Twig**, **Eloquent ORM**, and **MySQL**.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Slim 4 |
| Templates | Twig 3 (via slim/twig-view) |
| ORM | Illuminate Database (Eloquent) |
| Database | MySQL / MariaDB |
| Migrations | Phinx |
| DI Container | PHP-DI 7 |

---

## Project Structure

```
student-course-hub/
├── config/
│   ├── container.php       # DI container definitions
│   └── routes.php          # All application routes
├── database/
│   ├── migrations/         # Phinx migration files
│   └── seeds/              # Seed data (admin user, sample content)
├── public/
│   ├── index.php           # Front controller (entry point)
│   ├── .htaccess           # Apache URL rewriting
│   ├── css/
│   │   ├── app.css         # Student-facing styles
│   │   └── admin.css       # Admin panel styles
│   ├── js/
│   │   ├── app.js          # Student-facing JS
│   │   └── admin.js        # Admin JS
│   └── uploads/            # Uploaded images (git-ignored)
├── src/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── InterestController.php
│   │   └── StudentController.php
│   ├── Middleware/
│   │   └── AuthMiddleware.php
│   ├── Models/
│   │   ├── Admin.php
│   │   ├── Database.php    # Eloquent bootstrap
│   │   ├── Interest.php
│   │   ├── Module.php
│   │   ├── Programme.php
│   │   ├── ProgrammeModule.php
│   │   └── Staff.php
│   └── Twig/
│       └── CsrfExtension.php
├── templates/
│   ├── admin/
│   │   ├── dashboard.twig
│   │   ├── mailing-list/
│   │   ├── modules/
│   │   ├── programmes/
│   │   └── staff/
│   ├── auth/
│   │   └── login.twig
│   ├── errors/
│   │   └── 404.twig
│   ├── layouts/
│   │   ├── admin.twig
│   │   └── base.twig
│   └── student/
│       ├── home.twig
│       ├── manage-interest.twig
│       ├── programme.twig
│       └── programmes.twig
├── .env.example
├── composer.json
└── phinx.php
```

---

## Setup Instructions

### 1. Prerequisites

- PHP 8.1+
- Composer
- MySQL / MariaDB
- Apache (with `mod_rewrite`) or Nginx

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
```

Edit `.env` with your database credentials and a strong `APP_SECRET`.

### 4. Create the database

```sql
CREATE DATABASE student_course_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run migrations

```bash
vendor/bin/phinx migrate
```

### 6. Seed sample data

```bash
vendor/bin/phinx seed:run
```

This creates:
- **Admin user**: `admin@university.ac.uk` / `Admin1234!`
- 4 staff members
- 3 sample programmes (BSc CS, MSc Cyber Security, MSc Data Science)
- 8 modules assigned across those programmes

### 7. Start the development server

```bash
php -S localhost:8080 -t public
```

Or configure Apache/Nginx to point the document root at `public/`.

### 8. Create the uploads directory

```bash
mkdir -p public/uploads
chmod 775 public/uploads
```

---

## Routes Reference

### Student-facing

| Method | Path | Description |
|---|---|---|
| GET | `/` | Homepage |
| GET | `/programmes` | Browse all programmes (supports `?level=` and `?search=`) |
| GET | `/programmes/{slug}` | Programme detail page |
| POST | `/interest/register` | Register interest in a programme |
| POST | `/interest/withdraw` | Withdraw interest |
| GET | `/interest/manage` | View/manage your registrations |

### Admin (requires login)

| Method | Path | Description |
|---|---|---|
| GET | `/admin` | Dashboard |
| GET/POST | `/admin/programmes` | List / create programmes |
| GET/POST | `/admin/programmes/{id}/edit` | Edit programme |
| POST | `/admin/programmes/{id}/delete` | Delete programme |
| POST | `/admin/programmes/{id}/toggle-publish` | Publish / unpublish |
| GET/POST | `/admin/modules` | List / create modules |
| GET/POST | `/admin/staff` | List / add staff |
| GET | `/admin/mailing-list` | View interest registrations |
| GET | `/admin/mailing-list/export` | Download CSV |

### Auth

| Method | Path | Description |
|---|---|---|
| GET/POST | `/auth/login` | Admin login |
| POST | `/auth/logout` | Logout |

---

## Database Schema

```
admins            — Admin users (login credentials, role)
staff             — Academic staff (name, email, bio, photo)
programmes        — Degree programmes (title, slug, level, description, published)
modules           — Course modules (title, code, credits, leader)
programme_modules — Pivot: which modules belong to which programme and year
interests         — Prospective student registrations (name, email, programme)
```

---

## Security Measures

- **XSS prevention**: All user input sanitised with `htmlspecialchars()` before storage/display
- **SQL injection**: Prevented by Eloquent's parameterised queries
- **CSRF protection**: Session-based token on the admin login form
- **Admin authentication**: Session-based, with `AuthMiddleware` protecting all `/admin/*` routes
- **Password hashing**: `password_hash()` with `PASSWORD_BCRYPT`
- **Session regeneration**: `session_regenerate_id(true)` on login
- **File upload validation**: MIME type and extension checks; random filename generation

---

## Accessibility

- Semantic HTML5 landmarks (`<header>`, `<main>`, `<nav>`, `<footer>`, `<aside>`)
- Skip-to-content link for keyboard users
- All form inputs have associated `<label>` elements
- `aria-*` attributes on interactive controls (nav toggle, alerts, forms)
- `aria-current="page"` on active navigation links
- Focus-visible styles on all interactive elements
- Responsive layout — mobile-friendly at all breakpoints
- WCAG 2.1 AA colour contrast ratios maintained throughout

---

## Adding a New Admin User

```php
// Run this once via CLI or a temporary route:
use App\Models\Admin;
Admin::create([
    'name'     => 'New Admin',
    'email'    => 'new@university.ac.uk',
    'password' => password_hash('SecurePassword!', PASSWORD_BCRYPT),
    'role'     => 'admin',
]);
```

---

## Nginx Configuration (alternative to Apache)

```nginx
server {
    listen 80;
    server_name yourdomain.ac.uk;
    root /var/www/student-course-hub/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

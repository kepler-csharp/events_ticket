# 🎟️ Calcite — Virtual Reception System

Calcite is a web platform built for receptionists at ticket-selling venues, handling seat selection, order management, payment processing, and ticket generation for concerts and movie screenings.

---

## 📁 Project Structure

```
calcite/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/         ← Route controllers
│   │   └── Middleware/          ← Auth & role middleware
│   └── Services/                ← Business logic layer
│
├── resources/
│   ├── views/
│   │   ├── layouts/             ← Base app layout (design tokens)
│   │   ├── components/          ← Reusable Blade components
│   │   ├── event/
│   │   │   ├── index.blade.php  ← Event detail page
│   │   │   └── seats.blade.php  ← Interactive seat map
│   │   └── catalog.blade.php    ← Events listing
│   ├── css/
│   │   └── app.css              ← Global styles & CSS variables
│   └── js/
│       └── app.js               ← Vite entrypoint + seat map renderer
│
├── routes/
│   ├── web.php                  ← Web routes
│   └── api.php                  ← API routes
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── .github/
│   └── workflows/
│       └── deploy.yml           ← CI/CD pipeline
│
├── docker/                      ← Dockerfile & Nginx config
├── docker-compose.yml
└── docker-compose.prod.yml
```

---

# ✨ Features

## 🔐 Authentication
- Secure login for receptionists and administrators
- Role-based access control (Admin / Receptionist)

## 🗺️ Seat Map
- Interactive seat map rendered dynamically via JavaScript
- Real-time seat availability (available, occupied, selected)

## 🛒 Order Management
- Create, confirm, and cancel orders
- Order status tracking (Pending / Completed / Cancelled)
- Resend confirmation email

## 💳 Payment Processing
- Cash
- Bank Transfer
- Debit Card
- Credit Card

## 🎫 Ticket Generation
- Automatic ticket creation on order confirmation
- Ticket view with full order and customer details

## 👥 Adviser Panel
- Admin-only interface to create and manage receptionist accounts

---

# 🚀 Start Project

## Add `.env`

```bash
cp .env.example .env
```

Or configure manually:

```env
APP_NAME=Calcite
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=calcite
DB_USERNAME=root
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

L5_SWAGGER_GENERATE_ALWAYS=true
```

---

# ▶️ Execute

## Install dependencies

```bash
composer install
npm install
```

## Generate app key

```bash
php artisan key:generate
```

## Run migrations

```bash
php artisan migrate --seed
```

## Start development servers

```bash
php artisan serve
npm run dev
```

App available at:

```
http://localhost:8000
```

---

# 👤 Default Roles

| Role | Email                    | Password |
|---|--------------------------|---|
| Admin | admin@tickets.com        | Admin1234! |
| Receptionist | receptionist@tickets.com | Recept1234! |

---

# 📋 Requirements

Install the following before running the project:

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL Server
- Docker Desktop *(for containerized setup)*

---

# 📦 Composer Packages

```bash
composer require darkaonline/l5-swagger
composer require laravel/sanctum
```

---

# 📖 API Documentation

Swagger docs are auto-generated via `darkaonline/l5-swagger`.

Open Swagger UI:

```
http://localhost:8000/api/documentation
```

Regenerate docs manually:

```bash
php artisan l5-swagger:generate
```

---

## 🔗 API Endpoints

### Auth (`/api/auth`)

| Method | Endpoint | Access | Description |
|---|---|---|---|
| POST | `/api/auth/login` | Public | Login → session token |
| POST | `/api/auth/logout` | Authenticated | Invalidate session |

### Events (`/api/events`)

| Method | Endpoint | Access | Description |
|---|---|---|---|
| GET | `/api/events` | Public | List all active events |
| GET | `/api/events/{id}` | Public | Event details |

### Showtimes (`/api/showtimes`)

| Method | Endpoint | Access | Description |
|---|---|---|---|
| GET | `/api/showtimes/{id}` | Public | Showtime details + base price |
| GET | `/api/showtimes/{id}/seats` | Public | Seat map for a showtime |

### Orders (`/api/orders`)

| Method | Endpoint | Access | Description |
|---|---|---|---|
| POST | `/api/orders` | Receptionist | Create order from selected seats |
| PATCH | `/api/orders/{id}/confirm` | Receptionist | Confirm and process payment |
| PATCH | `/api/orders/{id}/cancel` | Receptionist | Cancel a pending order |
| POST | `/api/orders/{id}/resend` | Receptionist | Resend confirmation email |
| GET | `/api/orders/{id}` | Receptionist | Order + ticket details |

### Advisers (`/api/advisers`)

| Method | Endpoint | Access | Description |
|---|---|---|---|
| GET | `/api/advisers` | Admin | List all advisers |
| POST | `/api/advisers` | Admin | Create new adviser account |

---

## 🔄 Complete Purchase Flow

```
1. POST /api/auth/login                  → Authenticate receptionist
2. GET  /api/showtimes/{id}/seats        → View available seat map
3. POST /api/orders                      → Create order from selected seats
4. POST /api/orders/{id}/confirm         → Choose payment method → confirm
5. GET  /api/orders/{id}                 → View generated tickets
```

---

# 🐳 Docker

## Build and start all services

```bash
docker compose up --build
```

## Run in background

```bash
docker compose up -d
```

## Run artisan commands inside container

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan l5-swagger:generate
```

## Stop containers

```bash
docker compose down
```

---

# 🌐 Services

| Service | URL |
|---|---|
| App | http://localhost:8000 |
| Swagger | http://localhost:8000/api/documentation |
| MySQL | localhost:3306 |

---

# ⚙️ CI/CD Pipeline

Calcite uses **GitHub Actions** for automated deployment on every push to `main`.

## Pipeline Steps

```
Push to main
     │
     ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    Build    │────▶│    Test     │────▶│   Deploy    │
│  & Lint     │     │  (PHPUnit)  │     │  (Docker)   │
└─────────────┘     └─────────────┘     └─────────────┘
```

1. Checkout repository
2. Install PHP & Composer dependencies
3. Install Node.js & NPM dependencies
4. Run PHPUnit test suite
5. Build Docker image and push to registry
6. Deploy to production server via SSH

## 🔑 Required GitHub Secrets

| Secret | Description |
|---|---|
| `DOCKER_USERNAME` | Docker Hub username |
| `DOCKER_PASSWORD` | Docker Hub access token |
| `SSH_HOST` | Production server IP |
| `SSH_USER` | SSH login user |
| `SSH_PRIVATE_KEY` | SSH private key for deployment |

---

## Changes Missing
- Events Pagination
- Seats selection fix (UX Error)
- Keep selected seats fix (UX Error)
- Select seats fix -> generate order (UX Error: Intermitent white screen showed between)

---

# 📄 License

This project is intended for internal and educational use. All rights reserved.

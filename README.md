# Justsolve – Debt Collection Management System

This project is a full-stack debt collection management system built for the JustSolve technical challenge.
It features a **Laravel backend API**, an **Angular frontend**, and a **Docker-based development environment**.

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Project Structure](#project-structure)
- [Authentication](#authentication)
- [API Endpoints](#api-endpoints)
- [Development](#development)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **Docker** (v20.10+) and **Docker Compose** (v2.0+)
- **Node.js** (v18+ or v20+)
- **npm** (v9+ or v10+)
- **Git**

---

## Quick Start

Follow these steps to clone and run the project:

### 1. Clone the Repository
```bash
git clone <repository-url>
cd justsolve
```

### 2. Start the Backend (Laravel API)
```bash
cd environment
docker compose up -d
```

The Laravel API will be available at **http://localhost:8000**

### 3. Set Up the Database
```bash
# Run migrations and seed the database
docker exec justsolve_laravel php artisan migrate:fresh --seed
```

This creates:
- **Users table** with admin and regular users
- **Debts table** with sample debt records

### 4. Start the Frontend (Angular)
```bash
cd ../frontend/debt-collector
npm install
ng serve
```

The Angular app will be available at **http://localhost:4200**

### 5. Access the Application
Open your browser and navigate to:
- **Frontend**: http://localhost:4200
- **Backend API**: http://localhost:8000/api/debts

You're all set! The app will automatically authenticate as the admin user.

---

## Project Structure

```
justsolve/
 ├── backend/          # Laravel API (runs in Docker)
 ├── frontend/         # Angular app (runs locally)
 └── environment/      # Docker configuration
```

---

## Authentication

The application uses **HTTP Basic Authentication** with hardcoded credentials in the frontend.

### Default Users

Two users are created when you seed the database:

| Role    | Email                | Password   | Access          |
|---------|---------------------|------------|-----------------|
| Admin   | admin@example.com   | password   | Full access     |
| User    | user@example.com    | password   | Blocked (403)   |

### How It Works

- The Angular frontend automatically includes Basic Auth headers in all API requests
- Credentials are hardcoded in `frontend/debt-collector/src/app/interceptors/auth.interceptor.ts`
- The backend validates credentials and checks admin role
- **No login form** – authentication is automatic

### Testing with Different Users

To test access control, edit `auth.interceptor.ts`:

```typescript
// Line 5 - Change the username
const username = 'admin@example.com';  // Has access
// const username = 'user@example.com';   // Gets 403 Forbidden
```

Save, refresh the browser, and check the Network tab for API responses.

---

## API Endpoints

All endpoints require authentication and admin role.

| Method | Endpoint                      | Description                    |
|--------|-------------------------------|--------------------------------|
| GET    | `/api/debts`                  | List all open debts            |
| GET    | `/api/debts/{id}`             | Get debt details               |
| GET    | `/api/debts/{id}/suggestion`  | Get suggested action for debt  |
| POST   | `/api/debts/{id}/apply-action`| Apply action to debt           |

### Example Request
```bash
curl -u admin@example.com:password http://localhost:8000/api/debts
```

### Response Format
```json
[
  {
    "id": 1,
    "external_id": "DEBT-001",
    "debtor_name": "John Smith",
    "amount": "1500.00",
    "days_overdue": 75,
    "status": "OPEN",
    "last_action": null,
    "last_action_at": null
  }
]
```

---

## Development

### Backend (Laravel in Docker)

**Start the backend:**
```bash
cd environment
docker compose up -d
```

**Stop the backend:**
```bash
docker compose down
```

**Access the container:**
```bash
docker exec -it justsolve_laravel sh
```

**Run migrations:**
```bash
docker exec justsolve_laravel php artisan migrate
```

**Seed the database:**
```bash
docker exec justsolve_laravel php artisan db:seed
```

**Reset and reseed:**
```bash
docker exec justsolve_laravel php artisan migrate:fresh --seed
```

**Check migration status:**
```bash
docker exec justsolve_laravel php artisan migrate:status
```

**Laravel Tinker (PHP REPL):**
```bash
docker exec -it justsolve_laravel php artisan tinker

# Inside Tinker:
\App\Models\Debt::count();           # Count debts
\App\Models\User::all();             # List users
\App\Models\Debt::all()->toArray();  # View all debts
exit                                  # Exit Tinker
```

### Frontend (Angular)

**Start development server:**
```bash
cd frontend/debt-collector
ng serve
```

**Build for production:**
```bash
ng build
```

**Run linter:**
```bash
ng lint
```

**Note on Frontend Setup:**
For this technical test, the Angular frontend runs **locally** (outside Docker).
This keeps the development process simple, fast, and easy to evaluate, without adding
extra container complexity that is not required for the scope of the challenge.

**P.S.** In production or large team projects, the recommended setup is to containerize both backend and frontend for consistency. This separation improves scalability, caching, CI/CD pipelines, reproducibility, and deployment consistency.

---

## Testing

### Backend Tests

**Run all tests:**
```bash
docker exec justsolve_laravel php artisan test
```

**Run specific test suite:**
```bash
docker exec justsolve_laravel php artisan test --filter=DebtActionServiceTest
```

**Run with coverage:**
```bash
docker exec justsolve_laravel php artisan test --coverage
```

### Frontend Tests

```bash
cd frontend/debt-collector
npm test
```

---

## Troubleshooting

### Backend Issues

**Port 8000 already in use:**
```bash
# Stop other services using port 8000
lsof -ti:8000 | xargs kill -9

# Or change the port in environment/docker-compose.yml
```

**Database not seeded:**
```bash
docker exec justsolve_laravel php artisan migrate:fresh --seed
```

**CORS errors:**
- Ensure the backend is running
- Check that CORS middleware is registered in `backend/bootstrap/app.php`
- Restart the backend: `docker compose restart`

### Frontend Issues

**API requests fail:**
- Verify backend is running at http://localhost:8000
- Check browser console for CORS errors
- Ensure auth interceptor is configured correctly

**Port 4200 already in use:**
```bash
# Kill the process
lsof -ti:4200 | xargs kill -9

# Or use a different port
ng serve --port 4300
```

**Module not found errors:**
```bash
cd frontend/debt-collector
rm -rf node_modules package-lock.json
npm install
```




### Database
- Uses **SQLite** for simplicity (configured in `backend/.env`)
- Database file: `backend/database/database.sqlite`

### Architecture
- **Backend**: Laravel 12 with repository pattern and service layer
- **Frontend**: Angular 21 with standalone components and new control flow syntax
- **Authentication**: HTTP Basic Auth 

---

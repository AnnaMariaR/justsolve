# Justsolve – Technical Test

This project contains a full-stack implementation for the JustSolve technical challenge.  
It is structured as a **Laravel backend**, an **Angular frontend**, and a **Docker-based development environment**.

---

## 📁 Project Structure

```
justsolve/
 ├── backend/          # Laravel - backend API
 ├── frontend/         # Angular app - frontend UI
 └── environment/      # Docker development environment
```

---

## Development Environment (Docker)

The project uses Docker to run the Laravel backend without requiring any local PHP or Composer installation.

Start Laravel API:
From the environment folder:
```
cd environment
docker compose up
```
Laravel will be available at:
- http://localhost:8000
- or http://127.0.0.1:8000

Stop environment:
```
docker compose down
```

Enter the container:
```
docker exec -it justsolve_laravel sh
```

Database Configuration (SQLite):
```bash
# SQLite is configured in backend/.env

# Run migrations:
docker exec justsolve_laravel php artisan migrate

# Seed the database:
docker exec justsolve_laravel php artisan db:seed

# Reset and reseed database:
docker exec justsolve_laravel php artisan migrate:fresh --seed

# Check migration status:
docker exec justsolve_laravel php artisan migrate:status

# Open Tinker ( PHP shell):
docker exec -it justsolve_laravel php artisan tinker

# Then inside tinker, run these commands:
# List all tables:
$tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name"); foreach($tables as $t) echo $t->name . PHP_EOL;

# Check if table exists:
\Schema::hasTable('debts');

# Count records:
\App\Models\Debt::count();

# View all debts as array (formatted):
\App\Models\Debt::all()->toArray();

# Exit tinker:
exit
```

Laravel installation steps: <br>
The backend was generated inside the backend folder using Composer inside Docker:
```
docker run --rm -v "$(pwd)":/app -w /app composer:2 \
    composer create-project laravel/laravel backend
```
##  Frontend Environment (Angular)

For this technical test, the Angular frontend runs **locally** (outside Docker).  
This keeps the development process simple, fast, and easy to evaluate, without adding 
extra container complexity that is not required for the scope of the challenge.

To start the Angular application:

```bash
cd frontend/debt-collector
npm install
ng serve
```
The app will be available at:

- http://localhost:4200

P.S In production or large team projects, the recommended setup is to containerize both backend and frontend for consistency.This separation improves scalability, caching, CI/CD pipelines, reproducibility, and deployment consistency.

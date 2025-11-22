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
Laravel installation steps: <br>
The backend was generated inside the backend folder using Composer inside Docker:
```
docker run --rm -v "$(pwd)":/app -w /app composer:2 \
    composer create-project laravel/laravel backend
```

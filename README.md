# Task Manager API

A Laravel REST API for managing tasks with priority levels and status tracking. Built with Laravel 13 and SQLite (no database setup needed).

**Author:** Anne Anziya — beliya.anziya2022@gmail.com

---

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Open http://localhost:8000

---

## Requirements

- PHP 8.2+
- Composer

No database setup needed — uses SQLite out of the box.

## Local Setup

1. Install dependencies
   ```bash
   composer install
   ```

2. Set up environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Run migrations and seed sample data
   ```bash
   php artisan migrate --seed
   ```

4. Start the server
   ```bash
   php artisan serve
   ```

The API is at `http://localhost:8000/api`. The frontend is at `http://localhost:8000`.

## API Endpoints

### Create a Task
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title": "Fix login bug", "due_date": "2026-04-05", "priority": "high"}'
```

### List All Tasks
```bash
curl http://localhost:8000/api/tasks
```

### Filter by Status
```bash
curl "http://localhost:8000/api/tasks?status=pending"
```

### Update Task Status
```bash
curl -X PATCH http://localhost:8000/api/tasks/1/status \
  -H "Content-Type: application/json" \
  -d '{"status": "in_progress"}'
```

### Delete a Task (must be done)
```bash
curl -X DELETE http://localhost:8000/api/tasks/1
```

### Daily Report
```bash
curl "http://localhost:8000/api/tasks/report?date=2026-03-29"
```

## Business Rules

- Tasks start as `pending` by default
- Same title cannot be used twice for the same due date
- Due date must be today or in the future
- Status moves forward only: `pending` → `in_progress` → `done`
- Only completed tasks can be deleted

## Running Tests

```bash
php artisan test
```

Tests use SQLite in-memory — no setup needed, just run and go.

## Database

SQL dump is available at `database/task_manager.sql`

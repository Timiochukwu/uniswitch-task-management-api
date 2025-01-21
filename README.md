# Task Management API

A RESTful API built with Laravel for managing tasks. This project implements the Repository Pattern and includes Docker containerization for easy deployment.

## Features

- Create, Read, Update, and Delete tasks
- RESTful API architecture
- Repository Pattern implementation
- Docker containerization
- Unit Testing
- API Documentation
- PSR Coding Standards compliance

## Tech Stack

- PHP 8.2
- Laravel 11.x
- MySQL 8.0
- Docker
- PHPUnit for testing

## Prerequisites

- Docker and Docker Compose
- Composer (for local development)
- Postman (for testing APIs)

## Installation

1. Clone the repository
```bash
git clone https://github.com/Timiochukwu/uniswitch-task-management-api.git
cd uniswitch-task-management
```

2. Copy the environment file
```bash
cp .env.example .env
```

3. Build and run Docker containers
```bash
docker-compose up -d --build
```

4. Install dependencies
```bash
docker-compose exec app composer install
```

5. Generate application key
```bash
docker-compose exec app php artisan key:generate
```

6. Run migrations
```bash
docker-compose exec app php artisan migrate
```

## API Endpoints

### Tasks

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/tasks` | Get all tasks |
| GET | `/api/tasks/{id}` | Get specific task |
| POST | `/api/tasks` | Create new task |
| PUT | `/api/tasks/{id}` | Update existing task |
| DELETE | `/api/tasks/{id}` | Delete task |

### Request Body Format (POST/PUT)

```json
{
    "title": "Task Title",
    "description": "Task Description",
    "completed": true,
    "due_date": "2024-02-20"
}
```

### Completion Status Options
- true
- false

## Testing

Run the test suite:

```bash
docker-compose exec app php artisan test
```

## Database Structure

### Tasks Table
- id (bigint, primary key)
- title (string)
- description (text, nullable)
- completed (enum: true, false)
- due_date (datetime, nullable)
- created_at (timestamp)
- updated_at (timestamp)

## Error Handling

The API returns appropriate HTTP status codes:

- 200: Success
- 201: Created
- 404: Not Found
- 422: Validation Error
- 500: Server Error

## Development

### Code Style

This project follows PSR-12 coding standards. To check code style:

```bash
docker-compose exec app ./vendor/bin/phpcs
```

### Repository Pattern

The project implements the Repository Pattern with following structure:

```
app/
├── Repositories/
│   └── TaskRepositoryInterface.php
│   └── TaskRepository.php
```

## API Documentation

### Postman Collection

A Postman collection is included in the repository:
`/postman/Task_Management_API.postman_collection.json`

To use:
1. Import the collection into Postman
2. Set up your environment variables
3. Test the endpoints

## Docker Configuration

The project includes three main services:
- **app**: PHP application
- **nginx**: Web server
- **mysql**: Database

### Ports
- Application: `http://localhost:8000`
- MySQL: `3307:3306`

## Troubleshooting

Common issues and solutions:

1. Permission issues
```bash
chmod -R 777 storage bootstrap/cache
```

2. Database connection issues
```bash
docker-compose exec app php artisan config:clear
```



## Contact

Oladipupo M. Oluwatimilehin - oluwatimilehinoladipupo1@gmail.com

Project Link: https://github.com/Timiochukwu/uniswitch-task-management-api.git
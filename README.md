# Blog Management System

## What is this project?
This is a blog management system backend built with Laravel 11 and MariaDB/MySQL. The project was developed as a test assessment for Momentum Solutions.

## How does this project setup work?
1. Clone the repository
2. Create a `.env` file based on the `.env.example` provided
3. Install dependencies: `composer install`
4. Run migrations with seeders: `php artisan migrate --seed`

**Important Note:** When running migrations, be sure to include the `--seed` flag as it contains seeded users with the following credentials:
```
Email: user@momentum.com
Password: 123456789
```

The seeded user comes with 10 pre-populated posts to make testing easier. Alternatively, you can register a new user through the provided API endpoints.

## API Documentation
Complete API documentation is available via Postman:
[Momentum Project Postman Collection](https://www.postman.com/martian-shadow-736975/momentum-project)

Alternatively, you can access the Postman collection from this Google Drive link:
[Google Drive - Postman Collection](https://drive.google.com/drive/folders/1y7doejn-Ugq7EphsjLld06-0HqWTggyx?usp=sharing)

For each endpoint, you'll find detailed responses showing URLs, different use cases, and request bodies when needed.

**Important Note:** base url is 127.0.0.1:8000/api

## Bonus Features
### Architecture & Design
- Modularity using Service-Repository pattern
- Structured request validation and API resources
- Response trait for consistent API responses

### Internationalization
- Full localization support for Arabic and English languages

### Performance Optimization
- Redis cache implementation
- Pagination for large data sets
- Database indexes for optimized search queries

### Extended Endpoints
Beyond the required CRUD operations, the API includes:
- Authentication endpoints (register, login, logout, profile)
- Soft delete functionality
- Force delete operations
- Restore deleted posts
- Bulk operations (delete, force delete, restore)
- User password updates
- Retrieving deleted posts
- Advanced search and sorting capabilities

### Security Features
- Laravel Sanctum for API authentication
- CORS middleware for cross-origin requests
- Input validation and sanitization

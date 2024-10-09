# Bill Payments System

## Objective

This project is a simple RESTful API for managing a bill payments system. It includes CRUD operations for `users` and `transactions`, MySQL database setup, API responses using Eloquent Resources, and unit testing.

## Requirements

- **Framework**: Laravel
- **Database**: MySQL with relationships between `users` and `transactions` tables
- **API**: CRUD implementation for both `users` and `transactions`
- **Responses**: API responses using Laravel’s Eloquent API Resources
- **Testing**: Unit tests for API endpoints using Laravel's built-in testing tools

## Features

1. **Users**: Manage users with full CRUD operations.
2. **Transactions**: Manage transactions with full CRUD operations.
3. **Authentication**: Secure endpoints using sanctum.
4. **API Resources**: Responses are formatted using Laravel's Eloquent API Resources.
5. **Unit Tests**: Each API endpoint is covered with unit tests.

## Setup Instructions

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Laravel 10.x

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/VivianDee/EasyBill.git
   cd EasyBill
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the environment variables:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Configure your `.env` file with database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=bill_payment
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Run database migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

### Running the Application

To start the development server, run:
```bash
php artisan serve --port=8000
```
This will start the application at `http://localhost:8000`.

### API Endpoints

Here are the available API endpoints for managing users and transactions:

- **Users**
  - `GET /api/users`: Get all users
  - `POST /api/users`: Create a new user
  - `GET /api/users/{id}`: Get a single user
  - `PUT /api/users/{id}`: Update a user
  - `DELETE /api/users/{id}`: Delete a user

- **Transactions**
  - `GET /api/transactions`: Get all transactions
  - `POST /api/transactions`: Create a new transaction
  - `GET /api/transactions/{id}`: Get a single transaction
  - `PUT /api/transactions/{id}`: Update a transaction
  - `DELETE /api/transactions/{id}`: Delete a transaction

### API Documentation

A Postman collection for the API can be accessed on request

### Running Tests

Run the tests using the following command:
```bash
php artisan test
```

### Conclusion

This project demonstrates the ability to create a secure and functional API using Laravel. The structure is modular, making it easy to extend functionality in the future.
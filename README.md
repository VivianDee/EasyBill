# Bill Payments System

## Objective

This project is a simple RESTful API for managing a bill payments system. It includes CRUD operations for `users` and `transactions`, MySQL database setup, API responses using Eloquent Resources, and unit testing.

## Technologies Used

- **Backend**: PHP Laravel
- **Database**: MySQL
- **Version Control**: Git, GitHub

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

2. **Install dependencies**:
   - **Laravel**:
     ```bash
     composer install
     ```

3. **Set up database**:
   - **MySQL**: Create the `bill_payment` MySQL database and update the `.env` file accordingly.

4. **Configure environment variables**:
    - **Laravel**, update `.env` with your MySQL credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=bill_payment
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations:
     ```bash
     php artisan migrate
     ```

7. Run the backend server:
     ```bash
     php artisan serve
     ```

8. Create API routes file and install Laravel Sanctum:
     ```bash
     php artisan install:api
     ```

### Running the Application

To start the development server, run:
```bash
php artisan serve --port=8000
```
This will start the application at `http://localhost:8000`.

### API Endpoints

Here are the available API endpoints for managing users and transactions:

- **Authentication**
  - `POST /api/auth/register`: Register a new user.
  - `POST /api/auth/login`: Log in a user.
  - `POST /api/auth/logout`: Log out a user.
  - `POST /api/auth/change-password`: Change user password.

- **Users**
  - `GET /api/users`: Get all users
  - `GET /api/user/{id}`: Get user by ID 
  - `GET /api/user`: Get authenticated user
  - `PUT /api/user`: Update authenticated user
  - `DELETE /api/user`: Delete authenticated user

- **Transactions**
  - `GET /api/transactions`: Get all transactions
  - `POST /api/transaction`: Create a new transaction
  - `GET /api/transaction/{id}`: Get a single transaction
  - `PUT /api/transaction/{id}`: Update a transaction
  - `DELETE /api/transaction/{id}`: Delete a transaction

### API Documentation

A Postman collection for the API can be accessed [here](https://www.postman.com/bakkaztech/workspace/my-personal-workspace/collection/34974013-afcbc756-1431-45d5-9726-c7237e0acef5?action=share&creator=34974013).

### Running Tests

Run the tests using the following command:
```bash
php artisan test
```
### Modular Service-Based Architecture

In this application, each feature (like `Users` and `Transactions`) is organized into core components that work together efficiently:

- **Controllers**: These receive incoming API requests, delegate tasks to the appropriate Modules, and return the results as API responses.

- **Modules**: Each Module encapsulates the functionality related to a feature, making it easier to manage and scale. For example, the `UserModule` contains everything related to user management, excluding authentication.

- **Services**: The Services perform the actual work. `Controllers` call the `Modules` which calls the `Services` to handle the tasks, manipulate data or performing specific actions.

- **Resources**: They interact with the database using Eloquent models to ensure that the data returned is structured correctly and includes only the necessary information.

- **Helpers**: Helper functions or methods assist with common tasks e.g `ResponseHelper` which is used to standardize API responses across the application.

- **Enums**: Enums provide a clear way to handle predefined values. For example, the `AccountType` enum defines the different types of user accounts.

- **Middleware**: Middleware acts as a filter for incoming requests. The `VerifyApiKey` middleware checks for a valid API key in the request headers. It acts as an extra layer of security.

- **Models**: Models represent the structure of the database tables using Eloquent ORM.

This structured approach helps maintain a clean separation of concerns, making it easier to update features and scale the application as needed.



### Conclusion

This project demonstrates my ability to create a secure and functional API using Laravel. The structure is modular, making it easy to extend functionality in the future.
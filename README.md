# HR Management API

## About

This project is an API designed to handle user authentication, employees, and related HR data. It provides endpoints for handling user accounts, employee records, and other HR management tasks.


## 1. Project Overview

This project runs on the latest version of PHP 8.4 and is built using the Laravel framework version 12. This ensures a modern, efficient, and secure backend infrastructure to deliver a seamless experience.

- Users Authentication
- Employees Management
- Employee Position Management
- API Authentication using Laravel Sanctum
- Importing Employees via background queues
- Exporting Employees to CSV files in chunks and utilizing browser stream
- Proper broadcasting and logging channels
- Containerized using Docker for easy deployment and scalability
- Action based pattern for better code organization and maintainability
- XDEBUG and PHP OPCACHE enabled.
- Includes a production ready NGINX server configuration.

## 2. Technologies

- **Backend**: PHP 8.4, Laravel 12.x
- **Database**: MySQL 8.0
- **Caching**: Redis
- **Storage**: Laravel Local Storage Disk
- **Containerization**: Docker & Docker Compose
- **Testing**: Pest Framework

## 3. Packages Used
- **Laravel Horizon** for running and monitoring queues.
- **Laravel Sanctum** for API authentication.
- **Laravel Audit** for auditing model changes.
- **Spatie Query Builder** to enabling filtering.
- **Spatie Simple Excel** for importing and exporting CSV files with memory in mind.

## 5. Installation

A live demo of the application is available at [https://hr-management-api.onlyinternals.dev](https://hr-management-api.onlyinternals.dev/).

### 4.1 Running on Docker

#### Resources:
- [Installing Docker & Docker Compose](https://docs.docker.com/engine/install/)

Follow these steps to set up and run the application using Docker:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ravensborn/hr-management-api
   cd hr-management-api
   ```

2. **Set Up Environment Variables**
   ```bash
   cp .env.example .env
   ```

3. **Start Docker Containers**
   ```bash
      docker compose up -d
   ```

4. **Seed Test Data**
   ```bash
      docker docker exec -it hr-management-backend php artisan migrate:fresh --seed
   ```
   
5. **Verify the Deployment**  
   Access the application at [http://localhost:8111](http://localhost:8111)


### 4.1 Running Without Docker

Copy the `.env.example` file to `.env`, then update the environment variables according to your setup.
Make sure to configure the correct database connection, and ensure that a queue worker is properly running to handle background jobs. Seed the database with test data using the command below:

```bash
  php artisan migrate --seed
```

## 5. Postman Collection
A Postman collection is provided in the `documentation` directory of the repository. You can import this collection into Postman to test the API endpoints. Its also available here: [HR Management API Postman Collection](https://documenter.getpostman.com/view/18062098/2sB3QCTtsP) with a live testing environment.

## 6. Test Files
- A sample CSV file for importing employees is available in the `documentation` directory of the repository.
- A copy of database backup with test data is available in the `documentation` directory of the repository.


## 7. Testing

- The project includes comprehensive unit and integration tests to ensure reliability.

### Running Tests (Docker)

```bash
# Run all tests
docker exec -it hr-management-backend php artisan test

# Generate coverage report
docker exec -it hr-management-backend XDEBUG_MODE=coverage php artisan test --coverage

# Run tests in parallel
docker exec -it hr-management-backend php artisan test --parallel
```

## 7. General Notes
 - The email and broadcast drivers are set to `log`. You can view the email contents in the log file located at `storage/logs/laravel.log`.

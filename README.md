<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Project Name:  E-Commerce Platform

## Overview

This enhanced e-commerce platform supports complex product, order management, and payment processing systems, including full CRUD capabilities for products with advanced filtering and ratings. The system provides differentiated roles for vendors, admins, and incorporates comprehensive user permissions. It integrates Stripe for payments and utilizes JWT for authentication along with push notifications for real-time user engagement.

## Installation

### Prerequisites

- PHP 8.2
- Composer
- MySQL
- Node.js (for Pusher and other JavaScript dependencies)

### Steps

1. Clone the repository
    ```bash
    git clone https://yourrepositorylink.git
    cd your-project-directory
    ```

2. Install PHP and JavaScript dependencies
    ```bash
    composer install
    npm install
    ```

3. Install additional packages for Pusher, Spatie, JWT, and email verification:
    ```bash
    composer require pusher/pusher-php-server spatie/laravel-permission tymon/jwt-auth
    ```

4. Set up environment variables
    - Rename `.env.example` to `.env`
    - Configure your database, Stripe, Pusher, Spatie (Roles & Permissions), and JWT settings in `.env`

    Example for Pusher:
    ```
    PUSHER_APP_ID=your_pusher_app_id
    PUSHER_APP_KEY=your_pusher_app_key
    PUSHER_APP_SECRET=your_pusher_app_secret
    PUSHER_APP_CLUSTER=mt1
    ```

    Example for Spatie:
    ```
    # Spatie uses the default Laravel configuration; no specific environment variables are needed.
    ```

    Example for JWT:
    ```
    JWT_SECRET=your_jwt_secret
    ```

5. Run migrations and seeders for initial data setup, including roles and permissions.
    ```bash
    php artisan migrate --seed
    their is many modules that need seed so run it all
    php artisan module:seed

    ```

6. Generate JWT secret key
    ```bash
    php artisan jwt:secret
    ```

7. Set up Laravel queues for email and push notifications
    ```bash
    php artisan queue:work
    ```

8. Configure email verification (optional but recommended)
    - Ensure that your `config/mail.php` is correctly set up with your email provider.
    - Set up the `verify` middleware on routes requiring verified emails.

## Usage

Detailed description of modules and functionalities:

### User Authentication

- Role-based access control using **Spatie** for Admin, Vendor, and standard users.
- Secure JWT authentication and authorization.
- Email verification for user accounts.

### Product Management

- Full CRUD operations for product management.
- Advanced product filters and rating system.
- Stripe payment integration for handling secure transactions.

### Order Processing

- Comprehensive order management from placement to delivery.
- Real-time order status updates via **Pusher** notifications.

### API Endpoints

baseurl/api/

## Modules and Architecture

### Modular Architecture

The application is structured into several modules, each encapsulating a specific area of functionality:

- **UserModule**: Authentication, profile management, and role assignments.
- **ProductModule**: Product lifecycle management including CRUD operations, ratings, and filters.
- **OrderModule**: Handles all order processing logic including payments.
- **PaymentModule**: Handles all Payment processing logic.
- **RoleModule**: Handles all User Permission using Spatie.
- **RateModule**: Handles Rating for Product.

### Service Layer

Centralizes business logic, ensuring high reusability and easier maintenance. Services interact with repositories to abstract data access logic from business rules.

### Repository Pattern

Promotes a clean separation of concerns and enhances testability. Repositories provide a consistent interface for accessing data layers.

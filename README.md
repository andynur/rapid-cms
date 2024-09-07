# **Rapid CMS**

Rapid CMS is a content management system built using Laravel. It is designed to manage blog posts, authors, categories, and comments. The application follows best practices like Service-Repository Pattern, DTO (Data Transfer Object), caching strategies, and leverages **Laravel Sanctum** for authentication.

The project is built with a clean and scalable architecture that ensures flexibility, maintainability, and testability.

## **Features**

- **Authentication**: 
    - User registration, login, and logout using **Laravel Sanctum** for token-based authentication.
  
- **CRUD Operations**:
    - Manage posts, authors, categories, and comments with complete CRUD (Create, Read, Update, Delete) operations.

- **Caching Strategy**:
    - Post lists, post details, and user information are cached for performance improvement, with cache invalidation on data change.
  
- **Service-Repository Pattern**:
    - Separation of concerns with clean service and repository layers, promoting maintainability and testability.

- **Form Request Validation**:
    - Strict form validation using Laravel's form requests for input validation.

- **Event-Driven Architecture**:
    - The system triggers events such as sending welcome emails upon user registration using Laravel events and listeners.

- **Queue Management**:
    - The project utilizes Redis for queue management, ensuring asynchronous job execution for tasks such as sending emails.

- **Pest for Testing**:
    - Comprehensive unit and feature tests are implemented using Pest to ensure the reliability of the system.

## **Installation**

### **1. Clone the Repository**

```bash
git clone https://github.com/andynur/rapid-cms.git
cd rapid-cms
```

### **2. Install Dependencies**

Ensure you have Composer installed. Run the following command to install PHP and Laravel dependencies:

```bash
composer install
```

### **3. Set up Environment File**

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database, email, redis settings, and **Resend** API:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Redis configuration
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Resend configuration
RESEND_API_KEY=your_resend_api_key
RESEND_TEST_EMAIL=true # Set to false if you want to disable test mode for Resend emails
```

### **4. Generate Application Key**

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### **5. Run Migrations and Seed Data**

Run the migrations and seed the database with default values:

```bash
php artisan migrate --seed
```

### **6. Install and Configure Redis (Optional)**

Ensure that Redis is installed and running if you are using Redis for caching and queues:

```bash
redis-server
```

### **7. Start the Application**

You can now serve the application locally using the following command:

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

### **8. Running Queue Worker**

For background jobs like sending emails, run the queue worker:

```bash
php artisan queue:work
```

## **Testing Welcome Email**

To test the welcome email functionality manually, you can use the following command:

```bash
php artisan mail:send-welcome {email}
```

Replace `{email}` with the actual email address you want to send the welcome email to. Ensure that the **queue worker** is running by executing:

```bash
php artisan queue:work
```

## **Postman Documentation**

The Postman collection for testing the API endpoints can be found at:

- [Postman Documentation](https://documenter.getpostman.com/view/19148174/2sAXjRVp36)
- Alternatively, you can import the collection directly from the project repository at `storage/docs/postman_collections.json`.

## **Running Tests**

The application uses **Pest** for unit and feature testing. All the tests are located in the `tests` directory.

To run the tests, simply execute:

```bash
php artisan test
```

Ensure you have a dedicated testing database set up in your `.env.testing` file:

```env
DB_CONNECTION=mysql
DB_DATABASE=rapid_cms_testing
```

## **License**

This project is open-source and free to use under the [MIT License](https://opensource.org/licenses/MIT).

---

### **Thank you for using Rapid CMS!** 🚀
If you have any questions or issues, feel free to open a discussion or report an issue in the repository.

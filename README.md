# Task and Note Management API

This is a task and note management system built using Laravel 11.

## Installation Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/ashu555/task-note-app.git

   
2. Go to the folder
   ```bash
   cd task-note-app



3. Install dependencies
   ```bash
   composer install


4. Set up the environment file:
   ```bash
   cp .env.example .env

5. Configure the .env file with your database credentials.

6. Run the database migrations
   ```bash
   php artisan migrate

7. Seed the database with test data:
   ```bash
   php artisan db:seed --class=TaskNoteSeeder

8. Generate Application key
   ```bash
   php artisan key:generate

9. Install laravel sanctum
   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate

10. Start the application
    ```bash
    php artisan serve
   



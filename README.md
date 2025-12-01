# Blog Website

A modern blog website built with Laravel, featuring user authentication, blog post management, and comments.

## Features

- User registration and authentication
- Create, read, update, and delete blog posts
- Comment system for blog posts
- Responsive design
- Admin dashboard for content management

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/dhavalrajput2004/blogs-website.git
   cd blogs-website
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

8. (Optional) Seed the database with sample data:
   ```bash
   php artisan db:seed
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

10. In a new terminal, compile the assets:
    ```bash
    npm run dev
    ```

Visit `http://localhost:8000` in your browser to see the application.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-source and available under the [MIT License](LICENSE).

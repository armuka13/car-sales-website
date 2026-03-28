# 🚗 Car Sales Website

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A modern, high-performance car sales platform built with Laravel 12. This project features a sleek UI with glassmorphism effects, multi-language support (English/German), and a robust admin dashboard for inventory management.

---

## ✨ Key Features

-   **🔍 Advanced AJAX Search**: Fast and responsive car searching without page reloads.
-   **🌍 Multi-Language Support**: Seamlessly switch between English and German.
-   **⭐ Favorites System**: Users can save their favorite cars for quick access.
-   **🖼️ Dynamic Car Gallery**: High-quality image support for car listings.
-   **🛠️ Admin Dashboard**: Full CRUD capabilities for car listings and site settings.
-   **🔒 Secure Admin Access**: Protected admin routes with a custom login portal.
-   **🎨 Premium UI/UX**: Built with a blend of Bootstrap 5 and Tailwind CSS 4, featuring modern animations and glassmorphism.

---

## 🚀 Tech Stack

-   **Backend**: [Laravel 12](https://laravel.com) (PHP 8.2+)
-   **Frontend**: [Blade Templates](https://laravel.com/docs/blade), [Bootstrap 5](https://getbootstrap.com), [Tailwind CSS 4](https://tailwindcss.com)
-   **Build Tool**: [Vite](https://vitejs.dev)
-   **Database**: MySQL / SQLite
-   **Interactions**: [Axios](https://axios-http.com)

---

## 🛠️ Installation & Setup

Follow these steps to get the project running locally:

### 1. Prerequisites
Ensure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & NPM

### 2. Clone and Install
```bash
# Install PHP dependencies
composer install

# Install JS dependencies
npm install
```

### 3. Environment Configuration
```bash
# Create .env file
cp .env.example .env

# Generate application key
php artisan key:generate
```
*Note: Update your `.env` with your database credentials.*

### 4. Database Setup
```bash
# Run migrations
php artisan migrate
```

### 5. Start the Application
```bash
# Run the development server (runs Artisan and Vite concurrently)
composer run dev
```

---

## 🔑 Admin Access

The admin dashboard is located at a secure URL:
`http://localhost:8000/portal-access-admin-login-159-753`

---

## 📂 Project Structure

-   `app/Http/Controllers`: Contains the logic for Home and Admin management.
-   `resources/views`: Blade templates for the frontend and admin panel.
-   `routes/web.php`: Defines the web and API routes.
-   `database/migrations`: Database schema definitions.

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

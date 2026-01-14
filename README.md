# pharmacySys

A professional pharmacy management system built with Laravel and Livewire.

## Features

- **Customer Management**: track customer details and history.
- **Branch Management**: handle multiple pharmacy branches.
- **Supplier Management**: manage your inventory suppliers.
- **Expense Tracking**: keep track of your pharmacy's financial outgoings.
- **User Roles & Permissions**: fine-grained access control for staff and administrators.
- **Global Search**: quickly find customers and suppliers across the system.
- **Dashboard**: overview of key business metrics and trends.

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Livewire 3, Tailwind CSS, Alpine.js
- **Database**: MySQL

## Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/manarnew/pharmacySys.git
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Configure your environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations and seed data:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Start the development server:
   ```bash
   php artisan serve
   ```

## License

MIT

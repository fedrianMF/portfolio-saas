# Portfolio SaaS

## Development Setup

### Prerequisites
- **PHP** >= 8.2
- **Composer**
- **Node.js** & **NPM**

### Quick Start

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   Ensure `database/database.sqlite` exists (default config), or configure your database in `.env`.
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

4. **Serve Application**
   ```bash
   composer run dev
   ```
   This command starts the Laravel server, queue worker, logs, and Vite simultaneously.

   Access the app at [http://localhost:8000](http://localhost:8000).

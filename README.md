## Blog Backend


## Installation Steps

1. Clone the repository:
   
```bash
https://github.com/developermithu/api-blog-laravel.git
```

2. Change directory:

```bash
cd api-blog-laravel
```

3. Install dependencies:

```bash
composer install
```

4. Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

5. Generate the application key:

```bash
php artisan key:generate
```

6. Update the database configuration in the `.env` file:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api-blog-laravel
DB_USERNAME=root
DB_PASSWORD=
```

7. Migrate and seed the database:

```bash
php artisan migrate:fresh --seed    
```

8. Start the development server:

```bash
php artisan serve --host=localhost
```

we explicitly set the host to `localhost` to avoid sanctum cors issues.

9. Open the application in your web browser at `http://localhost:8000`.


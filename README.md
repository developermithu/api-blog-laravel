## Blog Backend API

A Laravel-based RESTful API for managing blog posts and categories. 

## Features

- Authentication with Laravel Sanctum
- Post management (CRUD operations)
- Category management
- Role-based access control (Admin/User)
- Soft deletes for posts
- Media uploads for post images

[Frontend Repository](https://github.com/developermithu/nextjs-api-blog.git)

## Installation Steps

1. Clone the repository:
   
```bash
git clone https://github.com/developermithu/api-blog-laravel.git
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
php artisan serve 
```

1. Open the application in your web browser at `http://localhost:8000`.

## API Documentation

### Authentication

#### Register

```http
POST /api/register
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `name` | `string` | **Required**. User's name |
| `email` | `string` | **Required**. User's email |
| `password` | `string` | **Required**. User's password |

#### Login

```http
POST /api/login
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `email` | `string` | **Required**. User's email |
| `password` | `string` | **Required**. User's password |

### Posts

#### Get All Posts

```http
GET /api/posts
```

#### Get Single Post

```http
GET /api/posts/{id}
```

#### Create Post (Admin Only)

```http
POST /api/posts
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `title` | `string` | **Required**. Post title |
| `slug` | `string` | **Required**. Post slug |
| `content` | `string` | **Required**. Post content |
| `category_id` | `integer` | **Required**. Category ID |
| `status` | `string` | **Required**. Post status (draft/published) |
| `cover image` | `file` | Optional. Post image |

#### Update Post (Admin Only)

```http
PUT /api/posts/{slug}
```

#### Delete Post (Admin Only)

```http
DELETE /api/posts/{slug}
```

### Categories

#### Get All Categories

```http
GET /api/categories
```

#### Get Single Category

```http
GET /api/categories/{id}
```

#### Create Category (Admin Only)

```http
POST /api/categories
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `name` | `string` | **Required**. Category name |
| `slug` | `string` | **Required**. Category slug |

#### Update Category (Admin Only)

```http
PUT /api/categories/{id}
```

#### Delete Category (Admin Only)

```http
DELETE /api/categories/{id}
```

### Authentication

All admin-only endpoints require authentication using a Bearer token. Include the token in the Authorization header:

```http
Authorization: Bearer <your_token>
```
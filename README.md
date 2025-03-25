## Laravel - Inertia - React

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

9. Open the application in your web browser at `http://localhost:8000`.

## API Documentation

### Authentication

All authentication endpoints are prefixed with `/api/auth`.

#### Register

```http
POST /api/auth/register
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `name` | `string` | **Required**. User's name |
| `email` | `string` | **Required**. User's email |
| `password` | `string` | **Required**. User's password |

#### Login

```http
POST /api/auth/login
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `email` | `string` | **Required**. User's email |
| `password` | `string` | **Required**. User's password |

Successful login returns a **Bearer** token that should be used for authenticated requests.

#### Logout

```http
POST /api/auth/logout
```

Requires authentication. Invalidates the current access token.

### Posts

#### Get All Posts

```http
GET /api/posts
```

Supports filtering by:

```http
GET /api/posts?search=query&status=draft&is_featured=true&filter=trash&page=1&per_page=6
```
- search query [search=query]
- status [status=draft/published]
- featured posts [is_featured=true/false]
- trashed posts [filter=all/trash/with_trashed]

#### Get Single Post

```http
GET /api/posts/{slug}
```

#### Create Post (Admin Only)

```http
POST /api/posts
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `title` | `string` | **Required**. Post title |
| `slug` | `string` | **Required**. Post slug |
| `excerpt` | `string` | **Required**. Post excerpt |
| `content` | `string` | **Required**. Post content |
| `category_id` | `integer` | **Required**. Category ID |
| `status` | `string` | **Required**. Post status (draft/published) |
| `is_featured` | `boolean` | Optional. Featured post status |
| `cover_image` | `file` | Optional. Post image |

#### Update Post (Admin Only)

```http
PUT /api/posts/{slug}
```

Accepts the same parameters as the create endpoint.

#### Delete Post (Admin Only)

```http
DELETE /api/posts/{slug}
```

Soft deletes the post. The post can be restored later.

#### Restore Post (Admin Only)

```http
POST /api/posts/{id}/restore
```

Restores a soft-deleted post.

#### Force Delete Post (Admin Only)

```http
DELETE /api/posts/{id}/force-delete
```

Permanently deletes the post.

### Categories

#### Get All Categories

```http
GET /api/categories
```

#### Get Single Category

```http
GET /api/categories/{category}
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
PUT /api/categories/{category}
```

#### Delete Category (Admin Only)

```http
DELETE /api/categories/{category}
```

### Authentication

All admin-only endpoints require authentication using a **Bearer** token. Include the token in the Authorization header:

```http
Authorization: Bearer <your_token>
```

### Error Responses

The API uses standard HTTP status codes to indicate the success or failure of requests:

- `200 OK` - Request succeeded
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request parameters
- `401 Unauthorized` - Missing or invalid authentication token
- `403 Forbidden` - Authenticated but not authorized to access the resource
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation errors

Made with ❤️ by [developermithu](https://developermithu.com)
## API DOCS INSTRUCTIONAL GUIDE
  This docs will guide you on how to use the created apis.

## How to use
- Clone the repository with git clone
- Copy .env.example file to .env and edit database credentials there
- Run composer install
- Run php artisan key:generate
- Run php artisan serve

## Testing On Postman
- Set Content-Type to application/json
- Set Accept to application/json
- Set the Authorization Token for all endpoints except /api/auth/login, /api/auth/register and /api/course/export

## API Information

METHOD | DESCRIPTION | ENDPOINTS
-------|-------------|-----------
POST   | User registration | `/api/auth/register`
POST   | User log in | `/api/auth/login`
GET    | Get all courses | `/api/course/lists`
POST    | Course Registration | `/api/course/register`
GET   | Creat 50 course records   | `/api/course/seed`
GET   | Get all courses as excel  | `/api/course/export`
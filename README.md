# Project Management API

A comprehensive RESTful API for managing projects with dynamic attributes using an Entity-Attribute-Value (EAV) data model, built with Laravel 12 and PHP 8.2.

## Table of Contents

- [Features](#features)
- [System Architecture](#system-architecture)
- [Setup Instructions](#setup-instructions)
- [API Documentation](#api-documentation)
  - [Authentication](#authentication)
  - [Projects](#projects)
  - [Attributes](#attributes)
  - [Attribute Values](#attribute-values)  
  - [Timesheets](#timesheets)
- [Filtering & Pagination](#filtering--pagination)
- [Example Requests/Responses](#example-requestsresponses)
- [Test Credentials](#test-credentials)
- [Error Handling](#error-handling)
- [Security Considerations](#security-considerations)

## Features

- **Authentication**: Secure user authentication with Laravel Passport
- **EAV Model**: Dynamic attributes for flexible project management
- **Advanced Filtering**: Comprehensive filtering system across all resources
- **Role-Based Access**: Admin and regular user permissions
- **Timesheet Management**: Track time spent on projects
- **Pagination**: Control data response size
- **Data Validation**: Request validation to ensure data integrity

## System Architecture

The API implements the Entity-Attribute-Value (EAV) pattern for dynamic attributes:

- **Entities**: Projects are the primary entities
- **Attributes**: Define metadata fields (name, type)
- **Values**: Store the actual data values

This design allows for flexible attribute management without database schema changes.

## Setup Instructions

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL or PostgreSQL
- Laravel 12.x
- Passport 12.x

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/AbdoHany98/astudio-practical-assessment.git
   cd project-management-api
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure environment**:
   ```bash
   cp .env.example .env
   ```
   Edit the `.env` file with your database credentials and application settings.

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Run migrations and seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Install Passport**:
   ```bash
   php artisan passport:install
   ```

7. **Start the development server**:
   ```bash
   php artisan serve
   ```

## API Documentation

All API endpoints return JSON responses with consistent structures:

```json
{
  "success": true|false,
  "message": "Operation status message (when applicable)",
  "data": { ... }
}
```

### Authentication

| Method | Endpoint           | Description                     | Required Fields                                | Response                                  |
|--------|--------------------|----------------------------------|------------------------------------------------|-------------------------------------------|
| POST   | /api/register      | Register a new user              | name, email, password, password_confirmation   | User data + API token                     |
| POST   | /api/login         | Login with credentials           | email, password                                | User data + API token                     |
| POST   | /api/logout        | Logout (invalidate token)        | -                                              | Success message                           |

### Projects

| Method | Endpoint             | Description                   | Query Parameters                                     | Authorization      |
|--------|----------------------|-------------------------------|-----------------------------------------------------|-------------------|
| GET    | /api/projects        | List projects with pagination | filters, paginate                                   | Required          |
| POST   | /api/projects        | Create new project            | -                                                   | Admin Required    |
| GET    | /api/projects/{id}   | Get specific project          | -                                                   | Required          |
| PUT    | /api/projects/{id}   | Update project                | -                                                   | Admin Required    |
| DELETE | /api/projects/{id}   | Delete project                | -                                                   | Admin Required    |

### Attributes

| Method | Endpoint                | Description                | Query Parameters                             | Authorization |
|--------|-------------------------|----------------------------|---------------------------------------------|---------------|
| GET    | /api/attributes         | List attributes            | name, type, created_from, created_to, paginate, sort_by, sort_dir | Required      |
| POST   | /api/attributes         | Create new attribute       | -                                           | Admin Required|
| GET    | /api/attributes/{id}    | Get attribute with values  | -                                           | Required      |
| PUT    | /api/attributes/{id}    | Update attribute           | -                                           | Admin Required|
| DELETE | /api/attributes/{id}    | Delete attribute           | -                                           | Admin Required|

### Attribute Values

| Method | Endpoint                      | Description                | Query Parameters                                                 | Authorization |
|--------|-------------------------------|----------------------------|------------------------------------------------------------------|---------------|
| GET    | /api/attribute-values         | List attribute values      | attribute_id, entity_id, value, exact_match, attribute_name, attribute_type, created_from, created_to, paginate, sort_by, sort_dir | Required      |
| POST   | /api/attribute-values         | Create new attribute value | -                                                                | Admin Admin Required Or Project User      |
| GET    | /api/attribute-values/{id}    | Get attribute value        | -                                                                | Required      |
| PUT    | /api/attribute-values/{id}    | Update attribute value     | -                                                                | Admin Required Or Project User      |
| DELETE | /api/attribute-values/{id}    | Delete attribute value     | -                                                                | Admin Required Or Project User      |

### Timesheets

| Method | Endpoint                | Description            | Query Parameters                       | Authorization |
|--------|-------------------------|------------------------|---------------------------------------|---------------|
| GET    | /api/timesheets         | List timesheets        | user_id, project_id, date_from, date_to | Required      |
| POST   | /api/timesheets         | Create timesheet       | -                                     | Admin Required Or Project User      |
| GET    | /api/timesheets/{id}    | Get timesheet          | -                                     | Admin Required Or Project User      |
| PUT    | /api/timesheets/{id}    | Update timesheet       | -                                     | Admin Required Or Project User      |
| DELETE | /api/timesheets/{id}    | Delete timesheet       | -                                     | Admin Required Or Project User      |

## Filtering & Pagination

### Project Filtering

Projects can be filtered using the `filters` query parameter:

- Standard filtering: `?filters[name]=ProjectName`
- Operator filtering: `?filters[name:like]=Project`

Available operators:
- `=` (default): Exact match
- `like`: Partial match (case-insensitive)
- `>`, `<`, `>=`, `<=`: Comparison operators for numeric fields

### Attribute Filtering

Attributes can be filtered using specific query parameters:
- `?name=client` - Filter by name (partial match)
- `?type=text` - Filter by type (exact match)
- `?created_from=2023-01-01&created_to=2023-12-31` - Date range filtering

### Pagination

All list endpoints support pagination using:
- `?paginate=10` - Number of results per page

### Sorting

Add sorting capabilities:
- `?sort_by=name&sort_dir=asc` - Sort by field in ascending or descending order

## Example Requests/Responses

### Create a Project with Attributes

**Request:**
```http
POST /api/projects
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your_token}

{
  "name": "Website Redesign",
  "status": "active",
  "users": [1, 2],
  "attributes": [
    {
      "attribute_id": 1,
      "value": "Company XYZ"
    },
    {
      "attribute_id": 2,
      "value": "10000"
    }
  ]
}
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "name": "Website Redesign",
    "status": "active",
    "attributes": [
      {
        "id": 1,
        "name": "client",
        "type": "text",
        "value": "Company XYZ"
      },
      {
        "id": 2,
        "name": "budget",
        "type": "number",
        "value": "10000"
      }
    ],
    "users": [
      {
        "id": 1,
        "name": "John Doe"
      },
      {
        "id": 2,
        "name": "Jane Smith"
      }
    ],
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
}
```

### Filter Projects by Attribute

**Request:**
```http
GET /api/projects?filters[client:like]=XYZ
Accept: application/json
Authorization: Bearer {your_token}
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Website Redesign",
      "status": "active",
      "attributes": [
        {
          "id": 1,
          "name": "client",
          "type": "text",
          "value": "Company XYZ"
        },
        {
          "id": 2,
          "name": "budget",
          "type": "number",
          "value": "10000"
        }
      ],
      "users": [...],
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Test Credentials

For testing purposes, the following credentials are available after running the seeders:

**Admin User:**
- Email: admin@example.com
- Password: password

**Regular User:**
- Email: user@example.com
- Password: password

## Error Handling

The API returns appropriate HTTP status codes and error messages:

- `200 OK`: Successful operation
- `201 Created`: Resource created successfully
- `400 Bad Request`: Invalid input data
- `401 Unauthorized`: Authentication failure
- `403 Forbidden`: Permission denied
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation errors
- `500 Internal Server Error`: Server error

## Security Considerations

- All API requests (except authentication) require a valid Bearer token
- Password hashing is handled by Laravel's built-in mechanisms
- CORS is configured to allow specific origins only
- Input validation is applied to all endpoints
- Resource permissions are checked before operations

---

**Note**: All API requests require the following headers:
- `Content-Type: application/json`
- `Accept: application/json`
- `Authorization: Bearer {your_token}` (except for login/register)

For more detailed examples, please refer to the Postman collection included with this project.
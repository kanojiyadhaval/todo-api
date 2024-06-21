
# Todo Application with Symfony API

This repository contains a simple Todo application built with Symfony framework, exposing RESTful API endpoints for managing Todos.

## Prerequisites

- Docker installed on your machine ([Docker Installation Guide](https://docs.docker.com/get-docker/))
- Basic understanding of Docker and Symfony framework

## Setup Instructions

### 1. Clone the Repository

```bash
git clone <repository_url>
cd <repository_directory>
```

### 2. Set Environment Variables

Create a `.env` file based on `.env.dist` and configure any necessary environment variables.

```bash
cp .env.dist .env
```

### 3. Build and Run Docker Containers

```bash
docker-compose up -d --build
```

This command builds the Docker images defined in `docker-compose.yml` and starts the containers in detached mode (`-d`).

### 4. Install Composer Dependencies

Access the PHP container and install Composer dependencies.

```bash
docker-compose exec php composer install
```

### 5. Set Up the Database

Run Symfony migrations to create the database schema.

```bash
docker-compose exec php bin/console doctrine:migrations:migrate
```

### 6. Accessing the Application

The Symfony application will be running at `http://localhost:8000`. You can access the API endpoints using tools like Postman or cURL.

## API Endpoints

### Retrieve all Todos

- **GET** `/api/todos`

Retrieve a list of all Todos.

### Create a Todo

- **POST** `/api/todos`

Create a new Todo. Send a JSON body with `title`, `description`, and `status`.

### Retrieve a Todo by ID

- **GET** `/api/todos/{id}`

Retrieve a single Todo by its ID.

### Update a Todo by ID

- **PUT** `/api/todos/{id}`

Update an existing Todo by its ID. Send a JSON body with `title`, `description`, and `status`.

### Delete a Todo by ID

- **DELETE** `/api/todos/{id}`

Delete a Todo by its ID.

## Testing

To run tests:

```bash
docker-compose exec php bin/phpunit
```

This command executes PHPUnit tests located in the `tests` directory.

## Stopping the Application

To stop and remove the Docker containers:

```bash
docker-compose down
```

---

### Notes:

- Adjust paths and commands according to your project structure and requirements.
- Provide additional details or troubleshooting steps as needed.

This README file provides a comprehensive guide to setting up your Symfony application with Docker, accessing the API endpoints, running tests, and managing Docker containers. Adjust the instructions based on your specific project details and environment configurations.

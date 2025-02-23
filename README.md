# Pawnect

A one paragraph description.

## Getting Started

### Prerequisities

Before you start, make sure you have the following items installed on your machine:

- [Docker](https://docs.docker.com/engine/install/) : to create containers and manage images
- [Docker Compose](https://docs.docker.com/compose/install/) : to orchestrate multiple containers

### Install project

#### 1. Clone the Project

Clone the repository to your local machine :

```
git clone https://github.com/solene-sephi/pawnect.git pawnect
```

This will create a folder named pawnect containing the project files.

#### 2. Navigate to the Project Directory

Move into the newly created project folder:

```
cd pawnect
```

All further commands should be run from this directory.

#### 3. Build the Docker Images

Build the required Docker images:

```
docker compose build --no-cache
```

The `--no-cache` option ensures that all images are rebuilt from scratch, avoiding potential conflicts from old cached versions.

#### 4. Start the Containers

Start the project and wait for all services to be ready:

```
docker compose up --pull always -d --wait
```

- The `--pull always` flag ensures the latest versions of images are used.
- The `-d` flag runs the containers in the background (detached mode).
- The `--wait` flag ensures the database and other dependencies are ready before continuing.
  Once the command completes, your Symfony application should be running inside Docker.

#### 5. Configure the Database

The project uses PostgreSQL as the database. Docker automatically creates a database and a default user `app` when launching the containers.

- Environment Variables

Create a `.env.local` file at the root of the project and add the following variables:

```
POSTGRES_DB=pawnect_db
```

- Enable Environment Variable Overriding
  By default, Symfony does not override environment variables. To enable this, modify your `composer.json` file and add:

```
"extra": {
    "runtime": {
        "dotenv_overload": true
    }
}
```

- Rebuild and Restart Docker
  After updating the environment variables, restart the containers:

```
docker compose build --no-cache
docker compose up --pull always -d --wait
```

#### 6. Check Database Connection

To ensure the database is properly set up, run:

```
docker compose exec database psql -U app -d pawnect_db
```

If you can access the database, the setup is correct. Type `\q` to exit.

#### 7. Running Migrations

After setting up the database, apply migrations:

```
symfony console doctrine:migrations:migrate
```

This will create the necessary tables for your project.

#### 9. Running the Project

The application should now be accessible in the browser at:

🔗 http://localhost

You’re all set! 🚀

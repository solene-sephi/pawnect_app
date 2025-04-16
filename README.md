# Pawnect

**Pawnect** is a web platform designed to connect animal shelters, foster families, and adopters. It streamlines animal management for organizations and simplifies the adoption process, helping ensure animal welfare through better communication and follow-up.

## 🚀 Goals

- Simplify animal management for shelters and foster families.
- Centralize visit and adoption requests.
- Automate repetitive admin tasks.
- Ensure follow-up and tracking of adoptions and foster care.
- Encourage transparency and interaction between users.

## 📚 Key Features

- User authentication with role management (visitor, foster family, shelter, admin)
- Animal management (profiles, media, history, filters)
- Foster family application system + validation workflow
- Visit request system with calendar availability
- Internal messaging system and notifications
- Favorites, adoption feedback, and stories
- Interactive map with geolocation of shelters
- Admin panel with statistics and data export
- Automation of recurring validations

⚠️ The project is under development. Some of the features listed are still in progress.

## 🧰 Tech Stack

For a detailed breakdown of the technologies used in this project, including the frameworks, tools, and libraries, please refer to the [Tech Stack documentation](doc/stack.md).

## 🔧 Getting Started

### Prerequisities

Before you start, make sure you have the following items installed on your machine:

- [Docker](https://docs.docker.com/engine/install/) : to create containers and manage images
- [Docker Compose](https://docs.docker.com/compose/install/) : to orchestrate multiple containers

### Install project

#### 1. Clone the Project

Clone the repository to your local machine :

```
git clone https://github.com/solene-sephi/pawnect_app.git pawnect
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

#### 6. Check Database Connection

To manually check if the database is up and running, you can open a psql session inside the container:

```
docker compose exec database psql -U app -d app
```

If you can access the database, the setup is correct. Type `\q` to exit.

#### 7. Running Migrations

After setting up the database, apply migrations:

```
docker compose exec php bin/console doctrine:migrations:migrate
```

This will create the necessary tables for your project.

#### 8. Loading Fixtures

To populate the database with sample data, you can load fixtures:

```
docker compose exec php bin/console doctrine:fixtures:load
```

This will insert predefined test data into the database to help you quickly test the application.

#### 9. Running the Project

The application should now be accessible in the browser at:

🔗 http://localhost

You’re all set! 🚀

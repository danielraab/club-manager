# Docker Setup

This directory contains Docker configurations for running the Laravel application in both development and production environments.

## Directory Structure

```
docker/
├── development/
│   ├── docker-compose.yml
│   └── Dockerfile
└── production/
    ├── docker-compose.yml
    ├── Dockerfile
    ├── nginx/
    └── php/
```

## Development Environment

The development setup uses **Laravel Sail**, which provides a simple command-line interface for interacting with Laravel's default Docker configuration.

### Prerequisites

- Docker Desktop installed and running
- Composer installed on your host machine (for initial setup only)

### Services

- **laravel.test** - Main Laravel application (PHP 8.3)
- **mariadb** - MariaDB 10 database server
- **phpmyadmin** - Database management interface (http://localhost:8080)
- **mailpit** - Email testing tool

### Getting Started

1. **Initial Setup** (first time only):
   ```bash
   # From project root
   cp .env.example .env
   
   # Configure environment variables
   echo "WWWUSER=$(id -u)" >> .env
   echo "WWWGROUP=$(id -g)" >> .env
   
   # for docker compose use
   cp docker/development/.env.example docker/development/.env
   sed -i "s/WWWUSER=1000/WWWUSER=$(id -u)/" docker/development/.env
   sed -i "s/WWWGROUP=1000/WWWGROUP=$(id -g)/" docker/development/.env
   
   # Install dependencies using Docker (without Sail installed yet)
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php83-composer:latest \
       composer install --ignore-platform-reqs
   ```

2. **Start Sail**:
   ```bash
   export SAIL_FILES=docker/development/docker-compose.yml
   # From project root
   ./vendor/bin/sail up -d
   ```

3. **Application Setup** (first time only):
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run dev
   ```

### Sail Alias (Recommended)

Add this to your `~/.bashrc` or `~/.zshrc`:

```bash
export SAIL_FILES=docker/development/docker-compose.yml
alias sail='./vendor/bin/sail'
```

Then you can use `sail` instead of `./vendor/bin/sail`:

```bash
sail up -d
sail artisan migrate
sail composer require package/name
```

### Access Points

- **Application**: http://localhost (port configured via `APP_PORT`, default: 80)
- **Vite Dev Server**: http://localhost:5173 (port configured via `VITE_PORT`)
- **phpMyAdmin**: http://localhost:8080
- **Mailpit**: http://localhost:8025 (port configured via `FORWARD_MAILPIT_DASHBOARD_PORT`)
- **Database**: localhost:3306 (port configured via `FORWARD_DB_PORT`)

### Environment Variables

This project requires `.env` files in **two locations** due to the custom docker-compose.yml path:

#### Root `.env` file (required for Sail and Laravel)
Configure these in `/var/www/html/.env`:

- `SAIL_FILES` - Path to docker-compose file (required: `docker/development/docker-compose.yml`)
- `APP_PORT` - Application HTTP port (default: 80)
- `APP_SERVICE` - Docker service name (default: laravel.test)
- `WWWUSER` - User ID for file permissions
- `WWWGROUP` - Group ID for file permissions
- `DB_HOST` - Database host (use `mariadb` for Sail)
- `DB_DATABASE` - Database name
- `DB_USERNAME` - Database user
- `DB_PASSWORD` - Database password
- All Laravel application variables

#### Docker Development `.env` file (required for docker-compose port mappings)
Copy/sync these variables to `docker/development/.env`:

- `FORWARD_DB_PORT` - MariaDB port (default: 3306)
- `FORWARD_MAILPIT_PORT` - Mailpit SMTP port (default: 1025)
- `FORWARD_MAILPIT_DASHBOARD_PORT` - Mailpit web interface port (default: 8025)
- `VITE_PORT` - Vite development server port (default: 5173)
- `WWWUSER` - User ID for file permissions
- `WWWGROUP` - Group ID for file permissions

**Important:** 
1. **Sail sources the root `.env`** for variables like `APP_PORT` and `SAIL_FILES`
2. **Docker Compose reads `docker/development/.env`** for port forwarding variables like `FORWARD_DB_PORT`
3. Keep both files in sync for shared variables (`WWWUSER`, `WWWGROUP`, database credentials)
4. Use the provided `.env.example` files as templates for both locations

### Common Commands

```bash
# Start Sail (from project root)
./vendor/bin/sail up -d

# Stop Sail
./vendor/bin/sail down

# View logs
./vendor/bin/sail logs -f

# Access Laravel container shell
./vendor/bin/sail shell

# Run artisan commands
./vendor/bin/sail artisan [command]

# Run Composer commands
./vendor/bin/sail composer [command]

# Run NPM commands
./vendor/bin/sail npm [command]

# Run tests
./vendor/bin/sail test

# Rebuild containers
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d
```

### Debugging with Xdebug

Xdebug is available and can be configured via environment variables:

```bash
# Enable Xdebug
./vendor/bin/sail up -d --env SAIL_XDEBUG_MODE=debug

# Or add to .env file
SAIL_XDEBUG_MODE=debug
SAIL_XDEBUG_CONFIG=client_host=host.docker.internal
```

### Direct Docker Compose Access

If you need to use docker compose directly (instead of Sail):

```bash
cd docker/development
docker compose up -d
docker compose exec laravel.test bash
```

**Note:** When using docker compose directly from the `docker/development/` directory, ensure the `.env` file exists in that directory (not just in the project root).

## Production Environment

The production setup uses pre-built Docker images from GitHub Container Registry, optimized for deployment.

### Services

- **app** - Laravel application (PHP-FPM) - uses `ghcr.io/danielraab/club-manager:latest`
- **webserver** - Nginx web server
- **db** - MariaDB 11.2 database server
- **scheduler** - Laravel task scheduler - uses `ghcr.io/danielraab/club-manager:latest`

### Docker Image

The production environment pulls the latest Docker image automatically built by GitHub Actions when you push a new version tag (e.g., `v1.0.0`).

To use a specific version:

```yaml
# In docker/production/docker-compose.yml
image: ghcr.io/danielraab/club-manager:1.0.0  # Instead of :latest

### Getting Started

1. **Pull the latest image**:
   ```bash
   docker pull ghcr.io/danielraab/club-manager:latest
   ```

2. **Navigate to the production directory**:
   ```bash
   cd docker/production
   ```

3. **Configure environment variables** in `.env` file at the project root

4. **Start the containers**:
   ```bash
   docker compose up -d
   ```

5. **Set up the application** (first time only):
   ```bash
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate --force
   docker compose exec app php artisan storage:link
   docker compose exec app php artisan config:cache
   docker compose exec app php artisan route:cache
   docker compose exec app php artisan view:cache
   ```

### Volume Mounts

The production setup only mounts the `storage` directory (not the full application):

- **app/scheduler**: `storage/` for logs, cache, and uploaded files
- **webserver**: `storage/app/public` and `public/` for serving static assets

All application code is contained within the Docker image.

### Access Points

- **Application**: http://localhost (HTTP) and https://localhost (HTTPS)
- **Database**: localhost:3306 (port configured via `FORWARD_DB_PORT`)

### Environment Variables

Configure these in your `.env` file:

- `DB_DATABASE` - Database name (default: laravel)
- `DB_USERNAME` - Database user (default: laravel)
- `DB_PASSWORD` - Database password (default: secret)
- `FORWARD_DB_PORT` - MariaDB port (default: 3306)

### Custom Configuration

- **Nginx**: Custom configuration files in `nginx/nginx.conf` and `nginx/conf.d/`
- **PHP**: Custom PHP settings in `php/php.ini`

### Common Commands

```bash
# Pull latest image
docker pull ghcr.io/danielraab/club-manager:latest

# Start containers
docker compose up -d

# Stop containers
docker compose down

# View logs
docker compose logs -f [service-name]

# Access app container shell
docker compose exec app bash

# Run artisan commands
docker compose exec app php artisan [command]

# Restart a specific service
docker compose restart [service-name]

# Update to latest image
docker compose pull
docker compose up -d

# Clear Laravel caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

### Scheduler Service

The scheduler service automatically runs Laravel's scheduled tasks every minute using the same Docker image as the app. This replaces the need for a cron job on the host system.

### Building New Images

Images are automatically built and pushed to GitHub Container Registry when you push a new version tag:

```bash
git tag v1.0.0
git push origin v1.0.0
```

The GitHub Actions workflow will build and push the image as `ghcr.io/danielraab/club-manager:1.0.0` and update the `latest` tag.

### Health Checks

- MariaDB includes a health check that monitors database availability
- Ensure dependent services wait for healthy status before starting

## General Tips

### File Permissions

If you encounter permission issues, ensure the `WWWUSER` and `WWWGROUP` environment variables match your host system's user ID and group ID:

```bash
# Update root .env
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env

# Update docker/development/.env
sed -i "s/WWWUSER=.*/WWWUSER=$(id -u)/" docker/development/.env
sed -i "s/WWWGROUP=.*/WWWGROUP=$(id -g)/" docker/development/.env
```

### Database Backups

To backup the database:

```bash
# Development (using Sail)
./vendor/bin/sail mysql "mysqldump ${DB_DATABASE}" > backup.sql

# Or with direct docker compose
cd docker/development
docker compose exec mariadb mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql

# Production
cd docker/production
docker compose exec db mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql
```

To restore:

```bash
# Development (using Sail)
./vendor/bin/sail mysql "${DB_DATABASE}" < backup.sql

# Or with direct docker compose
cd docker/development
docker compose exec -T mariadb mysql -u root -p${DB_PASSWORD} ${DB_DATABASE} < backup.sql

# Production
cd docker/production
docker compose exec -T db mysql -u root -p${DB_PASSWORD} ${DB_DATABASE} < backup.sql
```

### Persistent Data

Both setups use named volumes for database storage:
- Development: `sail-mariadb`
- Production: `dbdata`

To remove volumes (WARNING: this deletes all data):

```bash
docker compose down -v
```

## Troubleshooting

### Port Conflicts

If you get port binding errors, either:
1. Change the port mapping in `.env` file
2. Stop the conflicting service on your host

### Container Won't Start

```bash
# Check logs (Development - from project root)
./vendor/bin/sail logs [service-name]

# Check logs (Production)
cd docker/production
docker compose logs [service-name]

# Rebuild from scratch (Development)
./vendor/bin/sail down -v
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d

# Rebuild from scratch (Production - pull latest image)
cd docker/production
docker compose down -v
docker compose pull
docker compose up -d
```

### Database Connection Issues

Ensure:
1. Database credentials in `.env` match the docker compose configuration
2. `DB_HOST` is set to the correct service name (`mariadb` for dev, `db` for prod)
3. Database container is healthy: `docker compose ps`

## Migration Between Environments

To migrate data from development to production:

1. **Export from development**:
   ```bash
   # From project root using Sail
   ./vendor/bin/sail mysql "mysqldump ${DB_DATABASE}" > backup.sql
   ```

2. **Import to production**:
   ```bash
   cd docker/production
   docker compose exec -T db mysql -u root -p${DB_PASSWORD} ${DB_DATABASE} < ../../backup.sql
   ```

## CI/CD with GitHub Actions

The project includes a GitHub Actions workflow that automatically builds and publishes Docker images:

- **Trigger**: Pushing version tags (e.g., `v1.0.0`, `v2.1.3`)
- **Registry**: GitHub Container Registry (ghcr.io)
- **Workflow file**: `.github/workflows/docker-build.yml`

**To deploy a new version**:

```bash
# Tag your release
git tag v1.0.0
git push origin v1.0.0

# Wait for GitHub Actions to build the image
# Then pull and restart on production server
cd docker/production
docker compose pull
docker compose up -d
```

## Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Nginx Documentation](https://nginx.org/en/docs/)

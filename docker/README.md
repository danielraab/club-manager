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

The development setup uses Laravel Sail for a streamlined local development experience.

### Services

- **laravel.test** - Main Laravel application (PHP 8.3)
- **mariadb** - MariaDB 10 database server
- **phpmyadmin** - Database management interface
- **mailpit** - Email testing tool

### Getting Started

1. Navigate to the development directory:
   ```bash
   cd docker/development
   ```

2. Copy the example environment file (if not already done):
   ```bash
   cp ../../.env.example ../../.env
   ```

3. Start the containers:
   ```bash
   docker-compose up -d
   ```

4. Install dependencies (first time only):
   ```bash
   docker-compose exec laravel.test composer install
   docker-compose exec laravel.test npm install
   ```

5. Generate application key (first time only):
   ```bash
   docker-compose exec laravel.test php artisan key:generate
   ```

6. Run migrations:
   ```bash
   docker-compose exec laravel.test php artisan migrate
   ```

### Access Points

- **Application**: http://localhost (port configured via `APP_PORT`, default: 80)
- **Vite Dev Server**: http://localhost:5173 (port configured via `VITE_PORT`)
- **phpMyAdmin**: http://localhost:8080
- **Mailpit**: http://localhost:8025 (port configured via `FORWARD_MAILPIT_DASHBOARD_PORT`)
- **Database**: localhost:3306 (port configured via `FORWARD_DB_PORT`)

### Environment Variables

Configure these in your `.env` file:

- `APP_PORT` - Application HTTP port (default: 80)
- `VITE_PORT` - Vite development server port (default: 5173)
- `FORWARD_DB_PORT` - MariaDB port (default: 3306)
- `FORWARD_MAILPIT_PORT` - Mailpit SMTP port (default: 1025)
- `FORWARD_MAILPIT_DASHBOARD_PORT` - Mailpit web interface port (default: 8025)
- `DB_DATABASE` - Database name
- `DB_USERNAME` - Database user
- `DB_PASSWORD` - Database password
- `WWWUSER` - User ID for file permissions
- `WWWGROUP` - Group ID for file permissions

### Common Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Access Laravel container shell
docker-compose exec laravel.test bash

# Run artisan commands
docker-compose exec laravel.test php artisan [command]

# Run Composer commands
docker-compose exec laravel.test composer [command]

# Run NPM commands
docker-compose exec laravel.test npm [command]

# Rebuild containers
docker-compose up -d --build
```

### Debugging

Xdebug is available in development mode:

- Configure via `SAIL_XDEBUG_MODE` (e.g., `debug`, `coverage`, `off`)
- Configure client settings via `SAIL_XDEBUG_CONFIG`

## Production Environment

The production setup uses a custom Docker configuration optimized for deployment.

### Services

- **app** - Laravel application (PHP-FPM)
- **webserver** - Nginx web server
- **db** - MariaDB 11.2 database server
- **scheduler** - Laravel task scheduler

### Getting Started

1. Navigate to the production directory:
   ```bash
   cd docker/production
   ```

2. Configure environment variables in `.env` file at the project root

3. Build and start the containers:
   ```bash
   docker-compose up -d --build
   ```

4. Install dependencies (first time only):
   ```bash
   docker-compose exec app composer install --optimize-autoloader --no-dev
   docker-compose exec app npm install
   docker-compose exec app npm run build
   ```

5. Set up the application (first time only):
   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --force
   docker-compose exec app php artisan storage:link
   docker-compose exec app php artisan config:cache
   docker-compose exec app php artisan route:cache
   docker-compose exec app php artisan view:cache
   ```

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
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f [service-name]

# Access app container shell
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan [command]

# Restart a specific service
docker-compose restart [service-name]

# Rebuild and restart
docker-compose up -d --build

# Clear Laravel caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Scheduler Service

The scheduler service automatically runs Laravel's scheduled tasks every minute. This replaces the need for a cron job on the host system.

### Health Checks

- MariaDB includes a health check that monitors database availability
- Ensure dependent services wait for healthy status before starting

## General Tips

### File Permissions

If you encounter permission issues, ensure the `WWWUSER` and `WWWGROUP` environment variables match your host system's user ID and group ID:

```bash
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env
```

### Database Backups

To backup the database:

```bash
# Development
docker-compose exec mariadb mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql

# Production
docker-compose exec db mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql
```

To restore:

```bash
# Development
docker-compose exec -T mariadb mysql -u root -p${DB_PASSWORD} ${DB_DATABASE} < backup.sql

# Production
docker-compose exec -T db mysql -u root -p${DB_PASSWORD} ${DB_DATABASE} < backup.sql
```

### Persistent Data

Both setups use named volumes for database storage:
- Development: `sail-mariadb`
- Production: `dbdata`

To remove volumes (WARNING: this deletes all data):

```bash
docker-compose down -v
```

## Troubleshooting

### Port Conflicts

If you get port binding errors, either:
1. Change the port mapping in `.env` file
2. Stop the conflicting service on your host

### Container Won't Start

```bash
# Check logs
docker-compose logs [service-name]

# Rebuild from scratch
docker-compose down -v
docker-compose up -d --build
```

### Database Connection Issues

Ensure:
1. Database credentials in `.env` match the docker-compose configuration
2. `DB_HOST` is set to the correct service name (`mariadb` for dev, `db` for prod)
3. Database container is healthy: `docker-compose ps`

## Migration Between Environments

To migrate data from development to production:

1. Export from development:
   ```bash
   cd docker/development
   docker-compose exec mariadb mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > ../../backup.sql
   ```

2. Import to production:
   ```bash
   cd docker/production
   docker-compose exec -T db mysql -u root -p${DB_PASSWORD} ${DB_DATABASE} < ../../backup.sql
   ```

## Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Nginx Documentation](https://nginx.org/en/docs/)

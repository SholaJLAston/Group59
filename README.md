# Project Setup Guide (Laravel Sail)

This project uses Laravel Sail as its development environment. Sail provides a complete Docker-based setup, allowing contributors to work without installing PHP, Composer, Node, or MySQL locally. Only Docker (and WSL2 on Windows) is required. The documentation for Laravel Sail is available on [the Laravel website](https://laravel.com/docs/12.x/sail) and provides more details.

---

## 1. Requirements

Before setting up the project, ensure the following are installed and configured:

### Docker

* Install Docker Desktop.
* Ensure Docker is running before executing any commands.

```bash
https://www.docker.com/products/docker-desktop/
```

### Windows Requirements

* Have WSL2 enabled.
* Docker Desktop must be configured to use the WSL2 backend.

---

## 2. Clone the Repository

```bash
git clone <repository-url>
cd <project-directory>
```

---

## 3. Environment File

Duplicate the example environment file:

```bash
cp .env.example .env
```

Update values as necessary.

---

## 4. Install Composer Dependencies (Without Local Composer)

Since the `vendor/` directory is not included in version control, install the dependencies using Sail's official PHP 8.4 Composer image. This ensures the same PHP version used by Sail is used for dependency resolution.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

This step installs the `vendor/` directory and makes the Sail executable available.

---

## 5. Start Sail

```bash
./vendor/bin/sail up -d
```

This will start all required containers (PHP, MySQL, Redis, etc.).

---

## 6. Install Node Dependencies (Inside Sail)

```bash
./vendor/bin/sail npm install
```

For development builds:

```bash
./vendor/bin/sail npm run dev
```

---

## 7. Generate Application Key

```bash
./vendor/bin/sail artisan key:generate
```

---

## 8. Run Database Migrations

```bash
./vendor/bin/sail artisan migrate
```

---

## 9. Accessing the Application

After Sail is running, the application will be available at:

```
http://localhost
```

If ports have been customized, adjust accordingly.

phpMyAdmin will be available at:

```bash
http://localhost:8080
```

---

## 10. Stopping the Environment

```bash
./vendor/bin/sail down
```

---

## Optional, configure shell alias

Sail commands are invoked using the vendor/bin/sail:

```bash
./vendor/bin/sail up

```
However this can be simplified with a shell alias:

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

When configured, the command is simply:

```bash
sail up
```
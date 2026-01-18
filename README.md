# Urban Reads LMS

This is a PHP-based Library Management System (LMS) with Docker support.

---

## Requirements

- Docker & Docker Compose installed
- Web browser

---

## Setup Instructions

1. **Build and start the Docker containers**

```bash
docker-compose build
docker-compose up -d


http://localhost:8080


http://localhost:8080/migration/migrate.php


Access Admin Panel

Username: admin

Password: admin

⚠️ Important: After running the migration, delete migration/migrate.php to prevent unauthorized re-runs.


Notes

The database connection is configured in dbconfig.php.

Initial books data are inserted during migration.

Foreign key checks are disabled during migration to avoid dependency issues.

Use Docker volumes for persistent data.

Make sure port 8080 is free on your machine.

Docker Compose Overview

PHP + Apache container

MySQL container

Exposed port: 8080 for PHP web server


---

If you want, I can also **combine this with a fully completed `migrate.php`** containing **all 34 books from your SQL** so it’s truly one copy-paste migration for your Docker setup.  

Do you want me to do that next?


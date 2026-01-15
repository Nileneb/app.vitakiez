# Deployment Guide

## Building & Deploying

**IMPORTANT:** Always use `./build.sh` instead of `docker-compose build`!

### Why?

The nginx container depends on the php-fpm image to copy built assets. Docker Compose doesn't automatically rebuild dependent images in the correct order.

### Build & Start

```bash
# Build all containers AND start them (one command!)
./build.sh
```

That's it. No need to run `docker-compose up -d` separately.

### What build.sh does

1. Builds `php-fpm` (contains app code + Vite assets)
2. Builds `web` (nginx, copies assets from php-fpm)
3. Builds `php-cli` (based on php-fpm)
4. Builds `queue-worker` (based on php-fpm)

### Quick Commands

```bash
# Full rebuild and start (automatic!)
./build.sh

# View logs
docker-compose logs -f php-fpm

# Clear Laravel caches
docker exec appvitakiez-php-fpm-1 php artisan optimize:clear

# Run migrations
docker exec appvitakiez-php-fpm-1 php artisan migrate

# Stop all services
docker-compose down
```

## Never Do This

❌ `docker-compose build` (builds in random order)
❌ `docker-compose up -d --build` (same problem)
❌ Manual builds + manual start (unnecessary steps)

## Always Do This

✅ `./build.sh` (builds + starts automatically)

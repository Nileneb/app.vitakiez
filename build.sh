#!/bin/bash
set -e

echo "🔨 Building app.vitakiez containers..."
echo ""

# 1. Build php-fpm first (contains all app code + built assets)
echo "📦 Building php-fpm..."
docker-compose build php-fpm

# 2. Build nginx (depends on php-fpm image)
echo "🌐 Building nginx..."
docker-compose build web

# 3. Rebuild other services that depend on php-fpm
echo "🔧 Building php-cli..."
docker-compose build php-cli

echo "⚙️  Building queue-worker..."
docker-compose build queue-worker

echo ""
echo "✅ All containers built successfully!"
echo ""
echo "🚀 Starting services..."
docker-compose up -d

echo ""
echo "🔑 Checking N8N_LARAVEL_API_TOKEN..."
if ! grep -q "^N8N_LARAVEL_API_TOKEN=.*|.*" .env 2>/dev/null || grep -q "^N8N_LARAVEL_API_TOKEN=$" .env 2>/dev/null; then
    echo "⚠️  No valid N8N_LARAVEL_API_TOKEN found, generating new token..."
    NEW_TOKEN=$(docker-compose exec -T php-fpm php artisan tinker --execute="\$user=App\\Models\\User::first(); if(\$user) echo \$user->createToken('n8n')->plainTextToken; else echo 'NO_USER';" 2>/dev/null | tr -d '\r\n')

    if [ "$NEW_TOKEN" != "NO_USER" ] && [ -n "$NEW_TOKEN" ]; then
        # Remove existing N8N_LARAVEL_API_TOKEN line if present
        sed -i '/^N8N_LARAVEL_API_TOKEN=/d' .env
        # Append new token
        echo "N8N_LARAVEL_API_TOKEN=$NEW_TOKEN" >> .env
        echo "✅ New token generated and saved to .env"
    else
        echo "⚠️  Could not generate token (no users in database). Run 'php artisan db:seed --force' first."
    fi
else
    echo "✅ N8N_LARAVEL_API_TOKEN already configured"
fi

echo ""
echo "✅ Deployment complete! Services are running."
echo ""
echo "View logs: docker-compose logs -f"


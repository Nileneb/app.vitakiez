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
echo "✅ Deployment complete! Services are running."
echo ""
echo "View logs: docker-compose logs -f"


#!/bin/bash

echo "🚀 Setting up Job Backoffice Application..."
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker Desktop first."
    echo "   Download from: https://www.docker.com/products/docker-desktop"
    exit 1
fi

# Check if Docker is running
if ! docker info &> /dev/null; then
    echo "❌ Docker is not running. Please start Docker Desktop first."
    exit 1
fi

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
else
    echo "✓ .env file already exists"
fi

# Stop and remove existing containers (if any)
echo "🧹 Cleaning up existing containers..."
docker-compose down -v 2>/dev/null

# Build and start containers
echo "🐳 Building and starting Docker containers..."
echo "   This may take 5-10 minutes on first run..."
docker-compose up -d --build

# Wait for services to be ready
echo ""
echo "⏳ Waiting for services to initialize..."
echo "   Database is starting up..."
sleep 15

echo "⏳ Waiting for migrations and seeding to complete..."
echo "   This may take a few minutes..."
sleep 30

# Check if containers are running
echo ""
echo "📊 Checking container status..."
docker-compose ps

echo ""
echo "✅ Setup complete!"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📱 Your Job Backoffice is running at:"
echo "   🌐 Application: http://localhost:8000"
echo "   🗄️  phpMyAdmin: http://localhost:8081"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "💡 Useful Commands:"
echo "   📋 View logs: docker-compose logs -f backoffice"
echo "   🔄 Restart: docker-compose restart"
echo "   🛑 Stop: docker-compose down"
echo "   🗑️  Stop & remove data: docker-compose down -v"
echo ""
echo "⚠️  Note: Keep this terminal open or the containers running"
echo "   for the job-app to connect to the database."
echo ""
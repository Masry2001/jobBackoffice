# Job Board Application

A complete job board system with two applications:
- **Job Backoffice**: Admin panel for Company Owners and Admin
- **Job App**: Job seeker interface with AI-powered resume parsing

## 🏗️ Architecture

This project consists of three repositories:

1. **job-backoffice** (this repo): Admin panel, database management (Migrations, Seeders, etc...)
2. **job-app**: Job seeker application
3. **job-shared**: Shared models used by both applications
4. **job-board-design**: pdf and jbg Files (ERD, C4 Diagram, etc...)

Both applications connect to the same database, which is managed by job-backoffice.

## 🛠️ Technology Stack

- **Backend**: PHP 8.2, Laravel 12
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MariaDB
- **PDF Processing**: Spatie PDF-to-Text (with poppler-utils)
- **AI Integration**: Google Gemini API
- **Storage**: Supabase
- **Containerization**: Docker

## 📋 Prerequisites

Before you begin, ensure you have installed:

- **Docker Desktop** (includes Docker and Docker Compose)
  - [Download for Windows](https://www.docker.com/products/docker-desktop)
  - [Download for Mac](https://www.docker.com/products/docker-desktop)
  - [Download for Linux](https://docs.docker.com/desktop/install/linux-install/)
- **Git**
  - [Download Git](https://git-scm.com/downloads)

**That's it!** Docker will handle everything else (PHP, Composer, Node.js, MySQL, etc.)

## 🚀 Quick Start Guide

### Step 1: Setup Job Backoffice (Database & Admin)

```bash
# Clone the repository
git clone https://github.com/Masry2001/jobBackoffice.git
#using github CLI: gh repo clone Masry2001/jobBackoffice
cd job-backoffice

# Run setup script
# On Windows:
setup.bat

# On Mac/Linux:
chmod +x setup.sh
./setup.sh
```

**Wait 5-10 minutes** for the setup to complete. The script will:
- Create and configure the database
- Run migrations
- Seed admin user and sample data
- Start the backoffice application

**Access the backoffice at**: http://localhost:8000

### Step 2: Setup Job App (Job Seeker Interface)

In a **new terminal window**:

```bash
# Clone the repository
git clone https://github.com/Masry2001/jobApp.git
#using github CLI: gh repo clone Masry2001/jobApp
cd job-app

# Run setup script
# On Windows:
setup.bat

# On Mac/Linux:
chmod +x setup.sh
./setup.sh
```

**Wait 5-10 minutes** for the setup to complete.

**Access the job app at**: http://localhost:8001

## 🔑 Default Admin Credentials

After seeding, use these credentials to login to the backoffice:

- **URL**: http://localhost:8000
- **Email**: admin@gmail.com
- **Password**: admin1234

## 🌐 Application URLs

| Service | URL | Description |
|---------|-----|-------------|
| Job Backoffice | http://localhost:8000 | Admin panel |
| Job App | http://localhost:8001 | Job seeker interface |
| phpMyAdmin | http://localhost:8081 | Database management |

## 🔧 Configuration

### Environment Variables

Both applications come with pre-configured `.env.example` files. The setup scripts automatically create `.env` files with the correct settings.

**Important variables already configured:**

- **Database**: Shared MariaDB database
- **Gemini API**: This is not Pre-configured You have to creaet.
   steps to create Gemini API Key
   1- go to https://aistudio.google.com/api-keys
   2- click on Create API Key
   3- Name Your Key and create a project for it
   4- take the key and put it in .env file, put it as a value for this key GEMINI_API_KEY
- **Supabase**: Pre-configured for resume storage

### Custom Configuration

If you want to use your own API keys:

1. Edit `.env` in the respective application folder
2. Update the following variables:
   - `GEMINI_API_KEY` - Your Gemini API key
   - `SUPABASE_*` - Your Supabase credentials
3. Restart the container: `docker-compose restart`

## Project Structure

```
job-backoffice/          # This repository
├── docker-compose.yml   # Database + Backoffice
├── Dockerfile
├── setup.sh / setup.bat
└── (Laravel application files)

job-app/                 # Separate repository
├── docker-compose.yml   # Job App (connects to backoffice DB)
├── Dockerfile
├── setup.sh / setup.bat
└── (Laravel application files)

job-shared/              # Separate repository
└── (Shared models package)
```

## Docker Commands

### Job Backoffice

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f backoffice

# Restart
docker-compose restart

# Access container shell
docker-compose exec backoffice bash

# Run migrations
docker-compose exec backoffice php artisan migrate

# Seed database
docker-compose exec backoffice php artisan db:seed
```

### Job App

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f app

# Restart
docker-compose restart

# Access container shell
docker-compose exec app bash

# Test PDF extraction
docker-compose exec app pdftotext -v
```

## Development Workflow

### Making Changes

1. **Backend changes**: Edit files directly - Docker volumes sync automatically
2. **Frontend changes**: Vite hot-reload is enabled
3. **Database changes**: Create migration → Restart backoffice container

### Updating Shared Models

When `job-shared` package is updated:

```bash
# In job-backoffice
docker-compose exec backoffice composer update job/shared

# In job-app
docker-compose exec app composer update job/shared
```

### Adding Dependencies

**PHP packages:**
```bash
docker-compose exec backoffice composer require package-name
docker-compose exec app composer require package-name
```

**NPM packages:**
```bash
docker-compose exec backoffice npm install package-name
docker-compose exec app npm install package-name
```

## 🛠️ Troubleshooting

### Port Already in Use

If you get port conflict errors:

**Option 1**: Stop the conflicting service
**Option 2**: Change ports in `docker-compose.yml`

```yaml
ports:
  - '8002:8000'  # Change 8000 to 8002
```

### Database Connection Error

**Issue**: "Could not connect to database"

**Solution**:
1. Ensure job-backoffice is running: `docker ps`
2. Wait 30 seconds for database initialization
3. Check logs: `docker-compose logs db`
4. Restart: `docker-compose restart`

### Job App Cannot Connect to Database

**Issue**: Job app can't find the database

**Solution**:
1. **Ensure job-backoffice is running first**
2. Check network: `docker network inspect jobboard-network`
3. On **Windows/Mac**: `host.docker.internal` should work automatically
4. On **Linux**: You may need to use the host's IP address in job-app's `.env`:
   ```bash
   DB_HOST=172.17.0.1  # Or your host machine's IP
   ```

### Permission Errors (Linux/Mac)

```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:$USER storage bootstrap/cache
```

### PDF Extraction Not Working

**Verify poppler-utils installation:**
```bash
docker-compose exec app pdftotext -v
```

If missing, rebuild:
```bash
docker-compose down
docker-compose up -d --build
```

### Clear Everything and Start Fresh

```bash
# Stop and remove all containers, networks, and volumes
docker-compose down -v

# Remove Docker images
docker rmi job-backoffice job-app

# Run setup again
./setup.sh  # or setup.bat on Windows
```

## 🔐 Security Notes

### API Keys in Repository

**⚠️ Important**: This setup includes pre-configured API keys for easy testing. For production:

1. **Generate your own keys**:
   - Gemini API: https://makersuite.google.com/app/apikey
   - Supabase: https://supabase.com

2. **Never commit real API keys** to public repositories

3. **Use environment-specific configurations**

### Supabase Bucket Setup

If creating your own Supabase project:

1. Create a bucket named `ShaghalniResumes`
2. Make it public
3. Add RLS policies:
   ```sql
   -- Allow public insert
   CREATE POLICY "Public Insert" ON storage.objects
   FOR INSERT WITH CHECK (bucket_id = 'ShaghalniResumes');
   
   -- Allow public select
   CREATE POLICY "Public Select" ON storage.objects
   FOR SELECT USING (bucket_id = 'ShaghalniResumes');
   ```

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [Spatie PDF to Text](https://github.com/spatie/pdf-to-text)
- [Google Gemini API](https://ai.google.dev)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

MIT Licence

## 💬 Support

If you encounter issues:

1. Check the troubleshooting section above
2. View container logs: `docker-compose logs -f`
3. Ensure Docker Desktop is running
4. Verify all prerequisites are met
5. Open an issue on GitHub

## 🎯 Features

### Job Backoffice
- Admin dashboard
- Company management
- Job posting management
- User management
- Database migrations and seeding

### Job App
- Job search and browsing
- Resume upload with AI parsing (Gemini)
- PDF text extraction (Spatie/poppler-utils)
- Resume storage (Supabase)
- Application tracking

---

**Happy Coding!**
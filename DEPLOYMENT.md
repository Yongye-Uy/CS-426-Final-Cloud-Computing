# Deployment Guide - Donation Tracker

This guide explains how to deploy the Donation Tracker application to DigitalOcean as 3 separate services that communicate via API.

## Architecture Overview

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│    FRONTEND     │     │     BACKEND     │     │       API       │
│  (Public Site)  │     │  (Admin Panel)  │     │  (JSON Server)  │
│ APP_MODE=       │     │ APP_MODE=       │     │ APP_MODE=       │
│ frontend        │     │ backend         │     │ api             │
│                 │     │                 │     │                 │
│ www.domain.com  │     │ admin.domain.com│     │ api.domain.com  │
└────────┬────────┘     └────────┬────────┘     └────────┬────────┘
         │                       │                       │
         └───────────────────────┼───────────────────────┘
                                 │
                    ┌────────────┴────────────┐
                    │      PostgreSQL         │
                    │   (Master + Replica)    │
                    └────────────┬────────────┘
                                 │
                    ┌────────────┴────────────┐
                    │   DigitalOcean Spaces   │
                    │    (File Storage)       │
                    └─────────────────────────┘
```

## Prerequisites

- DigitalOcean account
- Domain name with DNS access
- SSH key pair
- Git repository with your code

---

## Step 1: Create DigitalOcean Resources

### 1.1 Create Managed PostgreSQL Database

1. Go to **DigitalOcean Dashboard > Databases > Create Database**
2. Choose **PostgreSQL** (latest version)
3. Select your datacenter region (e.g., Singapore - SGP1)
4. Choose plan:
   - **Basic**: $15/month (for development)
   - **General Purpose**: $60/month+ (for production)
5. **Enable Standby Node** for high availability
6. Click **Create Database Cluster**

After creation:
1. Go to **Settings > Add Read-Only Node** to create a read replica
2. Note down these values:
   - **Primary Host**: `your-db-xxxxx.db.ondigitalocean.com`
   - **Read Replica Host**: `your-db-xxxxx-s1.db.ondigitalocean.com`
   - **Port**: `25060`
   - **Database**: `defaultdb` (or create new one)
   - **Username**: `doadmin`
   - **Password**: (shown once, save it!)

### 1.2 Create DigitalOcean Spaces (S3 Storage)

1. Go to **Spaces > Create a Space**
2. Choose datacenter region
3. Enable **CDN** (recommended)
4. Name your bucket (e.g., `donation-tracker-files`)
5. Click **Create Space**

Generate API Keys:
1. Go to **API > Spaces Keys**
2. Click **Generate New Key**
3. Note down:
   - **Access Key**: `DO_SPACES_KEY`
   - **Secret Key**: `DO_SPACES_SECRET`

### 1.3 Create 3 Droplets

Create 3 Ubuntu droplets for each service:

1. Go to **Droplets > Create Droplet**
2. Choose **Ubuntu 22.04 LTS**
3. Select plan:
   - **Basic**: $6/month (minimum)
   - **Regular**: $12/month (recommended)
4. Choose same datacenter as database
5. Add your SSH key
6. Create droplets named:
   - `api-server`
   - `frontend-server`
   - `backend-server`

---

## Step 2: Server Setup

SSH into each server and run these commands:

### 2.1 Initial Setup

```bash
# Update system
apt update && apt upgrade -y

# Install required packages
apt install -y nginx php8.3-fpm php8.3-cli php8.3-common \
    php8.3-pgsql php8.3-zip php8.3-gd php8.3-mbstring \
    php8.3-curl php8.3-xml php8.3-bcmath php8.3-redis \
    composer nodejs npm git unzip

# Configure firewall
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw enable
```

### 2.2 Clone and Setup Application

```bash
# Create web directory
mkdir -p /var/www
cd /var/www

# Clone your repository
git clone https://github.com/your-username/donation-tracking.git app
cd app

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Set permissions
chown -R www-data:www-data /var/www/app
chmod -R 755 /var/www/app/storage
chmod -R 755 /var/www/app/bootstrap/cache
```

### 2.3 Configure Environment

```bash
cp .env.example .env
nano .env
```

#### For API Server (.env):
```env
APP_NAME="Donation Tracker API"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.yourdomain.com
APP_MODE=api

DB_CONNECTION=pgsql
DB_HOST=your-primary-host.db.ondigitalocean.com
DB_PORT=25060
DB_DATABASE=donation_tracker
DB_USERNAME=doadmin
DB_PASSWORD=your-password
DB_READ_HOST=your-replica-host.db.ondigitalocean.com
DB_SSLMODE=require

DO_SPACES_KEY=your-key
DO_SPACES_SECRET=your-secret
DO_SPACES_BUCKET=your-bucket
DO_SPACES_REGION=sgp1
DO_SPACES_ENDPOINT=https://sgp1.digitaloceanspaces.com
DO_SPACES_URL=https://your-bucket.sgp1.cdn.digitaloceanspaces.com
FILESYSTEM_DISK=spaces

MAIL_MAILER=brevo
BREVO_API_KEY=your-brevo-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

#### For Frontend Server (.env):
```env
APP_NAME="Donation Tracker"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.yourdomain.com
APP_MODE=frontend

API_BASE_URL=https://api.yourdomain.com/api/v1

# Same DB config as API server
DB_CONNECTION=pgsql
DB_HOST=your-primary-host.db.ondigitalocean.com
...
```

#### For Backend Server (.env):
```env
APP_NAME="Donation Tracker Admin"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://admin.yourdomain.com
APP_MODE=backend

API_BASE_URL=https://api.yourdomain.com/api/v1

# Same DB config as API server
DB_CONNECTION=pgsql
DB_HOST=your-primary-host.db.ondigitalocean.com
...
```

### 2.4 Generate Key and Migrate

```bash
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 3: Configure Nginx

### 3.1 Create Nginx Configuration

```bash
nano /etc/nginx/sites-available/app
```

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 3.2 Enable Site

```bash
ln -s /etc/nginx/sites-available/app /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx
```

---

## Step 4: SSL with Let's Encrypt

```bash
apt install certbot python3-certbot-nginx
certbot --nginx -d your-domain.com
```

---

## Step 5: Configure DNS

Add A records in your domain DNS:

| Type | Name | Value |
|------|------|-------|
| A | api | API server IP |
| A | www | Frontend server IP |
| A | admin | Backend server IP |

---

## Step 6: Queue Worker (Optional)

For background jobs, create a systemd service:

```bash
nano /etc/systemd/system/laravel-worker.service
```

```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/app/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

```bash
systemctl enable laravel-worker
systemctl start laravel-worker
```

---

## Deployment Updates

When you need to deploy updates:

```bash
cd /var/www/app

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue worker
systemctl restart laravel-worker
```

---

## Environment Variables Reference

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_MODE` | Application mode | `api`, `frontend`, `backend`, `full` |
| `API_BASE_URL` | API server URL | `https://api.domain.com/api/v1` |
| `DB_HOST` | Primary database host | `xxx.db.ondigitalocean.com` |
| `DB_READ_HOST` | Read replica host | `xxx-s1.db.ondigitalocean.com` |
| `DB_SSLMODE` | SSL mode for PostgreSQL | `require` |
| `DO_SPACES_KEY` | Spaces access key | Your key |
| `DO_SPACES_SECRET` | Spaces secret key | Your secret |
| `DO_SPACES_BUCKET` | Bucket name | `donation-files` |
| `DO_SPACES_REGION` | Spaces region | `sgp1` |
| `DO_SPACES_ENDPOINT` | Spaces endpoint | `https://sgp1.digitaloceanspaces.com` |
| `BREVO_API_KEY` | Brevo email API key | Your API key |

---

## Troubleshooting

### Check Laravel Logs
```bash
tail -f /var/www/app/storage/logs/laravel.log
```

### Check Nginx Logs
```bash
tail -f /var/log/nginx/error.log
```

### Test Database Connection
```bash
cd /var/www/app
php artisan tinker
>>> DB::connection()->getPdo();
```

### Test API Endpoints
```bash
curl https://api.yourdomain.com/api/v1/campaigns
```

### Clear All Caches
```bash
php artisan optimize:clear
```

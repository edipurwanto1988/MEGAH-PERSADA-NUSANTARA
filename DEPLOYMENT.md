# Laravel Application Deployment Guide

This guide will help you deploy the Laravel application to a hosting environment.

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- Web server (Apache or Nginx)
- MySQL or MariaDB database

## Deployment Steps

### 1. Upload Files

Upload all project files to your hosting server's public directory (or as required by your hosting provider).

### 2. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Environment Configuration

1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Update the `.env` file with your database and other configuration details.

3. Generate an application key:
   ```bash
   php artisan key:generate
   ```

### 4. Create Storage Link (IMPORTANT)

This is a critical step that ensures uploaded files are accessible:

```bash
php artisan storage:link
```

If this command doesn't work on your hosting, you can manually create the symbolic link:

```bash
ln -s /path/to/your/project/storage/app/public /path/to/your/project/public/storage
```

### 5. Run Database Migrations

```bash
php artisan migrate --force
```

### 6. Cache Configuration

For better performance in production:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Set File Permissions

Ensure the following directories have proper permissions:

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## Troubleshooting

### Images Not Showing (404 Errors)

If images are not showing after upload, it's likely because the storage link is missing or broken:

1. Check if the symbolic link exists:
   ```bash
   ls -la public/storage
   ```
   If it shows `public/storage -> ../storage/app/public`, the link is correct.

2. If the link doesn't exist, create it:kk
   ```bash
   php artisan storage:link
   ```

3. If the link exists but images still don't show, check the file permissions:
   ```bashkkk
   chmod -R 755 storage
   ```

### Alternative Approach for Storage

If you cannot create symbolic links on your hosting, you can modify the filesystems configuration:

1. Open `config/filesystems.php`
2. Find the `public` disk configuration
3. Change the `root` from `storage/app/public` to `public/uploads`
4. Update your controllers to save files directly to `public/uploads`

Then modify the image paths in your views to use the new path.

## Using the Deployment Script

You can use the included `deploy.sh` script to automate the deployment process:

1. Make the script executable:
   ```bash
   chmod +x deploy.sh
   ```

2. Run the script:
   ```bash
   ./deploy.sh
   ```

## Shared Hosting Considerations

If you're on shared hosting with limited access:

1. Check if your hosting provider offers a "Laravel deployment" option
2. Ensure the `storage` directory is writable
3. Some hosts may require you to place Laravel files in a subdirectory
4. Contact your hosting support if you're unable to create symbolic links

## Final Notes

- Always backup your database before running migrations in production
- Test all functionality after deployment
- Monitor error logs for any issues
- Ensure your hosting environment meets Laravel's requirements
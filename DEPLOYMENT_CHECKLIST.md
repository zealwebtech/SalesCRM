# SalesCRM - Deployment Checklist

## Pre-Deployment

- [ ] Verify LAMP stack is installed
- [ ] Apache `mod_rewrite` is enabled
- [ ] PHP version is 7.4 or higher
- [ ] MySQL version is 5.7 or higher
- [ ] All required PHP extensions installed (mysqli, json, mbstring)

## Download and Extract

- [ ] Download SalesCRM package
- [ ] Extract to `/var/www/html/salescrm`
- [ ] Verify all files are present
- [ ] Check directory structure is intact

## File Permissions

- [ ] Set directory ownership: `sudo chown -R www-data:www-data /var/www/html/salescrm`
- [ ] Set directory permissions: `sudo chmod -R 755 /var/www/html/salescrm`
- [ ] Set upload directory permissions: `sudo chmod -R 775 /var/www/html/salescrm/uploads`
- [ ] Verify config directory is readable

## Database Setup

- [ ] Create MySQL database: `salescrm_db`
- [ ] Create MySQL user: `salescrm_user` with password `salescrm_password123`
- [ ] Grant privileges to user
- [ ] Import schema: `database/schema.sql`
- [ ] Import dummy data: `database/dump.sql`
- [ ] Verify all tables are created (10 tables total)
- [ ] Verify dummy data is imported

## Apache Configuration

- [ ] Verify `.htaccess` is in place
- [ ] Enable mod_rewrite
- [ ] Enable mod_headers
- [ ] Restart Apache service
- [ ] Test mod_rewrite is working

## Application Configuration

- [ ] Check `config/database.php` has correct credentials
- [ ] Update `BASE_URL` if not using `/salescrm/`
- [ ] Verify file paths are correct
- [ ] Check upload directory is writable

## Verification

- [ ] Visit `http://localhost/salescrm/setup.php`
- [ ] Verify database connection is successful
- [ ] Verify all tables are created
- [ ] Access main application at `http://localhost/salescrm/`
- [ ] Login with admin credentials (admin@salescrm.com / admin@123)
- [ ] Test all menu items load
- [ ] Test API endpoints

## Post-Deployment

- [ ] Change default admin password
- [ ] Change default database user password
- [ ] Review security settings
- [ ] Enable HTTPS/SSL
- [ ] Configure regular backups
- [ ] Review PHP security settings
- [ ] Set up error logging
- [ ] Test file upload functionality
- [ ] Verify all modules are working
- [ ] Test database interconnectivity

## Security

- [ ] Disable PHP execution in upload directory
- [ ] Set proper file permissions
- [ ] Keep PHP updated
- [ ] Keep MySQL updated
- [ ] Set up firewall rules
- [ ] Enable access logs
- [ ] Review Apache error logs

## Backup

- [ ] Create database backup
- [ ] Create files backup
- [ ] Document backup procedure
- [ ] Test backup restoration

## Documentation

- [ ] Review README.md
- [ ] Document any custom configurations
- [ ] Document user credentials (store securely)
- [ ] Document backup locations
- [ ] Document admin contact information

## Support

- [ ] Note support contact information
- [ ] Document common issues and solutions
- [ ] Keep version documentation

---

## Quick Setup Commands

```bash
# Navigate to Apache document root
cd /var/www/html

# Extract SalesCRM
unzip SalesCRM.zip
mv SalesCRM salescrm

# Set permissions
sudo chown -R www-data:www-data /var/www/html/salescrm
sudo chmod -R 755 /var/www/html/salescrm
sudo chmod -R 775 /var/www/html/salescrm/uploads

# Enable mod_rewrite
sudo a2enmod rewrite
sudo a2enmod headers
sudo systemctl restart apache2

# Create database and user
mysql -u root -p <<EOF
CREATE DATABASE salescrm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'salescrm_user'@'localhost' IDENTIFIED BY 'salescrm_password123';
GRANT ALL PRIVILEGES ON salescrm_db.* TO 'salescrm_user'@'localhost';
FLUSH PRIVILEGES;
EOF

# Import database
mysql -u salescrm_user -p salescrm_db < /var/www/html/salescrm/database/schema.sql
mysql -u salescrm_user -p salescrm_db < /var/www/html/salescrm/database/dump.sql

# Access setup page
# Visit: http://localhost/salescrm/setup.php
# Then visit: http://localhost/salescrm/
```

---

Last Updated: December 6, 2025

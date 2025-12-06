# SalesCRM - LAMP Stack Installation Guide

## System Requirements

- **Operating System**: Linux (Ubuntu 20.04+ recommended)
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher / MariaDB 10.3 or higher
- **Apache**: 2.4 or higher
- **Other**: Apache mod_rewrite enabled

---

## Installation Steps

### Step 1: Install LAMP Stack (if not already installed)

#### Ubuntu/Debian:
```bash
# Update system packages
sudo apt-get update
sudo apt-get upgrade

# Install Apache
sudo apt-get install apache2

# Install PHP and required extensions
sudo apt-get install php libapache2-mod-php php-mysql php-mbstring php-json php-curl

# Install MySQL
sudo apt-get install mysql-server

# Enable mod_rewrite
sudo a2enmod rewrite
sudo a2enmod headers
sudo systemctl restart apache2
```

### Step 2: Download and Setup SalesCRM

```bash
# Navigate to Apache document root
cd /var/www/html

# Clone or extract SalesCRM
# If using git:
git clone https://github.com/zealwebtech/SalesCRM.git salescrm

# Or if using downloaded package:
unzip SalesCRM.zip
mv SalesCRM salescrm

# Set proper permissions
sudo chown -R www-data:www-data /var/www/html/salescrm
sudo chmod -R 755 /var/www/html/salescrm
sudo chmod -R 775 /var/www/html/salescrm/uploads
```

### Step 3: Database Setup

#### Method 1: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create database and user
CREATE DATABASE salescrm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'salescrm_user'@'localhost' IDENTIFIED BY 'salescrm_password123';
GRANT ALL PRIVILEGES ON salescrm_db.* TO 'salescrm_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Import schema
mysql -u salescrm_user -p salescrm_db < /var/www/html/salescrm/database/schema.sql

# Import dummy data
mysql -u salescrm_user -p salescrm_db < /var/www/html/salescrm/database/dump.sql
```

#### Method 2: Using phpMyAdmin (if available)

1. Login to phpMyAdmin
2. Create new database: `salescrm_db`
3. Select database and click "Import"
4. Upload `database/schema.sql`
5. Repeat for `database/dump.sql`

### Step 4: Apache Virtual Host Configuration (Optional but Recommended)

Create `/etc/apache2/sites-available/salescrm.conf`:

```apache
<VirtualHost *:80>
    ServerName salescrm.local
    ServerAlias www.salescrm.local
    ServerAdmin admin@salescrm.local
    
    DocumentRoot /var/www/html/salescrm
    
    <Directory /var/www/html/salescrm>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Log files
    ErrorLog ${APACHE_LOG_DIR}/salescrm_error.log
    CustomLog ${APACHE_LOG_DIR}/salescrm_access.log combined
    
    # Enable compression
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
    </IfModule>
</VirtualHost>
```

Enable the site:
```bash
sudo a2ensite salescrm.conf
sudo a2dissite 000-default.conf
sudo apache2ctl configtest
sudo systemctl restart apache2
```

Add to `/etc/hosts`:
```
127.0.0.1   salescrm.local
```

### Step 5: Configure Application

Edit `/var/www/html/salescrm/config/database.php` if needed:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'salescrm_user');
define('DB_PASS', 'salescrm_password123');
define('DB_NAME', 'salescrm_db');
define('DB_PORT', 3306);
```

### Step 6: Access the Application

- **URL**: http://localhost/salescrm/ (or http://salescrm.local if configured)
- **Default Admin**: 
  - Email: admin@salescrm.com
  - Password: admin@123

---

## Directory Structure

```
salescrm/
├── api/                    # PHP API endpoints
│   ├── index.php          # Main API router
│   └── endpoints/         # Individual endpoint handlers
│       ├── users.php
│       ├── products.php
│       ├── invoices.php
│       ├── purchases.php
│       ├── expenses.php
│       ├── accounting.php
│       ├── employees.php
│       └── quotations.php
├── config/                 # Configuration files
│   └── database.php       # Database connection
├── database/              # Database files
│   ├── schema.sql        # Database schema
│   └── dump.sql          # Dummy data
├── css/                   # Stylesheets
│   └── styles.css
├── js/                    # JavaScript files
│   └── app.js
├── uploads/               # User uploaded files
├── public/                # Public assets
├── index.html             # Main application
├── .htaccess             # Apache configuration
└── README.md             # This file
```

---

## Database Tables Overview

1. **users** - User accounts and roles
2. **products** - Product catalog
3. **inventory** - Stock management
4. **customers** - Customer information
5. **invoices** - Invoice records
6. **purchase_orders** - Purchase orders
7. **expenses** - Expense tracking
8. **accounting_transactions** - Financial transactions
9. **employees** - Employee records (HRM)
10. **quotations** - Sales quotations

---

## API Endpoints

### Users
- `GET /api/v1/users` - Get all users
- `GET /api/v1/users/{id}` - Get specific user
- `POST /api/v1/users` - Create user
- `PUT /api/v1/users/{id}` - Update user
- `DELETE /api/v1/users/{id}` - Delete user

### Products
- `GET /api/v1/products` - Get all products
- `POST /api/v1/products` - Create product

### Invoices
- `GET /api/v1/invoices` - Get all invoices
- `POST /api/v1/invoices` - Create invoice

Similar endpoints available for other modules.

---

## Troubleshooting

### Issue: 404 errors on API calls
**Solution**: 
- Ensure `mod_rewrite` is enabled: `sudo a2enmod rewrite`
- Check `.htaccess` file permissions
- Restart Apache: `sudo systemctl restart apache2`

### Issue: Database connection error
**Solution**:
- Verify MySQL is running: `sudo systemctl status mysql`
- Check credentials in `config/database.php`
- Ensure database user has proper privileges

### Issue: Permission denied errors
**Solution**:
```bash
sudo chown -R www-data:www-data /var/www/html/salescrm
sudo chmod -R 755 /var/www/html/salescrm
sudo chmod -R 775 /var/www/html/salescrm/uploads
```

### Issue: Cannot upload files
**Solution**:
```bash
sudo chmod -R 775 /var/www/html/salescrm/uploads
sudo chown -R www-data:www-data /var/www/html/salescrm/uploads
```

---

## Security Recommendations

1. **Change default passwords** in database
2. **Enable HTTPS** (Let's Encrypt recommended)
3. **Configure PHP Security Settings** in `php.ini`:
   ```
   display_errors = Off
   error_reporting = E_ALL
   session.secure = On
   session.http_only = On
   ```
4. **Regular Backups**:
   ```bash
   mysqldump -u salescrm_user -p salescrm_db > backup_$(date +%Y%m%d).sql
   ```
5. **Implement Authentication** for API endpoints
6. **Use prepared statements** (already implemented)

---

## Features

✅ Dashboard with analytics
✅ Invoice Management
✅ Inventory Tracking
✅ Product Management
✅ Purchase Orders
✅ Expense Management
✅ Accounting & Finance
✅ Human Resource Management (HRM)
✅ Quotation Management
✅ Cross-module interconnectivity
✅ RESTful API
✅ Responsive design

---

## Support

For issues or questions:
- Email: support@salescrm.com
- GitHub: https://github.com/zealwebtech/SalesCRM

---

## License

This project is provided as-is for deployment on LAMP servers.

Last Updated: December 6, 2025
SalesCRM

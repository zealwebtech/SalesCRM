# SalesCRM - LAMP Stack Installation Guides

## Table of Contents
1. [Ubuntu/Debian Installation](#ubuntudebian-installation)
2. [CentOS/RHEL Installation](#centosrhel-installation)
3. [Using Docker](#using-docker)
4. [Windows with XAMPP](#windows-with-xampp)
5. [Shared Hosting Setup](#shared-hosting-setup)

---

## Ubuntu/Debian Installation

### Complete Setup in One Command

```bash
#!/bin/bash

# Update system
sudo apt-get update && sudo apt-get upgrade -y

# Install LAMP
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql php-mbstring php-json php-curl mysql-server

# Enable required modules
sudo a2enmod rewrite
sudo a2enmod headers
sudo systemctl restart apache2

# Create application directory
cd /var/www/html
sudo unzip SalesCRM.zip
sudo mv SalesCRM salescrm

# Set permissions
sudo chown -R www-data:www-data /var/www/html/salescrm
sudo chmod -R 755 /var/www/html/salescrm
sudo chmod -R 775 /var/www/html/salescrm/uploads

# MySQL setup
sudo mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS salescrm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'salescrm_user'@'localhost' IDENTIFIED BY 'salescrm_password123';
GRANT ALL PRIVILEGES ON salescrm_db.* TO 'salescrm_user'@'localhost';
FLUSH PRIVILEGES;
EOF

# Import database
mysql -u salescrm_user -psalescrm_password123 salescrm_db < /var/www/html/salescrm/database/schema.sql
mysql -u salescrm_user -psalescrm_password123 salescrm_db < /var/www/html/salescrm/database/dump.sql

echo "Installation complete! Visit http://localhost/salescrm/"
```

---

## CentOS/RHEL Installation

### Step-by-step Installation

```bash
# Enable REMI repository
sudo yum install -y https://repo.webtatic.com/yum/el7/latest.rpm

# Install LAMP
sudo yum install -y httpd php php-mysql php-mbstring php-json php-curl mariadb-server

# Enable and start services
sudo systemctl enable httpd mariadb
sudo systemctl start httpd mariadb

# Configure firewall
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload

# Enable mod_rewrite
echo "LoadModule rewrite_module modules/mod_rewrite.so" | sudo tee -a /etc/httpd/conf/httpd.conf

# Create application directory
cd /var/www/html
sudo unzip SalesCRM.zip
sudo mv SalesCRM salescrm

# Set permissions
sudo chown -R apache:apache /var/www/html/salescrm
sudo chmod -R 755 /var/www/html/salescrm
sudo chmod -R 775 /var/www/html/salescrm/uploads

# MySQL setup
sudo mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS salescrm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'salescrm_user'@'localhost' IDENTIFIED BY 'salescrm_password123';
GRANT ALL PRIVILEGES ON salescrm_db.* TO 'salescrm_user'@'localhost';
FLUSH PRIVILEGES;
EOF

# Import database
mysql -u salescrm_user -psalescrm_password123 salescrm_db < /var/www/html/salescrm/database/schema.sql
mysql -u salescrm_user -psalescrm_password123 salescrm_db < /var/www/html/salescrm/database/dump.sql

# Restart Apache
sudo systemctl restart httpd

echo "Installation complete! Visit http://localhost/salescrm/"
```

---

## Using Docker

### Docker Compose Setup

Create `docker-compose.yml`:

```yaml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    container_name: salescrm_mysql
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: salescrm_db
      MYSQL_USER: salescrm_user
      MYSQL_PASSWORD: salescrm_password123
    volumes:
      - mysql_data:/var/lib/mysql
      - ./database/schema.sql:/docker-entrypoint-initdb.d/01-schema.sql
      - ./database/dump.sql:/docker-entrypoint-initdb.d/02-dump.sql
    ports:
      - "3306:3306"
    networks:
      - salescrm_network

  apache_php:
    image: php:8.0-apache
    container_name: salescrm_apache
    environment:
      DOCUMENT_ROOT: /var/www/html
    volumes:
      - .:/var/www/html
      - ./apache/salescrm.conf:/etc/apache2/sites-available/000-default.conf
    ports:
      - "80:80"
    depends_on:
      - mysql
    networks:
      - salescrm_network
    command: >
      bash -c "
        docker-php-ext-install mysqli &&
        a2enmod rewrite &&
        apache2-foreground
      "

volumes:
  mysql_data:

networks:
  salescrm_network:
    driver: bridge
```

### Run with Docker

```bash
# Build and start containers
docker-compose up -d

# Check status
docker-compose ps

# View logs
docker-compose logs -f

# Access application
# http://localhost/salescrm/

# Stop containers
docker-compose down
```

---

## Windows with XAMPP

### Setup Steps

1. **Download XAMPP**
   - Visit https://www.apachefriends.org
   - Download latest version (PHP 7.4 or higher)

2. **Install XAMPP**
   - Run installer
   - Choose components (Apache, MySQL, PHP)
   - Install to default directory

3. **Extract SalesCRM**
   - Extract SalesCRM to `C:\xampp\htdocs\salescrm`

4. **Set Permissions**
   - Right-click on `salescrm` folder
   - Properties → Security → Edit
   - Grant full permissions to current user

5. **Start Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL

6. **Create Database**
   - Visit `http://localhost/phpmyadmin`
   - Create database: `salescrm_db`
   - Import `database/schema.sql`
   - Import `database/dump.sql`

7. **Access Application**
   - Visit `http://localhost/salescrm/`
   - Login: admin@salescrm.com / admin@123

---

## Shared Hosting Setup

### cPanel/WHM Setup

1. **Upload Files**
   - Extract SalesCRM
   - Upload via FTP to `public_html/salescrm`

2. **Create Database**
   - Login to cPanel
   - Navigate to MySQL Databases
   - Create database: `youruser_salescrm`
   - Create user: `youruser_crm` with password
   - Add user to database

3. **Import Database**
   - Go to phpMyAdmin
   - Select database
   - Import `database/schema.sql`
   - Import `database/dump.sql`

4. **Configure Application**
   - Edit `config/database.php`
   - Update with your database credentials

5. **Set Permissions**
   - Via FTP: Set `uploads` folder to 777

6. **Access Application**
   - Visit `http://yourdomain.com/salescrm/`

### Plesk Setup

1. Similar steps as cPanel
2. Use Plesk's database manager
3. Configure FTP credentials in Plesk

---

## Verification Checklist

After installation, verify:

```bash
# Check PHP version
php -v

# Check Apache modules
apache2ctl -M | grep rewrite

# Check MySQL connectivity
mysql -u salescrm_user -p -e "SELECT 'Connection successful';"

# Check file permissions
ls -la /var/www/html/salescrm/

# Check database tables
mysql -u salescrm_user -p -e "USE salescrm_db; SHOW TABLES;"

# Check Apache error log
tail -n 20 /var/log/apache2/error.log
```

---

## Common Issues and Solutions

### Issue: 404 error on API calls
**Solution**:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Issue: Permission denied
**Solution**:
```bash
sudo chown -R www-data:www-data /var/www/html/salescrm
sudo chmod -R 755 /var/www/html/salescrm
```

### Issue: Can't upload files
**Solution**:
```bash
sudo chmod -R 775 /var/www/html/salescrm/uploads
sudo chown -R www-data:www-data /var/www/html/salescrm/uploads
```

### Issue: Database connection failed
**Solution**: Check `config/database.php` credentials and verify MySQL is running

---

## Support and Documentation

- Refer to README.md for complete documentation
- Check DEPLOYMENT_CHECKLIST.md for verification
- Visit https://github.com/zealwebtech/SalesCRM for updates

Last Updated: December 6, 2025

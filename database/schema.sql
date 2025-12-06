-- SalesCRM Database Schema
-- MySQL Database Dump for LAMP Stack

-- Create Database
CREATE DATABASE IF NOT EXISTS `salescrm_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `salescrm_db`;

-- Users Table
CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'Sales Representative',
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products Table
CREATE TABLE `products` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` VARCHAR(50) UNIQUE NOT NULL,
  `product_name` VARCHAR(200) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `unit_price` DECIMAL(12, 2) NOT NULL,
  `stock_quantity` INT NOT NULL DEFAULT 0,
  `description` TEXT,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_product_id (product_id),
  INDEX idx_category (category),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inventory Table
CREATE TABLE `inventory` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `item_id` VARCHAR(50) UNIQUE NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 0,
  `unit_price` DECIMAL(12, 2) NOT NULL,
  `total_value` DECIMAL(14, 2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
  `warehouse_location` VARCHAR(100),
  `last_stock_check` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(20) DEFAULT 'In Stock',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id),
  INDEX idx_item_id (item_id),
  INDEX idx_product_id (product_id),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Customers Table (for Invoices & Quotations)
CREATE TABLE `customers` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `customer_name` VARCHAR(200) NOT NULL,
  `email` VARCHAR(100),
  `phone` VARCHAR(20),
  `address` TEXT,
  `city` VARCHAR(100),
  `state` VARCHAR(100),
  `postal_code` VARCHAR(20),
  `country` VARCHAR(100),
  `company` VARCHAR(200),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_company (company)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Invoices Table
CREATE TABLE `invoices` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `invoice_number` VARCHAR(50) UNIQUE NOT NULL,
  `customer_id` INT NOT NULL,
  `issue_date` DATE NOT NULL,
  `due_date` DATE NOT NULL,
  `total_amount` DECIMAL(14, 2) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Pending',
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id),
  INDEX idx_invoice_number (invoice_number),
  INDEX idx_status (status),
  INDEX idx_due_date (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Purchase Orders Table
CREATE TABLE `purchase_orders` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `po_number` VARCHAR(50) UNIQUE NOT NULL,
  `vendor_id` INT,
  `vendor_name` VARCHAR(200) NOT NULL,
  `order_date` DATE NOT NULL,
  `delivery_date` DATE,
  `total_amount` DECIMAL(14, 2) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Pending',
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_po_number (po_number),
  INDEX idx_status (status),
  INDEX idx_order_date (order_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Expenses Table
CREATE TABLE `expenses` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `expense_id` VARCHAR(50) UNIQUE NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `amount` DECIMAL(12, 2) NOT NULL,
  `expense_date` DATE NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Pending',
  `description` TEXT,
  `approved_by` INT,
  `created_by` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id),
  FOREIGN KEY (approved_by) REFERENCES users(id),
  INDEX idx_expense_id (expense_id),
  INDEX idx_category (category),
  INDEX idx_status (status),
  INDEX idx_expense_date (expense_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Accounting Transactions Table
CREATE TABLE `accounting_transactions` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `transaction_id` VARCHAR(50) UNIQUE NOT NULL,
  `transaction_type` VARCHAR(50) NOT NULL,
  `amount` DECIMAL(14, 2) NOT NULL,
  `reference_id` VARCHAR(50),
  `reference_type` VARCHAR(50),
  `transaction_date` DATE NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Pending',
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_transaction_id (transaction_id),
  INDEX idx_type (transaction_type),
  INDEX idx_status (status),
  INDEX idx_date (transaction_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employees Table (HRM)
CREATE TABLE `employees` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `employee_id` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `email` VARCHAR(100) UNIQUE,
  `phone` VARCHAR(20),
  `department` VARCHAR(100),
  `position` VARCHAR(100),
  `salary` DECIMAL(12, 2),
  `joining_date` DATE,
  `status` VARCHAR(20) DEFAULT 'Active',
  `manager_id` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (manager_id) REFERENCES employees(id),
  INDEX idx_employee_id (employee_id),
  INDEX idx_department (department),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Quotations Table
CREATE TABLE `quotations` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `quotation_number` VARCHAR(50) UNIQUE NOT NULL,
  `customer_id` INT NOT NULL,
  `quotation_date` DATE NOT NULL,
  `valid_till_date` DATE NOT NULL,
  `total_amount` DECIMAL(14, 2) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'Draft',
  `products_json` JSON,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id),
  INDEX idx_quotation_number (quotation_number),
  INDEX idx_status (status),
  INDEX idx_customer_id (customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Indexes for Performance
CREATE INDEX idx_users_created_at ON users(created_at);
CREATE INDEX idx_products_created_at ON products(created_at);
CREATE INDEX idx_invoices_created_at ON invoices(created_at);
CREATE INDEX idx_quotations_created_at ON quotations(created_at);

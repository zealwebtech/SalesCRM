-- SalesCRM Database Dump with Dummy Data
-- Import this file into MySQL to populate the database

USE `salescrm_db`;

-- Insert Users
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Admin User', 'admin@salescrm.com', MD5('admin@123'), 'Admin', 'Active'),
(2, 'John Doe', 'john.doe@example.com', MD5('password123'), 'Sales Manager', 'Active'),
(3, 'Jane Smith', 'jane.smith@example.com', MD5('password123'), 'Sales Executive', 'Active'),
(4, 'Mike Johnson', 'mike.johnson@example.com', MD5('password123'), 'Sales Representative', 'Active'),
(5, 'Sarah Williams', 'sarah.williams@example.com', MD5('password123'), 'Admin', 'Active');

-- Insert Products
INSERT INTO `products` (`product_id`, `product_name`, `category`, `unit_price`, `stock_quantity`, `description`, `status`) VALUES
('PRD-001', 'Enterprise Software', 'Software', 1200.00, 45, 'Advanced enterprise management software suite', 'Active'),
('PRD-002', 'Professional Services', 'Services', 500.00, 100, 'Consulting and implementation services', 'Active'),
('PRD-003', 'Hardware Package A', 'Electronics', 2500.00, 25, 'Complete hardware solution package', 'Active'),
('PRD-004', 'Cloud Storage License', 'Software', 299.00, 150, 'Annual cloud storage subscription', 'Active'),
('PRD-005', 'Technical Support Plan', 'Services', 450.00, 200, '24/7 Technical support subscription', 'Active');

-- Insert Customers
INSERT INTO `customers` (`customer_name`, `email`, `phone`, `address`, `city`, `state`, `postal_code`, `country`, `company`) VALUES
('Acme Corporation', 'contact@acme.com', '+1-555-0101', '123 Business Ave', 'New York', 'NY', '10001', 'USA', 'Acme Corporation'),
('Tech Solutions Inc', 'info@techsol.com', '+1-555-0102', '456 Tech Park', 'San Francisco', 'CA', '94102', 'USA', 'Tech Solutions Inc'),
('Global Enterprises', 'sales@globalent.com', '+1-555-0103', '789 Global St', 'Chicago', 'IL', '60601', 'USA', 'Global Enterprises'),
('Digital Ventures', 'hello@digitalven.com', '+1-555-0104', '321 Digital Blvd', 'Austin', 'TX', '78701', 'USA', 'Digital Ventures'),
('Innovation Labs', 'contact@innolabs.com', '+1-555-0105', '654 Innovation Dr', 'Seattle', 'WA', '98101', 'USA', 'Innovation Labs');

-- Insert Invoices
INSERT INTO `invoices` (`invoice_number`, `customer_id`, `issue_date`, `due_date`, `total_amount`, `status`, `description`) VALUES
('INV-001', 1, '2025-11-28', '2025-12-28', 5250.00, 'Pending', 'Enterprise Software License'),
('INV-002', 2, '2025-11-20', '2025-12-20', 8750.00, 'Paid', 'Professional Services'),
('INV-003', 3, '2025-11-15', '2025-12-15', 12500.00, 'Overdue', 'Hardware Package with Setup'),
('INV-004', 4, '2025-12-01', '2025-12-31', 3200.00, 'Draft', 'Cloud Storage License'),
('INV-005', 5, '2025-11-30', '2025-12-30', 4500.00, 'Pending', 'Technical Support Plan');

-- Insert Inventory
INSERT INTO `inventory` (`item_id`, `product_id`, `quantity`, `unit_price`, `warehouse_location`, `status`) VALUES
('ITM-001', 1, 250, 50.00, 'Warehouse A - Shelf 1', 'In Stock'),
('ITM-002', 2, 180, 75.00, 'Warehouse A - Shelf 2', 'In Stock'),
('ITM-003', 3, 95, 120.00, 'Warehouse B - Shelf 3', 'In Stock'),
('ITM-004', 4, 320, 25.00, 'Warehouse A - Shelf 4', 'In Stock'),
('ITM-005', 5, 150, 40.00, 'Warehouse B - Shelf 5', 'Low Stock');

-- Insert Purchase Orders
INSERT INTO `purchase_orders` (`po_number`, `vendor_name`, `order_date`, `delivery_date`, `total_amount`, `status`, `notes`) VALUES
('PO-001', 'Vendor A', '2025-12-01', '2025-12-15', 5250.00, 'Pending', 'Standard order'),
('PO-002', 'Vendor B', '2025-11-25', '2025-12-10', 8500.00, 'Completed', 'Urgent delivery'),
('PO-003', 'Vendor C', '2025-12-03', '2025-12-20', 12000.00, 'Pending', 'Bulk order'),
('PO-004', 'Vendor A', '2025-11-20', '2025-12-05', 3450.00, 'Completed', 'Express delivery'),
('PO-005', 'Vendor D', '2025-12-04', '2025-12-25', 6750.00, 'In Transit', 'Standard order');

-- Insert Expenses
INSERT INTO `expenses` (`expense_id`, `category`, `amount`, `expense_date`, `status`, `description`, `created_by`) VALUES
('EXP-001', 'Office Supplies', 250.00, '2025-12-05', 'Approved', 'Stationery and office materials', 1),
('EXP-002', 'Travel', 1250.00, '2025-12-04', 'Approved', 'Business travel to client site', 2),
('EXP-003', 'Utilities', 850.00, '2025-12-03', 'Pending', 'Monthly office utilities', 1),
('EXP-004', 'Marketing', 2500.00, '2025-12-02', 'Approved', 'Digital marketing campaign', 3),
('EXP-005', 'Training', 1500.00, '2025-12-01', 'Pending', 'Staff training and development', 2);

-- Insert Accounting Transactions
INSERT INTO `accounting_transactions` (`transaction_id`, `transaction_type`, `amount`, `reference_id`, `reference_type`, `transaction_date`, `status`, `notes`) VALUES
('TRX-001', 'Invoice Payment', 5250.00, 'INV-001', 'Invoice', '2025-12-05', 'Completed', 'Payment received for invoice'),
('TRX-002', 'Expense Approval', 250.00, 'EXP-001', 'Expense', '2025-12-05', 'Completed', 'Office supplies expense'),
('TRX-003', 'Purchase Payment', 8500.00, 'PO-002', 'Purchase Order', '2025-12-04', 'Completed', 'Vendor payment'),
('TRX-004', 'Invoice Payment', 8750.00, 'INV-002', 'Invoice', '2025-12-03', 'Completed', 'Payment received'),
('TRX-005', 'Expense Approval', 2500.00, 'EXP-004', 'Expense', '2025-12-02', 'Completed', 'Marketing expense');

-- Insert Employees (HRM)
INSERT INTO `employees` (`employee_id`, `name`, `email`, `phone`, `department`, `position`, `salary`, `joining_date`, `status`) VALUES
('EMP-001', 'John Doe', 'john.doe@company.com', '+1-555-1001', 'Sales', 'Sales Manager', 8500.00, '2020-03-15', 'Active'),
('EMP-002', 'Jane Smith', 'jane.smith@company.com', '+1-555-1002', 'Sales', 'Sales Executive', 6500.00, '2021-06-20', 'Active'),
('EMP-003', 'Mike Johnson', 'mike.johnson@company.com', '+1-555-1003', 'Operations', 'Operations Manager', 7500.00, '2019-01-10', 'Active'),
('EMP-004', 'Sarah Williams', 'sarah.williams@company.com', '+1-555-1004', 'HR', 'HR Manager', 6800.00, '2020-11-01', 'Active'),
('EMP-005', 'Robert Brown', 'robert.brown@company.com', '+1-555-1005', 'Sales', 'Sales Representative', 5500.00, '2022-08-15', 'Active');

-- Insert Quotations
INSERT INTO `quotations` (`quotation_number`, `customer_id`, `quotation_date`, `valid_till_date`, `total_amount`, `status`, `products_json`, `notes`) VALUES
('QT-001', 1, '2025-12-01', '2025-12-31', 8500.00, 'Sent', '[{"product_id":"PRD-001","quantity":2,"unit_price":1200.00}]', 'Volume discount applied'),
('QT-002', 2, '2025-11-28', '2025-12-28', 12500.00, 'Accepted', '[{"product_id":"PRD-003","quantity":5,"unit_price":2500.00}]', 'Custom configuration requested'),
('QT-003', 3, '2025-11-25', '2025-12-25', 6750.00, 'Draft', '[{"product_id":"PRD-002","quantity":15,"unit_price":450.00}]', 'Awaiting customer approval'),
('QT-004', 4, '2025-12-02', '2025-12-15', 4500.00, 'Sent', '[{"product_id":"PRD-005","quantity":10,"unit_price":450.00}]', 'Quick quote request'),
('QT-005', 5, '2025-11-30', '2025-12-30', 9850.00, 'Rejected', '[{"product_id":"PRD-004","quantity":30,"unit_price":299.00}]', 'Customer chose alternative vendor');

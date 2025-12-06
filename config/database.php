<?php
/*
 Copyright (c) 2025 Zeal Web Technologies (https://zealwebtech.com)
 All Rights Reserved.

 This file is part of SalesCRM. No one is permitted to copy, modify,
 distribute, or create derivative works of this file without prior written
 permission from Zeal Web Technologies.
 For permissions contact: legal@zealwebtech.com
*/
/**
 * SalesCRM Database Configuration
 * LAMP Stack Compatible
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'salescrm_user');
define('DB_PASS', 'salescrm_password123');
define('DB_NAME', 'salescrm_db');
define('DB_PORT', 3306);

// Create connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($mysqli->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database Connection Failed: ' . $mysqli->connect_error]));
}

// Set charset to utf8
$mysqli->set_charset('utf8mb4');

// Define base URL
define('BASE_URL', 'http://localhost/salescrm/');
define('API_URL', BASE_URL . 'api/');

?>

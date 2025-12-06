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
 * SalesCRM API Handler
 * Routing and Request Processing
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config/database.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path_parts = explode('/', trim($request_path, '/'));

// Extract API version and endpoint
$api_version = $path_parts[array_search('api', $path_parts) + 1] ?? 'v1';
$endpoint = $path_parts[array_search('api', $path_parts) + 2] ?? '';
$action = $path_parts[array_search('api', $path_parts) + 3] ?? '';

// Parse request body
$input = json_decode(file_get_contents('php://input'), true);
$_REQUEST = array_merge($_GET, $_POST, $input ?? []);

// API Response function
function response($status, $message = '', $data = []) {
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

// Route requests based on endpoint
try {
    switch ($endpoint) {
        case 'users':
            require 'endpoints/users.php';
            break;
        case 'products':
            require 'endpoints/products.php';
            break;
        case 'inventory':
            require 'endpoints/inventory.php';
            break;
        case 'invoices':
            require 'endpoints/invoices.php';
            break;
        case 'purchases':
            require 'endpoints/purchases.php';
            break;
        case 'expenses':
            require 'endpoints/expenses.php';
            break;
        case 'accounting':
            require 'endpoints/accounting.php';
            break;
        case 'employees':
            require 'endpoints/employees.php';
            break;
        case 'quotations':
            require 'endpoints/quotations.php';
            break;
        case 'dashboard':
            require 'endpoints/dashboard.php';
            break;
        default:
            response('error', 'Endpoint not found', ['endpoint' => $endpoint]);
    }
} catch (Exception $e) {
    response('error', $e->getMessage(), []);
}

?>

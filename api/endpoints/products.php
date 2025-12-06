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
 * Products Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT * FROM products ORDER BY id DESC");
    $products = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Products retrieved', $products);
} elseif ($method === 'POST') {
    $product_id = $_REQUEST['product_id'] ?? '';
    $product_name = $_REQUEST['product_name'] ?? '';
    $category = $_REQUEST['category'] ?? '';
    $unit_price = $_REQUEST['unit_price'] ?? 0;
    $stock_quantity = $_REQUEST['stock_quantity'] ?? 0;
    
    $stmt = $mysqli->prepare("INSERT INTO products (product_id, product_name, category, unit_price, stock_quantity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssdi', $product_id, $product_name, $category, $unit_price, $stock_quantity);
    
    if ($stmt->execute()) {
        response('success', 'Product created successfully', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create product', ['error' => $stmt->error]);
    }
}

?>

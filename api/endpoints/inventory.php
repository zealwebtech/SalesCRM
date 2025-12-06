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
 * Inventory Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT i.*, p.product_name FROM inventory i LEFT JOIN products p ON i.product_id = p.id ORDER BY i.id DESC");
    $inventory = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Inventory items retrieved', $inventory);
} elseif ($method === 'POST') {
    $item_id = $_REQUEST['item_id'] ?? '';
    $product_id = $_REQUEST['product_id'] ?? '';
    $quantity = $_REQUEST['quantity'] ?? 0;
    $unit_price = $_REQUEST['unit_price'] ?? 0;
    
    $stmt = $mysqli->prepare("INSERT INTO inventory (item_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sidi', $item_id, $product_id, $quantity, $unit_price);
    
    if ($stmt->execute()) {
        response('success', 'Inventory item created', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create inventory item');
    }
}

?>

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
 * Purchases Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT * FROM purchase_orders ORDER BY id DESC");
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Purchase orders retrieved', $orders);
} elseif ($method === 'POST') {
    $po_number = $_REQUEST['po_number'] ?? '';
    $vendor_name = $_REQUEST['vendor_name'] ?? '';
    $order_date = $_REQUEST['order_date'] ?? date('Y-m-d');
    $total_amount = $_REQUEST['total_amount'] ?? 0;
    
    $stmt = $mysqli->prepare("INSERT INTO purchase_orders (po_number, vendor_name, order_date, total_amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssd', $po_number, $vendor_name, $order_date, $total_amount);
    
    if ($stmt->execute()) {
        response('success', 'Purchase order created', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create purchase order');
    }
}

?>

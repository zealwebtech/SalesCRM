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
 * Quotations Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT q.*, c.customer_name FROM quotations q LEFT JOIN customers c ON q.customer_id = c.id ORDER BY q.id DESC");
    $quotations = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Quotations retrieved', $quotations);
} elseif ($method === 'POST') {
    $quotation_number = $_REQUEST['quotation_number'] ?? '';
    $customer_id = $_REQUEST['customer_id'] ?? 0;
    $quotation_date = $_REQUEST['quotation_date'] ?? date('Y-m-d');
    $valid_till_date = $_REQUEST['valid_till_date'] ?? date('Y-m-d', strtotime('+30 days'));
    $total_amount = $_REQUEST['total_amount'] ?? 0;
    
    $stmt = $mysqli->prepare("INSERT INTO quotations (quotation_number, customer_id, quotation_date, valid_till_date, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sdssd', $quotation_number, $customer_id, $quotation_date, $valid_till_date, $total_amount);
    
    if ($stmt->execute()) {
        response('success', 'Quotation created', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create quotation');
    }
}

?>

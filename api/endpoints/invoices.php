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
 * Invoices Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT i.*, c.customer_name FROM invoices i LEFT JOIN customers c ON i.customer_id = c.id ORDER BY i.id DESC");
    $invoices = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Invoices retrieved', $invoices);
} elseif ($method === 'POST') {
    $invoice_number = $_REQUEST['invoice_number'] ?? '';
    $customer_id = $_REQUEST['customer_id'] ?? 0;
    $issue_date = $_REQUEST['issue_date'] ?? date('Y-m-d');
    $due_date = $_REQUEST['due_date'] ?? date('Y-m-d', strtotime('+30 days'));
    $total_amount = $_REQUEST['total_amount'] ?? 0;
    
    $stmt = $mysqli->prepare("INSERT INTO invoices (invoice_number, customer_id, issue_date, due_date, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sdssd', $invoice_number, $customer_id, $issue_date, $due_date, $total_amount);
    
    if ($stmt->execute()) {
        response('success', 'Invoice created successfully', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create invoice');
    }
}

?>

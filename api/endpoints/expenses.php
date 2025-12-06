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
 * Expenses Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT e.*, u.name as created_by_name FROM expenses e LEFT JOIN users u ON e.created_by = u.id ORDER BY e.id DESC");
    $expenses = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Expenses retrieved', $expenses);
} elseif ($method === 'POST') {
    $expense_id = $_REQUEST['expense_id'] ?? '';
    $category = $_REQUEST['category'] ?? '';
    $amount = $_REQUEST['amount'] ?? 0;
    $expense_date = $_REQUEST['expense_date'] ?? date('Y-m-d');
    $created_by = $_REQUEST['created_by'] ?? 1;
    
    $stmt = $mysqli->prepare("INSERT INTO expenses (expense_id, category, amount, expense_date, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdsi', $expense_id, $category, $amount, $expense_date, $created_by);
    
    if ($stmt->execute()) {
        response('success', 'Expense created', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create expense');
    }
}

?>

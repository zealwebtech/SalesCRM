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
 * Accounting Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT * FROM accounting_transactions ORDER BY id DESC");
    $transactions = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Transactions retrieved', $transactions);
} elseif ($method === 'POST') {
    $transaction_id = $_REQUEST['transaction_id'] ?? '';
    $transaction_type = $_REQUEST['transaction_type'] ?? '';
    $amount = $_REQUEST['amount'] ?? 0;
    $reference_id = $_REQUEST['reference_id'] ?? '';
    $transaction_date = $_REQUEST['transaction_date'] ?? date('Y-m-d');
    
    $stmt = $mysqli->prepare("INSERT INTO accounting_transactions (transaction_id, transaction_type, amount, reference_id, transaction_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdss', $transaction_id, $transaction_type, $amount, $reference_id, $transaction_date);
    
    if ($stmt->execute()) {
        response('success', 'Transaction recorded', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to record transaction');
    }
}

?>

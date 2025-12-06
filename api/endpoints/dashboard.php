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
 * Dashboard Statistics Endpoint
 */

if ($method === 'GET') {
    $action = $action ?? 'stats';
    
    if ($action === 'stats' || empty($action)) {
        // Get statistics for dashboard
        $total_invoices = $mysqli->query("SELECT COUNT(*) as count FROM invoices")->fetch_assoc()['count'];
        $total_revenue = $mysqli->query("SELECT SUM(total_amount) as sum FROM invoices WHERE status = 'Paid'")->fetch_assoc()['sum'];
        $total_users = $mysqli->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
        $total_products = $mysqli->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
        $total_customers = $mysqli->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
        $pending_invoices = $mysqli->query("SELECT COUNT(*) as count FROM invoices WHERE status = 'Pending'")->fetch_assoc()['count'];
        
        $stats = [
            'total_invoices' => $total_invoices,
            'total_revenue' => $total_revenue ?? 0,
            'total_users' => $total_users,
            'total_products' => $total_products,
            'total_customers' => $total_customers,
            'pending_invoices' => $pending_invoices
        ];
        
        response('success', 'Dashboard stats retrieved', $stats);
    }
}

?>

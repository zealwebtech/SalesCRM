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
 * Employees Endpoint
 */

if ($method === 'GET') {
    $result = $mysqli->query("SELECT e.*, m.name as manager_name FROM employees e LEFT JOIN employees m ON e.manager_id = m.id ORDER BY e.id DESC");
    $employees = $result->fetch_all(MYSQLI_ASSOC);
    response('success', 'Employees retrieved', $employees);
} elseif ($method === 'POST') {
    $employee_id = $_REQUEST['employee_id'] ?? '';
    $name = $_REQUEST['name'] ?? '';
    $email = $_REQUEST['email'] ?? '';
    $department = $_REQUEST['department'] ?? '';
    $position = $_REQUEST['position'] ?? '';
    $salary = $_REQUEST['salary'] ?? 0;
    
    $stmt = $mysqli->prepare("INSERT INTO employees (employee_id, name, email, department, position, salary) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssd', $employee_id, $name, $email, $department, $position, $salary);
    
    if ($stmt->execute()) {
        response('success', 'Employee created', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create employee');
    }
}

?>

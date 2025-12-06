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
 * Users Endpoint
 */

if ($method === 'GET') {
    if ($action === 'all' || empty($action)) {
        $result = $mysqli->query("SELECT id, name, email, role, status, created_at FROM users ORDER BY id DESC");
        $users = $result->fetch_all(MYSQLI_ASSOC);
        response('success', 'Users retrieved', $users);
    } elseif (is_numeric($action)) {
        $result = $mysqli->query("SELECT * FROM users WHERE id = $action");
        $user = $result->fetch_assoc();
        response('success', 'User retrieved', $user);
    }
} elseif ($method === 'POST') {
    $name = $_REQUEST['name'] ?? '';
    $email = $_REQUEST['email'] ?? '';
    $role = $_REQUEST['role'] ?? 'Sales Representative';
    $password = md5($_REQUEST['password'] ?? 'password123');
    
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $email, $password, $role);
    
    if ($stmt->execute()) {
        response('success', 'User created successfully', ['id' => $mysqli->insert_id]);
    } else {
        response('error', 'Failed to create user', ['error' => $stmt->error]);
    }
} elseif ($method === 'PUT') {
    $id = $action;
    $name = $_REQUEST['name'] ?? '';
    $role = $_REQUEST['role'] ?? '';
    $status = $_REQUEST['status'] ?? '';
    
    $stmt = $mysqli->prepare("UPDATE users SET name = ?, role = ?, status = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $role, $status, $id);
    
    if ($stmt->execute()) {
        response('success', 'User updated successfully');
    } else {
        response('error', 'Failed to update user', ['error' => $stmt->error]);
    }
} elseif ($method === 'DELETE') {
    $id = $action;
    
    if ($mysqli->query("DELETE FROM users WHERE id = $id")) {
        response('success', 'User deleted successfully');
    } else {
        response('error', 'Failed to delete user');
    }
}

?>

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
 * SalesCRM Setup Helper
 * Run this file once to initialize the database
 * Access via: http://localhost/salescrm/setup.php
 */

// Check if already installed
if (file_exists(__DIR__ . '/config/database.php')) {
    echo "<h2>SalesCRM Setup</h2>";
    echo "<p>The database configuration file already exists.</p>";
    
    // Try to connect to database
    require_once 'config/database.php';
    
    if (!$mysqli->connect_error) {
        echo "<p style='color: green;'><strong>✓ Database connection successful!</strong></p>";
        
        // Check if tables exist
        $result = $mysqli->query("SHOW TABLES FROM salescrm_db");
        $table_count = $result->num_rows;
        
        if ($table_count > 0) {
            echo "<p style='color: green;'><strong>✓ Database tables already created!</strong></p>";
            echo "<p>Application is ready to use.</p>";
            echo "<p><a href='index.html'>Click here to access SalesCRM</a></p>";
        } else {
            echo "<p style='color: orange;'><strong>⚠ Database tables not found. Running schema...</strong></p>";
            runSchema();
        }
    } else {
        echo "<p style='color: red;'><strong>✗ Database connection failed!</strong></p>";
        echo "<p>Error: " . $mysqli->connect_error . "</p>";
        echo "<p>Please check your database configuration in config/database.php</p>";
    }
} else {
    echo "<p style='color: red;'>Database configuration file not found!</p>";
}

function runSchema() {
    global $mysqli;
    
    // Read schema file
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $dump = file_get_contents(__DIR__ . '/database/dump.sql');
    
    // Execute schema
    if ($mysqli->multi_query($schema)) {
        echo "<p style='color: green;'>✓ Database schema created successfully!</p>";
        
        // Clear results
        while ($mysqli->next_result()) {}
        
        // Execute dummy data
        if ($mysqli->multi_query($dump)) {
            echo "<p style='color: green;'>✓ Dummy data imported successfully!</p>";
            echo "<p><a href='index.html'>Click here to access SalesCRM</a></p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to import dummy data: " . $mysqli->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Failed to create schema: " . $mysqli->error . "</p>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>SalesCRM Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
        }
        p {
            line-height: 1.6;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>SalesCRM - Setup & Status</h1>
    <p>If you see this page, the setup has been initialized. Please check the messages above.</p>
    <hr>
    <h3>Next Steps:</h3>
    <ul>
        <li>Access the application at: <a href="index.html">http://localhost/salescrm/</a></li>
        <li>Default admin credentials:
            <ul>
                <li>Email: admin@salescrm.com</li>
                <li>Password: admin@123</li>
            </ul>
        </li>
        <li>Change default passwords immediately after first login</li>
        <li>Refer to README.md for complete documentation</li>
    </ul>
</body>
</html>

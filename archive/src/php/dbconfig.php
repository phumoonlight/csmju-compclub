<?php
// Database configuration
$dbHost = "xxx";
$dbUsername = "xxx";
$dbPassword = "xxx";
$dbName = "xxx";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$db->set_charset("utf8");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

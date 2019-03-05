<?php
// Database configuration
$dbHost = "localhost";
$dbUsername = "jowaveco_csmju";
$dbPassword = "2nPn74dF";
$dbName = "jowaveco_csmju";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$db->set_charset("utf8");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

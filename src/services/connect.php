<?php
// Database configuration
// ask teacher to get database setup
$db_host = "xxx";
$db_username = "xxx";
$db_password = "xxx";
$db_name = "xxx";

// Create database connection
$db = new mysqli($db_host, $db_username, $db_password, $db_name);
$db->set_charset("utf8");

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

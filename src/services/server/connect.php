<?php
// database configuration
$db_host = "localhost";
$db_name = "jowaveco_csmju";
$db_ussername = "jowaveco_csmju";
$db_password = "2nPn74dF";

// database connection
$db = new mysqli($db_host, $db_ussername, $db_password, $db_name);
$db->set_charset("utf8");

// check database connection
if ($db->connect_error) {
    die("Connection failed: $db->connect_error");
}

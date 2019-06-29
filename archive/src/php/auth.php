<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include "$doc_root/checklogin.php";
//-----------------------------------------
if ($_SESSION["Userauth"] == "admin") {
    $admin_boolean = 0;
} else if ($_SESSION["Userauth"] == "user") {
    $admin_boolean = 1;
} else {
    $admin_boolean = 1;
}
//-----------------------------------------

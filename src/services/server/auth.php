<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include "$doc_root/checklogin.php";
if ($_SESSION["Userauth"] == "admin") {
    // TODO...
} else if ($_SESSION["Userauth"] == "user") {
    // TODO...
} else {
    // TODO...
}


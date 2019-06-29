<?php
// check if you login or not
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include "$doc_root/checklogin.php";

// if you have already login
if ($_SESSION["Userauth"] == "admin") {
    // DO something if you are admin
} else if ($_SESSION["Userauth"] == "user") {
    // DO something if you are common user [student]
} else {
    // DO else [???]
}
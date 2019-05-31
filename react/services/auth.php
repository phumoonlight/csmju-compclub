<?php
$docRoot = $_SERVER["DOCUMENT_ROOT"];
include "$docRoot/checklogin.php";
$userAuth = $_SESSION["Userauth"];
echo $userAuth;
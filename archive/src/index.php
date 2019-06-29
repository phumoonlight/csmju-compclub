<?
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT'];
echo $doc_root;
include("$doc_root/checklogin.php");
//-----------------------------------------
if($_SESSION["Userauth"] == "admin"){
    header('Location: homeadmin.php');
}else if($_SESSION["Userauth"] == "user"){
    header('Location: homeuser.php');
}else{
    echo "Login";
}
//-----------------------------------------
?>
<?php echo $_SESSION["Username"];?>
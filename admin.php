<?php 
session_start();
require 'src/php/main.php';
require_once 'src/php/auth.php';

if( $_SESSION["Userauth"] != "admin" ) {
    header("Location: index.php");
}

$admin = new admin();
?>

<!DOCTYPE html>
<html>

<head><?php require $head_path; ?></head>

<body>
    <section class="navbar"><?php require $navbar_path; ?></section>
    <!----------------------------------------------------------------------------------->
    <section class="title">ชมรมคอมพิวเตอร์</section>
    <!----------------------------------------------------------------------------------->
    <section class="menu"><?php require $menu_path; ?></section>
    <!----------------------------------------------------------------------------------->
    <section class="content">
        <div class="content-header">การจัดการชมรม</div><hr>
        <div class="admin-menu">
            <a href="admin.php?admin_menu=member"> ทำเนียบชมรม </a>
            <a href="admin.php?admin_menu=advisor"> อาจารย์ที่ปรึกษา </a>
            <a href="admin.php?admin_menu=activity"> โครงการและกิจกรรม </a>
            <a href="http://cslabs.jowave.com/5904101391/"> upload video </a>
        </div>
        <?php $admin->GetContent('admin_menu'); ?>
    </section>
    <!----------------------------------------------------------------------------------->
    <?php require $footer_path; ?>
</body>

</html>


<?php 
session_start();
require 'src/php/main.php';
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
            <a href="admin.php?admin_menu=member"> จัดการ ทำเนียบชมรม</a>
            <a href="admin.php?admin_menu=advisor"> จัดการ อาจารย์ที่ปรีกษา</a>
            <a href="admin.php?admin_menu=activity">จัดการ โครงการ</a>
        </div>
        <?php $admin->GetContent('admin_menu'); ?>
    </section>
    <!----------------------------------------------------------------------------------->
    <?php require $footer_path; ?>
</body>

</html>


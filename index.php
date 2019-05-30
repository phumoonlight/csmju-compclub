<?php
session_start();
require 'src/php/main.php';
require_once 'src/php/auth.php';
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
        <div class="content-header">หน้าหลักชมรมคอมพิวเตอร์</div>
        <div id="index-img"></div>
    </section>
    <!----------------------------------------------------------------------------------->
    <?php require $footer_path; ?>
</body>

</html>
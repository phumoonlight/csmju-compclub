<?php
session_start();
require 'src/php/main.php';
?>

<!DOCTYPE html>
<html>

<head><?php require $head_path;?></head>

<div class="activity-modal"></div>
<div class="modal-container">
    <div class="modal-container2">
        <div class="activity-modal-header"></div>
        <div class="activity-modal-year"></div>
        <div class="activity-modal-content"></div>
        <div class="activity-modal-header-static">รูปภาพกิจกรรม</div>
        <div class="activity-modal-img"></div>
        <div class="activity-modal-header-static">เอกสารที่เกี่ยวข้อง</div>
        <div class="activity-modal-document"></div>
    </div>
</div>

<div class="image-modal">
    <img src="">
</div>


<body>
    <section class="navbar"><?php require $navbar_path; ?></section>
    <!----------------------------------------------------------------------------------->
    <section class="title">ชมรมคอมพิวเตอร์</section>
    <!----------------------------------------------------------------------------------->
    <section class="menu"><?php require $menu_path;?></section>
    <!----------------------------------------------------------------------------------->
    <section class="content">
        <div class="content-header">โครงการและกิจกรรม</div>
        <input type="number" placeholder="ค้นหาปีการศึกษา (พ.ศ.)" name="year" id="activity">
        <input type="submit" value="ค้นหา">
        <div class="content-activity"></div>
    </section>
    <!----------------------------------------------------------------------------------->
    <?php require $footer_path;?>
</body>

</html>
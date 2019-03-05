<?php
session_start();
require 'src/php/main.php';
?>
<!DOCTYPE html>
<html>

<head><?php require $head_path;?></head>

<body>
    <section class="navbar"><?php require $navbar_path; ?></section>
    <!----------------------------------------------------------------------------------->
    <section class="title">ชมรมคอมพิวเตอร์</section>
    <!----------------------------------------------------------------------------------->
    <section class="menu"><?php require $menu_path;?></section>
    <!----------------------------------------------------------------------------------->
    <section class="content">
        <div class="content-header">เกี่ยวกับชมรม</div>
        <div class="content-header2">ที่มาและความสำคัญ</div>
        <article>
            เนื่องจาก อดีตจนถึงปัจจุบันนี้ชมรมของสาขาวิชาวิทยาการคอมพิวเตอร์ไม่มีระบบสารสนเทศเป็นของตัวเอง
            ทำให้ชมรมไม่มีที่สืบค้นหรือจัดเก็บข้อมูลที่เกี่ยวข้องกับชมรมอาทิเช่น เอกสารขอยืมสถานที่ในการจัดกิจกรรม
            เอกสารกิจกรรมของชมรมในแต่ละปีการศึกษา ข้อมูลสมาชิกชมรม
        </article>
        <div class="content-header2">วัตถุประสงค์</div>
        <ul>
            <li>
                ระบบสารสนเทศนี้สามารถเข้าถึงมูลที่เกี่ยวกับชมรมได้
            </li>
            <li>
                ระบบสารสนเทศนี้สมาชิกสามารถ
                อัพโหลด จัดเก็บ และแก้ไข ข้อมูลที่เกี่ยวกับชมรมได้
            </li>
            <li>
                ระบบสารสนเทศนี้ทำขึ้นเพื่อชมรมของ
                สาขาวิชาวิทยาการคอมพิวเตอร์
                และสามารถใช้งานต่อๆไปได้ในอนาคตได้
            </li>
        </ul>
    </section>
    <!----------------------------------------------------------------------------------->
    <?php require $footer_path;?>
</body>

</html>
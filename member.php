<?php
session_start();
require 'src/php/main.php';
$position = array("ประธาน", "รองประธาน", "เลขา", "เหรัญญิก", "ปฏิคม", "ประชาสัมพันธ์", "พัสดุ", "กรรมการ");
$member = new member();
$advisor = new advisor();

if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = 2561; //default //date("Y") + 543
}
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
        <div class="content-header member">ทำเนียบชมรมคอมพิวเตอร์</div>
        <form class="member-form" action="member.php" method="get">
            <input type="number" placeholder="ค้นหาปีการศึกษา (พ.ศ.)" name="year" value="<?php echo (isset($_GET['year']) ? $year : '' );?>" required>
            <input type="submit" value="ค้นหา">
        </form>
        <div class="member-section">
            <?php $advisor->getAdvisor();?>
        </div>
        <div class="member-section">
            <?php $member->getMember($position[0]);?>
        </div>
        <div class="member-section">
            <?php $member->getMember($position[1]);?>
            <?php $member->getMember($position[2]);?>
            <?php $member->getMember($position[3]);?>
        </div>
        <div class="member-section">
            <?php $member->getMember($position[4]);?>
            <?php $member->getMember($position[5]);?>
            <?php $member->getMember($position[6]);?>
        </div>
        <div class="member-section">
            <?php $member->getMember($position[7]);?>
        </div>
    </section>
    <!----------------------------------------------------------------------------------->
    <?php require $footer_path;?>
</body>

</html>
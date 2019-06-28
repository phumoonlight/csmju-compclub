<?php
if (isset($_POST['submit'])) {
    $student_id = $_POST['studentid'];
    $student_position = $_POST['position'];
    $year = $_POST['year'];
    $img_name = $_FILES["img"]["name"];
    $img_tmp = $_FILES['img']['tmp_name'];
    $admin_member = new adminMember($student_id, $student_position, $img_name, $img_tmp, $year);
    $admin_member->insertImg()->insertSQL();
    header('Location: admin.php?admin_menu=member');
} else {
    $admin_member = new adminMember();
}

if (isset($_GET['deleteid'])) {
    $delete_id = $_GET['deleteid'];
    $admin_member->deleteMember($delete_id);
    header('Location: admin.php?admin_menu=member');
}
?>

<form class="admin-form" action="admin.php?admin_menu=member" method="post" enctype="multipart/form-data">
    <table class="admin-form-table">
        <tr>
            <th>เพิ่มรูปภาพ (.jpg / .png)</th>
            <td><input type="file" name="img" accept=".jpg, .png" required></td>
        </tr>
        <tr>
            <th>รหัสนักศึกษา</th>
            <td>
                <input type="number" placeholder="รหัสนักศึกษา" name="studentid" list="stuid-list" required>
                <datalist id="stuid-list"><?php $admin_member->getStudentId();?></datalist>
                <input class="output-name" type="text" readonly>
            </td>
        </tr>
        <tr>
            <th>เลือกตำแหน่ง</th>
            <td>
                <select name="position" required>
                    <option value="">เลือกตำแหน่ง</option>
                    <option value="ประธาน">ประธาน</option>
                    <option value="รองประธาน">รองประธาน</option>
                    <option value="เลขา">เลขา</option>
                    <option value="เหรัญญิก">เหรัญญิก</option>
                    <option value="ปฏิคม">ปฏิคม</option>
                    <option value="ประชาสัมพันธ์">ประชาสัมพันธ์</option>
                    <option value="พัสดุ">พัสดุ</option>
                    <option value="กรรมการ">กรรมการ</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>ปีการศึกษาที่รับผิดชอบ</th>
            <td><input type="number" placeholder="ปีการศึกษาที่รับผิดชอบ" name="year" required></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" name="submit" value="เพิ่ม" disabled></td>
        </tr>
    </table>
</form>

<input type="text" id="admin-search" placeholder="ค้นหา ( ชื่อ / รหัส / ตำแหน่ง / ปีการศึกษา ) : Enter เพื่อทำการค้นหา">
<input class='search-btn' type='submit' value="ค้นหา">

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>รูป</th>
                <th>รหัสนักศึกษา</th>
                <th>ชื่อ</th>
                <th>ตำแหน่ง</th>
                <th>ปีการศึกษาที่รับผิดชอบ</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php $admin_member->getMember();?>
        </tbody>
    </table>
</div>
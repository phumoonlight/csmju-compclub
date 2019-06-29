<?php
$url = "admin.php?admin_menu=advisor";

if (isset($_POST['submit'])) {
    $personal_id = $_POST['personal'];
    $advisor_year = $_POST['year'];
    $admin_advisor = new adminAdvisor($personal_id, $advisor_year);
    $admin_advisor->insertInput();
    header("Location: $url");
} else {
    $admin_advisor = new adminAdvisor();
}

if (isset($_GET['deleteid'])) {
    $delete_id = $_GET['deleteid'];
    $admin_advisor->deleteAdvisor($delete_id);
    header("Location: $url");
}
?>

<form class="admin-form" action="admin.php?admin_menu=advisor" method="post" enctype="multipart/form-data">
    <table class="admin-form-table">
        <tr>
            <th>เลือกอาจารย์ที่ปรึกษา</th>
            <td>
                <select name="personal" required>
                    <option value="">เลือกอาจารย์ที่ปรึกษา</option>
                    <?php $admin_advisor->getAdvisorList();?>
                </select>
            </td>
        </tr>
        <tr>
            <th>ปีการศึกษาที่รับผิดชอบ</th>
            <td><input type="number" name="year" placeholder="ปีการศึกษาที่รับผิดชอบ" required></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" name="submit" value="เพิ่ม"></td>
        </tr>
    </table>
</form>
<div>
    <input type="text" id="admin-search" placeholder="ค้นหา ( ชื่อ / ปีการศึกษา ) : Enter เพื่อทำการค้นหา">
    <input class='search-btn' type='submit' value="ค้นหา">
</div>
<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>รูป</th>
                <th>ชื่อ</th>
                <th>ปีการศึกษาที่รับผิดชอบ</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php $admin_advisor->getAdvisor(); ?>
        </tbody>
    </table>
</div>
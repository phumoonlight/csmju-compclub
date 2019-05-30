<?php
$ADMIN_ACTIVITY_URL = "admin.php?admin_menu=activity";

if (isset($_POST['submit'])) {
    $activity_year = $_POST['year_start'];
    $activity_name = $_POST['activity'];
    $activity_month = $_POST['month'];

    $activity_count = 0;
    for ($i = 0; $i < count($activity_name); $i++) {
        if ($activity_name[$i] != "") {
            $activity_count++;
        }
    }

    array_splice($activity_name, $activity_count + 1);
    array_splice($activity_month, $activity_count + 1);
    $timestamp = strtotime($activity_year);
    $activity_year = date('Y-m-d', $timestamp);

    $admin_activity = new adminActivity($activity_year, $activity_name, $activity_month, $activity_count);
    $admin_activity->insertInput();
    header("Location: $ADMIN_ACTIVITY_URL");
} else {
    $admin_activity = new adminActivity();
}

if (isset($_POST['edit_submit'])) {
    $array = array();
    $activity_id = $_POST['edit_activity_id'];
    $activity_name = $_POST['edit_activity_name'];
    $activity_detail = $_POST['edit_activity_detail'];
    $activity_img = $_FILES['edit_activity_img'];
    $activity_doc = $_FILES['edit_activity_doc'];

    array_push($array, $activity_id, $activity_name, $activity_detail, $activity_img, $activity_doc);

    $admin_activity->updateSQL($array);
    header("Location: $ADMIN_ACTIVITY_URL");
}

if (isset($_GET['deleteid'])) {
    $deleteID = $_GET['deleteid'];
    deleteSQL($deleteID);
    header("Location: $ADMIN_ACTIVITY_URL");
}
?>

<datalist id="activity-list">
    <?php $admin_activity->selectActivityAutoListSQL();?>
</datalist>

<div class="activity-admin-modal"></div>
<div class="modal-container">
    <div class="modal-container2">
        <form class="admin-form" action="admin.php?admin_menu=activity" method="post" enctype="multipart/form-data">
            <table class="admin-form-table">
                <tr>
                    <th>แก้ไขชื่อกิจกรรม</th>
                    <td>
                        <input type="text" placeholder="ชื่อกิจกรรม" name="edit_activity_name" list="activity-list" required>
                    </td>
                </tr>
                <tr>
                    <th>แก้ไขรายละเอียดกิจกรรม</th>
                    <td>
                        <textarea placeholder="รายละเอียดกิจกรรม" name="edit_activity_detail"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>เพิ่มรูปภาพ</th>
                    <td>
                        <input type="file" name="edit_activity_img[]" accept="image/*" multiple>
                    </td>
                </tr>
                <tr>
                    <th>เพิ่มเอกสาร</th>
                    <td>
                        <input type="file" name="edit_activity_doc[]" multiple>
                    </td>
                </tr>
                <tr>
                    <th><input type="hidden" name="edit_activity_id"></th>
                    <td><input type="submit" name="edit_submit" value="ยืนยันการแก้ไข"></td>
                </tr>
            </table>
        </form>
        <div class="activity-modal-header-static">การจัดการรูปภาพกิจกรรม</div>
        <div class="admin-activity-modal-img"></div>
        <div class="activity-modal-header-static">การจัดการเอกสารที่เกี่ยวข้อง</div>
        <div class="admin-activity-modal-document">
            <table>
                <thead>
                    <tr>
                        <th>ชื่อ file</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<form class="admin-form" action="admin.php?admin_menu=activity" method="post" enctype="multipart/form-data">
    <table class="admin-form-table">
        <tr>
            <th>เดือนที่เริ่มปีการศึกษา</th>
            <td>
                <input type="month" name="year_start" required>
            </td>
        </tr>
        <tr>
            <th>เพิ่มกิจกรรม</th>
            <td>
                <input type="text" placeholder="ชื่อกิจกรรม" name="activity[]" list="activity-list" required>
                <select name="month[]" required>
                    <option value="">เลือกเดือนที่จัดกิจกรรม</option>
                    <option value="1">มกราคม</option>
                    <option value="2">กุมภาพันธ์</option>
                    <option value="3">มีนาคม</option>
                    <option value="4">เมษายน</option>
                    <option value="5">พฤษภาคม</option>
                    <option value="6">มิถุนายน</option>
                    <option value="7">กรกฎาคม</option>
                    <option value="8">สิงหาคม</option>
                    <option value="9">กันยายน</option>
                    <option value="10">ตุลาคม</option>
                    <option value="11">พฤศจิกายน</option>
                    <option value="12">ธันวาคม</option>
                </select>
                <div class="input-activity"></div>
            </td>
        </tr>
        <tr>
            <th><input type="button" value="เพิ่มกิจกรรม +"></th>
            <td><input type="submit" name="submit" value="เพิ่มโครงการ"> ยืนยันการเพิ่มโครงการ <input type="checkbox"
                    required> </td>
        </tr>
    </table>
</form>

<input type="text" id="admin-search" placeholder="ค้นหา ( ลำดับ / ชื่อ / เดือน / ปีการศึกษา ) : Enter เพื่อทำการค้นหา">
<input class='search-btn' type='submit' value="ค้นหา">

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อกิจกรรม</th>
                <th>เดือน</th>
                <th>ปีการศึกษา</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php $admin_activity->getActivityList();?>
        </tbody>
    </table>
</div>
<?php
adminDocument::deleteList();
?>

<form class="admin-form" action="admin.php?admin_menu=document" method="post" enctype="multipart/form-data">
    เพิ่ม file เอกสาร
    <input type="file" name="doc" required>
    <input type="submit" name="input" value="เพิ่ม">
    <?php echo adminDocument::setInput('input'); ?>
</form>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>ชื่อ file</th>
                <th>วันที่เพิ่ม file</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php adminDocument::getList(); ?>
        </tbody>
    </table>
</div>





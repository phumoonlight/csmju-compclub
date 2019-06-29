<?php
$admin_index = new adminIndex();
$admin_index->setInput('input');
?>

<div class="content-header2">แก้ไข เกี่ยวกับชมรม</div>
<form action="admin.php?admin_menu=index" method="post" class="admin-form">
    <textarea name="input"><?php echo $admin_index->getContent(); ?></textarea>
    <input type="submit" value="ยืนยันการแก้ไข">
</form>


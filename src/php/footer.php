<footer> </footer>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/main.js"></script>
<script>
    if(<?php echo $admin_boolean; ?>) {
        $(".sub-menu.admin").hide();
    }
</script>
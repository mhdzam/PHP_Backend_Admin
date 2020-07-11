<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<script>
    function delete_file_onedit() {
        document.getElementById('file_show_div').style.display = 'none';
        document.getElementById('file_del_var').value = '1';
        document.getElementById('file_undo_div').style.display = 'block';
    }
    function undo_delete_file_onedit() {
        document.getElementById('file_show_div').style.display = 'block';
        document.getElementById('file_del_var').value = '0';
        document.getElementById('file_undo_div').style.display = 'none';
    }
    function delete_file_onedit2() {
        document.getElementById('file_show_div2').style.display = 'none';
        document.getElementById('file_del_var2').value = '1';
        document.getElementById('file_undo_div2').style.display = 'block';
    }
    function undo_delete_file_onedit2() {
        document.getElementById('file_show_div2').style.display = 'block';
        document.getElementById('file_del_var2').value = '0';
        document.getElementById('file_undo_div2').style.display = 'none';
    }
</script>
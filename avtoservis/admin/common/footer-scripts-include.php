<script src="<?php echo ADMIN_PATH.LIBRARY_PATH.'jquery-1.11.1.min.js'; ?>"></script>
<script src="<?php echo ADMIN_PATH.LIBRARY_PATH.'jquery-ui/jquery-ui.js'; ?>"></script>
<script src="<?php echo ADMIN_PATH.STYLES_PATH.'bootstrap/js/bootstrap.js'; ?>"></script>
<script src="<?php echo ADMIN_PATH.SCRIPTS_PATH.'functions.js'; ?>"></script>
<script src="<?php echo ADMIN_PATH.SCRIPTS_PATH.'ckeditor/ckeditor.js'; ?>"></script>

<script type="text/javascript">
CKEDITOR.replace( 'editor1', {
    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl: '/ckfinder/ckfinder.html?Type=Flash',
    filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
</script>
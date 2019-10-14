<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?php echo URLADM . 'assets/js/dashboard.js'; ?>"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/10.1.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#editor-um' ) )
    .catch( error => {
        console.error( error );
    } );
    
    ClassicEditor
    .create( document.querySelector( '#editor-dois' ) )
    .catch( error => {
        console.error( error );
    } );
    
    ClassicEditor
    .create( document.querySelector( '#editor-tres' ) )
    .catch( error => {
        console.error( error );
    } );
    
</script>
</body>
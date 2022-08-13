<?php 
$editor = $args['editor'];
?>
<?php if($editor) { ?>
<section class="simple-editor">
    <div class="container">
        <div class="editor-wrapper">
            <?php echo $editor; ?>
        </div>
    </div>
</section>
<?php } ?>
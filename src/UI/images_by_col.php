<?php 
    $images = $args['images'];
?>
<?php if($images): ?>
<section class="images-by-col">
    <div class="container">
        <div class="images-list">
            <?php foreach ($images as $image): 
                $img = $image['img'];
            ?>
            <div class="images-list__item">
                <img 
                    src="<?php echo $img['url']; ?>" 
                    alt="<?php echo $img['alt']; ?>"
                    title="<?php echo $img['title']; ?>"
                    width="<?php echo $img['width']; ?>"
                    height="<?php echo $img['height']; ?>"
                    loading="lazy"
                >
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
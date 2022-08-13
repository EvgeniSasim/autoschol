<?php 
    $img = $args['img'];
?>
<section class="simple-img-half-bg">
    <div class="container">
        <div class="img-wrapper">
            <img 
                src="<?php echo $img['url']; ?>" 
                alt="<?php echo $img['alt']; ?>"
                title="<?php echo $img['title']; ?>"
                width="<?php echo $img['width']; ?>"
                height="<?php echo $img['height']; ?>"
                loading="lazy"
            >
        </div>
    </div>
</section>
<?php 
    $title = $args['zagolovok'];
    $images = $args['sertifikat'];
    $size = 'full';
?>
<section class="certificates-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
    <?php
    if( $images ): ?>
        <ul class="certificates-gallery">
            <?php foreach( $images as $image ): ?>
                <li>
                    <a href="<?php echo $image['url'] ?>" class="glightbox" data-gallery="gallery">
                        <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php 
         add_action( 'wp_init_lightbox', 'init_lightbox');
         do_action('wp_init_lightbox');
        endif; 
    ?>
    </div>
</section>
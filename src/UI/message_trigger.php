<?php 
    $title = $args['zagolovok'];
    $subTitle = $args['podzagolovok'];
    $descr = $args['opisanie'];
    $idCF7 = url_to_postid($args['id_kontaktnoj_formy']);
?>
<section class="message-trigger-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="trigger-subtitle">
            <p><?php echo $subTitle; ?></p>
        </div>
        <div class="trigger-description">
            <p><?php echo $descr; ?></p>
        </div>
        <div class="trigger-form">
        <?php echo do_shortcode('[contact-form-7 id="'. $idCF7 .'" title=""]'); ?>
        </div>
    </div>
</section>
<?php
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', 'colorese(".message-trigger-section .trigger-subtitle > p");' );
?>

<?php 
    $title = $args['title'];
    $video_url = $args['video_url'];
    $open_form = $args['open_form'];
    $idForm = url_to_postid($open_form);
?>
<section class="video-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="iframe-wrapper">
            <?php echo $video_url ?>
        </div>
        <div class="open-form-btn">
            <button class="primary-btn <?php echo "btn-" .$idForm;?>">
                <?php echo get_the_title($idForm); ?>
            </button>
        </div>
    </div>
</section>
<?php 
    $subTitle = $args['podzagolovok'];
    $descr = $args['opisanie'];
?>
<section class="modal-window" id="<?php echo $idForm.'-modal'; ?>">
    <div class="container">
       <div class="modal-wrapper">
            <span class="close-modal"></span>
            <h3><?php echo get_the_title($idForm); ?></h3>
            <div class="trigger-subtitle additional-services">
                <p><?php echo $subTitle; ?></p>
            </div>
            <div class="trigger-description">
                <p><?php echo $descr; ?></p>
            </div>
            <div class="trigger-form">
                <?php echo do_shortcode('[contact-form-7 id="'. $idForm .'" title=""]'); ?>
            </div>
            <div class="notification">
                <span>Мы ценим ваш запрос!<br/> В ближайшее время с Вами свяжется один из Наших специалистов.</span>
            </div>
       </div>
    </div>
</section>
<?php 
    $scripts = '
        modal("'. $idForm .'");
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );
?>
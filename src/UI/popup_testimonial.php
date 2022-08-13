<?php 
    $madalOptions = get_field('id_popup_testimonial', 'option');
    $title = $madalOptions['zagolovok'];
    $idCF7 = url_to_postid($madalOptions['id_kontaktnoj_formy']);
?>
<section class="modal-window" id="<?php echo $idCF7.'-modal'; ?>">
    <div class="container">
       <div class="modal-wrapper testimonial">
            <span class="close-modal"></span>
            <h3><?php echo $title; ?></h3>
            <div class="rank">
               <ul class="rank__list">
                   <li class="rank__list__star disable"></li>
                   <li class="rank__list__star disable"></li>
                   <li class="rank__list__star disable"></li>
                   <li class="rank__list__star disable"></li>
                   <li class="rank__list__star disable"></li>
               </ul>
            </div>
            <div class="trigger-form">
                <?php echo do_shortcode('[contact-form-7 id="'. $idCF7 .'" title=""]'); ?>
            </div>
            <div class="notification">
                <span>Мы ценим ваш запрос!<br/> В ближайшее время с Вами свяжется один из Наших специалистов.</span>
            </div>
       </div>
    </div>
</section>
<?php 
     add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
     do_action( 'wp_enqueue_scripts', 'modal("'. $idCF7 .'");executeRating();' );
?>
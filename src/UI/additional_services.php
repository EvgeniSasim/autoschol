<?php 
    $title = $args['zagolovok_sekczii'];
    $btn = $args['knopka_posle_sekczii'];
    $servicesGrup = $args['gruppa_uslug'];
    $idForm = url_to_postid($btn);
?>
<section class="additional-services-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <ul class="btn-list services-section">
            <?php foreach ($servicesGrup as $key => $nameGrup) { ?>
            <li 
                data-name="name-<?php echo $key; ?>" 
                class="btn-list__item <?php if($key === 0) { echo 'active'; } ?>">
                <span><?php echo $nameGrup['nazvanie_gruppy_uslug']; ?></span>
            </li>
            <?php } ?>
        </ul>
        <div class="additional-services-grups">
            <?php foreach ($servicesGrup as $key => $grup) { ?>
            <div class="additional-services-grups__item <?php if($key === 0) { echo 'active'; } ?>">
                <?php foreach ($grup['uslugi'] as $key => $service) {
                        $img = $service['ikonka'];
                ?>
                <div class="additional-services-grups__item__service">
                    <div class="additional-services-grups__item__service__icon">
                        <img 
                            src="<?php echo $img['url']; ?>" 
                            alt="<?php echo $img['alt']; ?>"
                            title="<?php echo $img['title']; ?>"
                            width="<?php echo $img['width']; ?>"
                            height="<?php echo $img['height']; ?>"
                            loading="lazy"
                        >
                    </div>                
                    <div class="additional-services-grups__item__service__descr">
                        <?php echo $service['opisanie_uslugi']; ?>
                        <?php if($service['czena']) { ?>
                        <div class="additional-services-grups__item__service__descr__price">
                            <span><?php echo $service['czena']; ?></span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="additional-services-btn">
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
        tabMenu(".services-section > .btn-list__item",".additional-services-grups__item");
        modal("'. $idForm .'");
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );
?>
<?php 
    $slides = $args['slajdy'];
    $swiper = 'const swiper = new Swiper(".slider-center-wrapper", {
        spaceBetween: 0,
        slidesPerView: 1,
        passiveListeners: true,
        loop: true,
        mousewheel: false,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
        direction: "horizontal",
    });';
add_action( 'wp_init_swiper', 'init_swiper');
do_action('wp_init_swiper', $swiper);
?>
<section class="slider-center-section">
    <div class="container">
        <div class="slider-center-wrapper swiper">
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
            <div class="slider-center-slide-list swiper-wrapper">
                <?php foreach ($slides as $key => $slide) { 
                        $img = $slide['czentralnoe_izobrazhenie'];
                        $leftRows = $slide['krylatye_frazy_left'];
                        $rightRows = $slide['krylatye_frazy_right'];
                ?>
                <div class="slider-center-slide swiper-slide">
                    <div class="slider-center-slide__col left">
                    <?php foreach ($leftRows as $key => $row) { ?>
                        <div class="slider-center-slide__col__row">
                            <div class="slider-cente__content">
                                <span><?php echo $row['fraza']; ?></span>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="slider-center-slide__col picture">
                        <div class="slider-center-slide__col__row">
                            <?php if($img): ?>
                            <img 
                                src="<?php echo $img['url'] ?>" 
                                alt="<?php echo $img['alt'] ?>"
                                title="<?php echo $img['title'] ?>"
                                width="<?php echo $img['width'] ?>"
                                height="<?php echo $img['height'] ?>"
                                loading="lazy"
                            >
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="slider-center-slide__col right">
                        <?php foreach ($rightRows as $key => $row) { ?>
                        <div class="slider-center-slide__col__row">
                            <div class="slider-cente__content">
                                <span><?php echo $row['fraza']; ?></span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
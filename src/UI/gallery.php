<?php 
    $title_section = $args['title_section'];
    $gallerys = $args['gallerys'];
?>
<section class="gallery-section">
    <div class="container">
        <h3><?php echo $title_section; ?></h3>
        <div class="gallery-filteres">
            <ul class="btn-list">
                <?php foreach ($gallerys as $key => $name) { ?>
                <li 
                    data-name="name-<?php echo $key; ?>>" 
                    class="btn-list__item <?php if($key === 0) { echo 'active'; } ?>">
                    <span><?php echo $name['gallery_name']; ?></span>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="gallery-slider">
        <?php foreach ($gallerys as $key => $gallery) { 
            if($gallery['gallery_images']) {
                $lenghtArrGallery = count($gallery['gallery_images']) < 3;
            } else {
                $lenghtArrGallery = false;
            }
        if($lenghtArrGallery) {
            $swiper = 'const swiper_'.$key.' = new Swiper(".gallery-slider-'.$key.'", {
                centeredSlides: true,
                slidesPerView: 1,
                loop: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                scrollbar: {
                    el: ".swiper-scrollbar",
                    draggable: true,
                    dragSize: 38,
                    dragClass: "swiper-scrollbar-drag",
                    snapOnRelease: true,
                },
            });';
        } else {
            $swiper = 'const swiper_'.$key.' = new Swiper(".gallery-slider-'.$key.'", {
                centeredSlides: true,
                loop: true,
                effect: "coverflow",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 0,
                    modifier: 0.5,
                    slideShadows : false,
                    scale: 0.6,
                    opacity: 0.64,
                    },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                scrollbar: {
                    el: ".swiper-scrollbar",
                    draggable: true,
                    dragSize: 38,
                    dragClass: "swiper-scrollbar-drag",
                    snapOnRelease: true,
                },
                breakpoints: {
                    440: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 100,
                    },
                    1270: {
                        slidesPerView: 2,
                        spaceBetween: 200,
                    },
                    1550: {
                        slidesPerView: 3,
                        spaceBetween: 400,
                    },
                }
            });';
        }
        do_action('wp_init_swiper', $swiper);
        ?>
        <div class="gallery-slider-wrapper gallery-slider-<?php echo $key; ?> swiper 
         <?php if($key === 0){ echo 'active';} ?>">
            <div class="container btn" <?php if($lenghtArrGallery) { echo 'style="top:45%"'; } ?>>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="gallery-slider-list swiper-wrapper">
                <?php if($gallery['gallery_images']) {
                    foreach ($gallery['gallery_images'] as $key => $img) { 
                ?>
                <div class="gallery-slider-list__slide swiper-slide">
                    <img 
                        src="<?php echo $img['url']; ?>" 
                        alt="<?php echo $img['alt']; ?>"
                        title="<?php echo $img['title']; ?>"
                        width="<?php echo $img['width']; ?>"
                        height="<?php echo $img['height']; ?>"
                        loading="lazy"
                    >
                </div>
                <?php } } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="container">
    <div class="swiper-scrollbar"></div>
    </div>
</section>
<?php 
    $scripts = '
        tabMenu(".gallery-filteres > .btn-list > .btn-list__item",".gallery-slider-wrapper");
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );
?>
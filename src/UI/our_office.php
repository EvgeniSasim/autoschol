<?php 
    $title = $args['zagolovok'];
    $images = $args['slajdy'];
?>
<section class="our-office-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="simple-slider swiper">
            <div class="simple-slider-wrapper swiper-wrapper">
                <?php foreach($images as $image): 
                    $img = $image['izobrazhenie'];
                    if($img):
                ?>
                <div class="our-office-photo swiper-slide">
                    <img 
                        src="<?php echo $img['url'] ?>" 
                        alt="<?php echo $img['alt'] ?>"
                        title="<?php echo $img['title'] ?>"
                        width="<?php echo $img['width'] ?>"
                        height="<?php echo $img['height'] ?>"
                        loading="lazy"
                    >
                </div>
                <?php   endif; 
                    endforeach; ?>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<?php 
    $swiper = 'const swiperSimpleSlide = new Swiper(".simple-slider", {
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
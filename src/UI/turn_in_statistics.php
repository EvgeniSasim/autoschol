<?php 
    $title =  $args['zagolovok_sekczii'];
    $terms = get_terms( array(
        'taxonomy'    => 'statistics',
        'fields'      => 'id=>name',
        'order'   => 'ASC',
    ) );
    $totalTerms = count($terms);
    $totalInterval = ceil($totalTerms / 5);
    $newTerms = array();
    foreach ($terms as $key => $term) {
        array_push($newTerms, $term);
    }
    add_action('wp_util_script', 'util_script');
    do_action('wp_util_script');
    $swiper = 'const swiper = new Swiper(".slider-results-wrapper", {
                spaceBetween: 24,
                slidesPerView: 1,
                passiveListeners: true,
                loop: false,
                mousewheel: false,
                mousewheelControl: false,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                direction: "horizontal",
                scrollbar: {
                    el: ".swiper-scrollbar",
                    draggable: true,
                    dragSize: 38,
                    dragClass: "swiper-scrollbar-drag",
                    snapOnRelease: false,
                },
                breakpoints: {
                    440: {
                        slidesPerView: 1.5,
                        spaceBetween: 24,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    840: {
                        slidesPerView: 2.5,
                        spaceBetween: 24,
                    },
                    990: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                }
            });';
    add_action( 'wp_init_swiper', 'init_swiper');
    do_action('wp_init_swiper', $swiper);
?>
<section class="turn-in-statistics-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="date-filter-wrapper">
           <ul class="date-filter__list">
            <?php
                $setState=0;
                for($i = 0; $i <= $totalInterval*5; $i+=5) { 
                if($i != $totalInterval*5) {
            ?>
                <li class="date-filter__list__item <?php echo $i == 5 ? 'active' : ''; ?>"
                data-date="<?php
                    for ($v = 0; $v <= 5; $v++) {
                        if($v == 5) {
                            echo $newTerms[$setState++].',';
                            $setState -=1;
                        } else {
                            echo $newTerms[$setState++].',';
                        }
                    }
                ?>">
                <?php }
                    if($i < $totalTerms) { ?>
                    <div class="top-elem-navi-stats"></div>
                    <span><?php echo $newTerms[$i]; ?></span>
                <?php } else { ?>
                    <span class="last-date"><?php echo $newTerms[$totalTerms - 1]; ?></span>
                <?php }
                    if($i !=$totalInterval*5 - 5) {
                ?>
                </li>
            <?php }
                }
            ?>
           </ul>
        </div>
        <div class="slider-results-wrapper swiper">
            <div class="slider-results__slides swiper-wrapper">
                <?php 
                    $statsPosts = query_posts('post_type=stats&statistics=2020,2021,2022');
                    foreach ($statsPosts as $key => $setupSlide) {
                        $values = get_post_meta( $setupSlide->ID);
                ?>
                <div class="slider-results__slides__slide swiper-slide">
                    <div class="slider-results__slides__slide__img">
                        <?php echo $thumb = get_the_post_thumbnail( $setupSlide->ID, 'full' ); ?>
                    </div>
                    <ul class="slider-results__slides__slide__list">
                        <?php 
                            $cards = get_field('kartochka', $setupSlide->ID);
                            foreach ($cards as $key => $card): ?>
                        <li class="slider-results__slides__slide__list__item">
                            <span><?php echo $card['zagolovok'];?>&nbsp;</span>
                            <span><?php echo $card['znachenie'];?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php }
                    wp_reset_postdata();
                    wp_reset_query();
                ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-scrollbar"></div>
        </div>
    </div>
</section>
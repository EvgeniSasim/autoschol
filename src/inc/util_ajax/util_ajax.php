<?php 
    $postDate = $_POST['postDate'];
    $params = 'post_type=stats&statistics='.$postDate;
    $statsPosts = query_posts($params);
    foreach ($statsPosts as $key => $setupSlide) :
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
<?php
    endforeach;
    wp_reset_postdata();
    wp_reset_query();
?>
<?php 
    $reviews = $args['outside_reviews'];
    $quantity_reviews = get_field('quantity_reviews', 'option') ? get_field('quantity_reviews', 'option') : 6;
    add_action('wp_get_reviews_ajax', 'get_reviews_ajax');
    do_action('wp_get_reviews_ajax');
    add_action('wp_get_paginate_ajax', 'get_paginate_ajax');
    do_action('wp_get_paginate_ajax');
?>
 <section class="btn-section">
    <div class="container">
        <ul class="btn-list outside-reviews-btn">
            <?php foreach ($reviews as $key => $review) { ?>
            <li 
                data-value="<?php echo $review['ot_kuda_vyvodim']; ?>" 
                class="btn-list__item <?php if($key === 0) { echo 'active'; $reviews_cat_id = $review['ot_kuda_vyvodim']; } ?>">
                <span><?php echo $review['name']; ?></span></li>
            <?php } ?>
        </ul>
    </div>
</section>
<section class="count-outside-reviews-section">
    <div class="container">
        <?php foreach ($reviews as $key => $review) {
            $post_id = "category_".$review['ot_kuda_vyvodim']."";
            $logo = get_field('izobrazhenie', $post_id);
            $sum = get_category($review['ot_kuda_vyvodim'])->category_count;
        ?>
        <div class="count-outside-reviews__tab <?php if($key === 0) { echo 'active';} ?>">
            <div class="count-outside-reviews">
                <div class="count-outside-reviews__resalt">
                    <?php if($logo) { ?>
                    <img 
                        src="<?php echo $logo['url']; ?>" 
                        alt="<?php echo $logo['alt']; ?>"
                        title="<?php echo $logo['title']; ?>"
                        width="<?php echo $logo['width']; ?>"
                        height="<?php echo $logo['height']; ?>"
                        loading="lazy"
                    >
                    <span>рейтинг <?php } else { echo '<span>'; echo $review['name']; }?>
                        <?php echo ' - '; do_action( 'wp_num_decline', $sum, 'отзыв, отзыва, отзывов'); ?>
                    </span>
                </div>
                <?php if($logo) { ?>
                <div class="count-outside-reviews__rank">
                    <span>
                        <?php 
                            $review_index = get_posts( array(
                                'numberposts' => -1,
                                'category'    => $post_id,
                                'post_type'   => 'socials',
                            ) );
                             $allRank = array();
                             foreach ($review_index as $index => $item) {
                                 $rank = $item->oczenka;
                                 array_push($allRank, $rank);
                             }
                             $countRank = count($allRank) === 0 ? 1 : count($allRank);
                             $meanRank = count($allRank) === 0 ? 5 : round(array_sum($allRank) / $countRank);
                             echo $meanRank .'.0';
                        ?>
                    </span>
                    <ul class="rank">
                        <?php 
                            for ($i=0; $i < 5; $i++) { ?>
                            <?php if($i < $meanRank) { ?>
                            <li class="rank__star-bg"></li>
                        <?php } else { ?>
                            <li class="rank__star"></li>
                        <?php }
                            } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <?php  if($review['dobavit_vsplyvayushhuyu_formu'] === 'true') {
                        $link_btn = $review['ssylka_na_knopke'];
            ?>
            <div class="count-outside-reviews__add-reviews">
                <button class="primary-btn btn-outside-review-<?php echo $key; ?>"><?php echo $link_btn['title']; ?></button>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</section>
<?php
    $currentPage = 1;
    $wp_query = new WP_Query(array(
        "posts_per_page" => $quantity_reviews,
        "paged"          => $currentPage,
        "post_type"      => "socials",
        "cat"            => 76,
        'order'          => 'DESC',
        'orderby' => 'outside_reviews',
        'meta_query' => [
            'outside_reviews' => [
                'key'     => 'data_otzyva',
            ],
        ]
    ));
?>
<section class="outside-reviews-section">
    <div class="container">
        <div class="outside-reviews">
            <?php
            foreach ($wp_query->posts as $key => $rev) { 
                $url = get_field('ssylka_na_istochnik_otzyva', $rev->ID);
                $ava = get_field('avatar_avtora', $rev->ID);
                $tegA = false;
                if($url) {
                    $tegA = '<a href="'.$url['url'].'" target="'.$url['target'].'"';
                }
            ?>
            <?php if($tegA) { echo $tegA; } else { ?> 
                <div <?php } ?> 
                    class="outside-reviews__item">
                <div class="outside-reviews__item__head">
                    <div class="outside-reviews__item__head__ava" 
                        <?php if(!$ava) {
                            $color = sprintf("#%06x",rand(0,16777215));
                           echo 'style="background-color: '. $color .'"';
                        } ?>>
                        <?php if($ava) { ?>
                            <img 
                                src="<?php echo $ava['url']; ?>" 
                                alt="<?php echo $ava['alt']; ?>"
                                title="<?php echo $ava['title']; ?>"
                                width="<?php echo $ava['width']; ?>"
                                height="<?php echo $ava['height']; ?>"
                                loading="lazy"
                            >
                        <?php } else { 
                            $name_code = mb_detect_encoding($rev->imya_avtora_otzyvy, ['ASCII', 'UTF-8'], false);
                            if($name_code === 'UTF-8') {
                                $short_name = mb_substr($rev->imya_avtora_otzyvy,0,1,$name_code);
                            } else { $short_name = $rev->imya_avtora_otzyvy[0]; }
                            echo '<span>'. $short_name .'</span>'; } ?>
                    </div>
                    <div class="outside-reviews__item__head__title">
                        <h5><?php echo $rev->imya_avtora_otzyvy; ?></h5>
                        <span><?php echo get_field('data_otzyva', $rev->ID); ?></span>
                    </div>
                </div>
                <div class="outside-reviews__item__rank">
                    <ul class="rank">
                        <?php 
                            for ($i=0; $i < 5; $i++) { ?>
                            <?php if($i < $rev->oczenka) { ?>
                            <li class="rank__star-bg"></li>
                        <?php } else { ?>
                            <li class="rank__star"></li>
                        <?php }
                            } ?>
                    </ul>
                </div>
                <?php 
                    $lenght_str_reviews = strip_tags(get_field('tekst_otzyva', $rev->ID), '<p>');
                    if(strlen($lenght_str_reviews) > 200) { 
                        $add_selector = 'read__more';
                        $btn_read_more = '<div class="read-more-container"><button class="read-more">Показать все</button></div>'; 
                        } else { $btn_read_more = ''; $add_selector = '';} ?>
                <div class="outside-reviews__item__descr <?php echo $add_selector; ?>">
                    <?php echo '<div>'.$lenght_str_reviews.'</div>';
                          echo $btn_read_more;
                    ?>
                </div>
                <?php 
                    $id_cat = get_the_category( $rev->ID );
                    $post_id = "category_".$id_cat[0]->term_id."";
                    $logo = get_field('izobrazhenie', $post_id);
                     if($logo) {
                ?>
                <div class="outside-reviews__item__logo">
                    <img 
                        src="<?php echo $logo['url']; ?>" 
                        alt="<?php echo $logo['alt']; ?>"
                        title="<?php echo $logo['title']; ?>"
                        width="<?php echo $logo['width']; ?>"
                        height="<?php echo $logo['height']; ?>"
                        loading="lazy"
                    >
                </div>
                <?php } ?>
            <?php if($tegA) { ?></a> <?php } else { ?></div> <?php }
             wp_reset_postdata();
        } ?>
        </div>
    </div>
</section>
<section class="pagination-section">
    <div class="container">
        <div class="testimonials-pagination">
            <?php
               echo paginate_ajax($wp_query, $currentPage);
            ?>
        </div>
    </div>
</section>
<?php 
    $modalJs='';
     foreach ($reviews as $key => $review) {
        if($review['dobavit_vsplyvayushhuyu_formu'] === 'true') { 
            $modalJs.='modal("outside-review-'. $key .'");'.'';
        }
     }
    $scripts = '
        readMore();
        tabMenu(".btn-list.outside-reviews-btn > .btn-list__item",".count-outside-reviews__tab"); '. $modalJs .'
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );
        foreach ($reviews as $key => $review) {
            $title = $review['zagolovok_formy'];
            $img = $review['kartinka_formy'];
            $descr = $review['opisanie_formy'];
            $link = $review['ssylka_na_knopke'];
            if($review['dobavit_vsplyvayushhuyu_formu'] === 'true') {
                echo '
                    <section class="modal-window outside-review" id="outside-review-'.$key.'-modal">
                        <div class="container">
                            <div class="modal-wrapper">
                                <span class="close-modal"></span>
                                <h3>'. $title .'</h3>
                                <div class="outside-reviews-content">
                                    <div class="outside-reviews-img">
                                        <img 
                                            src="'.$img["url"].'" 
                                            alt="'.$img["alt"].'"
                                            title="'.$img["title"].'"
                                            width="'.$img["width"].'"
                                            height="'.$img["height"].'"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="outside-reviews-description">
                                        '. $descr .'
                                    </div>
                                </div>
                                <div class="outside-reviews-btn">
                                    <a href="'.$link['url'].'" target="'.$link['target'].'" class="primary-btn">'. $link['title'] .'</a>
                                </div>
                            </div>
                        </div>
                    </section>
                ';
            }
        }
?>
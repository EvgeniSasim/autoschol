<?php 
    $catIndex = $_POST['catIndex'];
    $quantity_reviews = get_field('quantity_reviews', 'option') ? get_field('quantity_reviews', 'option') : 6;
    if($_POST['currentPage']) {
        $currentPage = str_replace('/', '', $_POST['currentPage']);
    } else {
        $currentPage = 1;
    }
    global $wp_query;
    if ($catIndex !== "79") {
        $sort = [
            'outside_reviews' => [
                'key'     => 'data_otzyva',
            ],
        ];
    } else {
        $sort = '';
    }
    $wp_query = new WP_Query(array(
        "post_type"      => "socials",
        "cat"            => $catIndex,
        "posts_per_page" => $quantity_reviews,
        "paged"          => $currentPage,
        'order'          => 'DESC',
        'orderby' => 'outside_reviews',
        'meta_query' => $sort
    ));
    if ($catIndex !== "79") {
    echo ''.paginate_ajax($wp_query, $currentPage).'***';
    foreach ($wp_query->posts as $key => $review) : ?>
            <?php
                $url = get_field('ssylka_na_istochnik_otzyva', $review->ID);
                $ava = get_field('avatar_avtora', $review->ID);
                    if($url) {
                        $tegA = '<a href="'.$url['url'].'" target="'.$url['target'].'"';
                    }
            ?>
<?php if($tegA) { echo $tegA; } else { ?> <div <?php } ?>
        class="outside-reviews__item">
        <div class="outside-reviews__item__head">
            <?php if($review->vyberete_istochnik_otzyvy !== 'video') { ?>
            <div class="outside-reviews__item__head__ava"
            <?php if(!$ava) {
                            $color = sprintf("#%06x",rand(0,16777215));
                           echo 'style="background-color: '. $color .'"';
                        } ?>>
                <?php 
                    if($ava) {         
                ?>
                    <img 
                        src="<?php echo $ava['url']; ?>" 
                        alt="<?php echo $ava['alt']; ?>"
                        title="<?php echo $ava['title']; ?>"
                        width="<?php echo $ava['width']; ?>"
                        height="<?php echo $ava['height']; ?>"
                        loading="lazy"
                    >
                    <?php } else { 
                            $name_code = mb_detect_encoding($review->imya_avtora_otzyvy, ['ASCII', 'UTF-8'], false);
                            if($name_code === 'UTF-8') {
                                $short_name = mb_substr($review->imya_avtora_otzyvy,0,1,$name_code);
                            } else { $short_name = $review->imya_avtora_otzyvy[0]; }
                            echo '<span>'. $short_name .'</span>'; } ?>
            </div>
            <?php } ?>
            <div class="outside-reviews__item__head__title <?php if($review->vyberete_istochnik_otzyvy === 'video') { echo 'video'; }?>">
                <h5><?php echo $review->imya_avtora_otzyvy; ?></h5>
                <span><?php echo get_field('data_otzyva', $review->ID); ?></span>
            </div>
        </div>
        <?php if($review->vyberete_istochnik_otzyvy !== 'video') { ?>
        <div class="outside-reviews__item__rank">
            <ul class="rank">
                <?php 
                    for ($i=0; $i < 5; $i++) { ?>
                    <?php if($i < $review->oczenka) { ?>
                    <li class="rank__star-bg"></li>
                <?php } else { ?>
                    <li class="rank__star"></li>
                <?php }
                    } ?>
            </ul>
        </div>
        <?php } 
            $lenght_str_reviews = strip_tags(get_field('tekst_otzyva', $review->ID), '<p>');
            if(strlen($lenght_str_reviews) > 200) { 
                $btn_read_more = '<div class="read-more-container"><button class="read-more">Показать все</button></div>'; 
                } else { $btn_read_more = '';} 
        ?>
        <div class="outside-reviews__item__descr">
            <?php echo '<div>'.$lenght_str_reviews.'</div>';
                  echo $btn_read_more;
            ?>
        </div>
        <?php if($review->vyberete_istochnik_otzyvy !== 'video') { ?>
        <?php 
            $id_cat = get_the_category( $review->ID );
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
        <?php } ?>
        <?php if($review->vyberete_istochnik_otzyvy === 'video') { ?>
            <div class="outside-reviews__item__video">
                <iframe
                        width="100%"
                        height="175px" 
                        src="<?php echo $review->ssylka_na_video; ?>" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
        <?php } ?>
        <?php if($tegA) { ?></a> <?php } else { ?></div> <?php } 
        wp_reset_postdata();
    endforeach;
    } else {
        foreach ($wp_query->posts as $key => $review) { ?>
            <div class="outside-reviews__item-soc">
                <div class="outside-reviews__item-soc__head">
                    <div class="outside-reviews__item-soc__head__logo">
                        <?php 
                            $ava = get_field('logotip_socz_seti', $review->ID);
                            if($ava) {         
                        ?>
                            <img 
                                src="<?php echo $ava['url']; ?>" 
                                alt="<?php echo $ava['alt']; ?>"
                                title="<?php echo $ava['title']; ?>"
                                width="<?php echo $ava['width']; ?>"
                                height="<?php echo $ava['height']; ?>"
                                loading="lazy"
                            >
                        <?php } ?>
                    </div>
                    <div class="outside-reviews__item-soc__head__title">
                        <h5><?php echo $review->nazvanie_socz_seti; ?></h5>
                    </div>
                </div>
                <div class="outside-reviews__item-soc__descr">
                    <div class="outside-reviews__item-soc__descr__logo">
                        <?php 
                            $ava = get_field('logo_gruppy', $review->ID);
                            if($ava) {         
                        ?>
                            <img 
                                src="<?php echo $ava['url']; ?>" 
                                alt="<?php echo $ava['alt']; ?>"
                                title="<?php echo $ava['title']; ?>"
                                width="<?php echo $ava['width']; ?>"
                                height="<?php echo $ava['height']; ?>"
                                loading="lazy"
                            >
                        <?php } ?>
                    </div>
                    <div class="outside-reviews__item-soc__descr__descr">
                        <span><?php echo get_field('nazvanie_gruppy', $review->ID); ?></span>
                        <span><?php echo get_field('kolichestvo_podpischikov', $review->ID); ?></span>
                    </div>
                </div>
                <div class="outside-reviews__item-soc__btn">
                    <?php 
                        $link = get_field('ssylka_na_socz_gruppu', $review->ID);
                    ?>
                    <a href="<?php echo $link['url']; ?>" class="primary-btn" target="<?php echo $link['target']; ?>">
                        <?php echo $link['title']; ?>
                    </a>
                </div>
            </div>
<?php 
    wp_reset_postdata();
        }
    }
?>
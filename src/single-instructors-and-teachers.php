<?php 
/****
 Template Name: Инструкторы и преподаватели
 Template Post Type: instructors
****/
get_header(); ?>
<?php 
    $slug = get_field('prinadlezhnost_k_otzyvam')->slug ?: '_';
    $testimonials = get_posts( array(
        'post_type'      => 'testimonials',
        'post_status'    => 'publish',
        'tag'            =>  $slug,
        ) 
    );
    $allRank = array();
    $sum = count($testimonials);
    foreach ($testimonials as $key => $testimonial) {
        $rank = $testimonial->oczenka;
        array_push($allRank, $rank);
    }
    $countRank = count($allRank) === 0 ? 1 : count($allRank);
    $meanRank = count($allRank) === 0 ? 5 : round(array_sum($allRank) / $countRank);
    $query = new WP_Query( array(
        'post_type'      => 'testimonials',
        'posts_per_page' => 5,
        'paged'          => get_query_var( 'page' ),
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tag'            =>  $slug,
        ) 
    );
    $testimonials = $query->posts;
?>
    <main <?php body_class('main'); ?>>
        <div class="breadcrumbs-section">
            <div class="container">
                <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs-page">','</p>' );
                    }
                ?>
            </div>
        </div>
        <section class="instructors-head-section">
            <div class="container">
                <div class="instructors-wrapper">
                    <div class="instructors-photo">
                        <?php echo $thumb = get_the_post_thumbnail(null, 'full' );?>
                    </div>
                    <div class="instructors-contents">
                        <ul class="instructors-contents__rank">
                            <?php 
                                for ($i=0; $i < 5; $i++) { ?>
                                <?php if($i < $meanRank) { ?>
                                <li class="instructors-contents__rank__star-bg"></li>
                            <?php } else { ?>
                                <li class="instructors-contents__rank__star"></li>
                            <?php }
                                } ?>
                        </ul>
                        <div class="instructors-contents__title">
                            <span>
                                <?php $teachName = get_field('instructors_or_teachers')[0]['label'];
                                    echo $teachName; 
                                ?>
                            </span>
                            <?php the_title( '<h1>', '</h1>' ); ?>
                            <div class="instructors-contents__btn">
                                <button class="primary-btn <?php 
                                    $madalOptions = get_field('id_popup_testimonial', 'option');
                                    $idCF7 = url_to_postid($madalOptions['id_kontaktnoj_formy']);
                                    echo "btn-" .$idCF7;?>">
                                    <?php echo $madalOptions['tekst_knopki'] ?>
                                </button>
                            </div>
                        </div>
                        <div class="instructors-contents__descr">
                            <?php the_content() ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="testimonials-section">
            <div class="container">
                <div class="count-testimonials">
                    <span><?php 
                        do_action( 'wp_num_decline', $sum, 'отзыв, отзыва, отзывов');
                    ?></span>
                </div>
                <div class="testimonials-list">
                    <?php 
                        foreach ($testimonials as $key => $testimonial) {
                           $date = $testimonial->post_date;
                           $content = $testimonial->post_content;
                           $title = $testimonial->post_title;
                           $rank = $testimonial->oczenka;
                           $authorName = $testimonial->fio_avtora_otzyva;
                    ?>
                    <div class="testimonials-list__item">
                        <ul class="testimonials-list__item__rank">
                            <?php for ($i=0; $i < 5; $i++) { ?>
                                <?php if($i < $rank) { ?>
                                <li class="testimonials-list__item__rank__star-bg"></li>
                            <?php } else { ?>
                                <li class="testimonials-list__item__rank__star"></li>
                           <?php }
                            } ?>
                        </ul>
                        <h4><?php echo $authorName; ?></h4>
                        <div class="testimonials-list__item__content">
                            <p><?php echo $content; ?></p>
                        </div>
                        <div class="testimonials-list__item__date">
                            <span><?php
                                do_action( 'wp_format_date', $date);
                            ?></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <section class="pagination-section">
            <div class="container">
                <div class="testimonials-pagination">
                    <?php
                        echo paginate_links( [
                            'base'    => user_trailingslashit( wp_normalize_path( get_permalink() .'/%#%/' ) ),
                            'current' => max( 1, get_query_var( 'page' ) ),
                            'total'   => $query->max_num_pages,
                            'format' => '',
                            'prev_text'    => __(''),
                            'next_text'    => __(''),
                        ] );
                    ?>
                    </div>
                </div>
        </section>
        <?php
            if( have_rows('construct') ):
                $layouts = get_field('construct');
                foreach ($layouts as $layout):
                    $acfLayoutName = $layout['acf_fc_layout'];
                    get_template_part("/UI/$acfLayoutName", null, $layout );
                endforeach;
            endif;
        ?>
        <?php require get_template_directory() . '/UI/popup_testimonial.php'; ?>
    <?php get_footer(); ?>
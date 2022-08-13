<?php 
    $catId = $_POST['catId'];
    $sortAttr = $_POST['sortAttr'];

    $arg = array(
        'category_name'      => 'blog',
        "posts_per_page" => 6,
    );

    $arg = empty($catId) ? $arg : array_merge($arg, array('tag__in' => explode(",", $catId),)); 
    $arg = empty($sortAttr) ? $arg : array_merge($arg, array(
        'order'      => 'DESC',
        'meta_key'   => 'views',
        'orderby'    => 'meta_value_num',
        'order'      => 'DESC',
        'meta_query' => [
            [
                'key'     => 'views',
            ]
        ]
    )); 

    $posts_blog = new WP_Query($arg);

    foreach ($posts_blog->posts as $key => $post_blog) { ?>
    <a href="<?php the_permalink($post_blog->ID); ?>" title="<?php the_title_attribute($post_blog->ID); ?>" class="promotions-list__item">
        <div class="promotions-list__item__img">
            <?php echo $thumb = get_the_post_thumbnail( $post_blog->ID, 'full' ); ?>
            <div class="filter-name-list">
            <?php if( $post_tags = wp_get_post_tags( $post_blog->ID ) ) {
                    foreach ( $post_tags as $post_tag ) {
                        $color = get_term_meta( $post_tag->term_id, 'color', true ) ? get_term_meta( $post_tag->term_id, 'color', true ) : '#be1ddb';
                        echo '<span style="background-color: '.$color.'">'.$post_tag->name.'</span>';
                    }
                } ?>
            </div>
        </div>
        <div class="promotions-list__item__descr">
            <div class="blog-post-attr">
                <span class="author-name">
                    <?php the_author(); ?>
                </span>
                <span class="views-umber">
                    <?php echo get_post_meta( $post_blog->ID, 'views', true ); ?>
                </span>
            </div>
            <h4><?php echo $post_title = get_the_title( $post_blog->ID ); ?></h4>
            <div class="promotions-list__item__descr__excerpt">
                <p><?php
                    if( get_the_excerpt($post_blog->ID) ) {
                        $excerpt = get_the_excerpt($post_blog->ID);
                    } else {
                        $excerpt = strip_tags($post_blog->post_content);
                    }
                    add_action( 'wp_cutText', 'cutText', 10, 2 );
                    do_action( 'wp_cutText', $excerpt, 90);
                    ?>
                </p>
            </div>
        </div>
    </a>
<?php } 
    wp_reset_postdata();
?>
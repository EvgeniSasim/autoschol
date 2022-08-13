<?php 
$title = $args['title'];
$posts_id = $args['posts'];
$tag_ids = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
if(empty($posts_id)) {
	$arg = array(
                    'category_name'      => 'blog',
                    "posts_per_page" => 2,
					"tag__in" => $tag_ids,
					'post__not_in' => [$post->ID],
                );
}
if(!empty($posts_id)) { 
	$arg = array(
                    'post_type' => array( 'post', 'promotions' ),
					"posts_per_page" => 2,
					'orderby' => 'date', 
					'order' => 'DESC',
					'post__in' => $posts_id,
                );
}
if(empty($posts_id) && count($tag_ids) === 0) { 
	$arg = array(
                    'category_name'      => 'blog',
                    "posts_per_page" => 2,
					'orderby' => 'date', 
					'order' => 'DESC',
                );
}
?>
<section class="last-post-section promotions-section blog-posts">
    <div class="container">
        <?php if($title) { echo '<h3>'.$title.'</h3>'; } ?>
        <div class="promotions-list">
            <?php 
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
        </div>
    </div>
</section>
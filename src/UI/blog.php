<?php 
     add_action('wp_get_blogPostSortData_ajax', 'get_blogPostSortData_ajax');
     do_action('wp_get_blogPostSortData_ajax');
?>
<section class="promotions-section blog-posts">
    <div class="container">
        <div class="blog-filters-wrapper">
            <div class="blog-filters">
                <div class="blog-filters__sort-list">
                    <button data-sort="new">Новое</button>
                    <button data-sort="popular">Популярное</button>
                </div>
                <div class="blog-filters__dropdown"><button>Фильтр</button></div>
            </div>
            <div class="dropdown-filter">
                <div class="dropdown-filter__list">
                <?php
                    $getcat = get_the_category();
					if($getcat) {
						if($getcat[0]){
                        $cat_id=$getcat[0]->term_id;
                    }
                    query_posts('cat='.$cat_id.'&posts_per_page=-1');
                    if(have_posts()): 
                        while (have_posts()) : the_post();
                            $all_tag_objects = get_the_tags();
                            if($all_tag_objects){
                                foreach($all_tag_objects as $tag) {
                                    if($tag->count > 0) {$all_tag_ids[] = $tag -> term_id;}
                                }
                            }
                        endwhile;
                    endif;
                    $tag_ids_unique = array_unique($all_tag_ids);
					if(!empty($tag_ids_unique)) {
                    foreach($tag_ids_unique as $tag_id) {
                        $post_tag = get_term( $tag_id, 'post_tag' );
                        $color = get_term_meta( $post_tag->term_id, 'color', true ) ? get_term_meta( $post_tag->term_id, 'color', true ) : '#be1ddb';
                    echo '<button data-tag-color='.$color.' data-tag-id='.$tag_id.'>'.$post_tag->name.'</button>';
                    }
						} 
					}
                 ?>
                </div>
            </div>
        </div>
        <div class="promotions-list">
        <?php 
            $posts_blog = new WP_Query(array(
                'category_name'      => 'blog',
                "posts_per_page" => 6,         
            ));
			if(!empty($posts_blog)) {
            foreach ($posts_blog->posts as $key => $post_blog) { 
			if($post_blog) {
			?>
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
        <?php } } }
            wp_reset_postdata();
        ?>
        </div>
    </div>
</section>
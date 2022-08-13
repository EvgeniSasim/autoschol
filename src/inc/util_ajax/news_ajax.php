<?php 
    $_POST = $args;
    $cat = $_POST['category'];
    $linlText = $_POST['linlText'];
    $paged = $_POST['paged'];
    $maxPaged = $_POST['maxPaged'];
    $paged++ ;
    function cutText($excerpt) {
        if (strlen($excerpt) > 50) {
            $excerpt = substr($excerpt, 0, 60);
            $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
            $excerpt .= '...';
        }
        echo $excerpt;
    }
?>
    <?php
        $params = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $paged,
            'cat'  => $cat,
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $recent_posts_array = query_posts( $params );
        foreach( $recent_posts_array as $recent_post_single ) :
        setup_postdata( $recent_post_single );
    ?>
        <div class="news-list__item">
            <div class="news-list__item__img">
                <a href="<?php the_permalink($thumb_id)?>">
                    <?php
                        $thumb_id = $recent_post_single->ID;
                        $thumb_url = get_the_post_thumbnail_url($thumb_id,'thumbnail-size', true);
                    ?>
                    <img src="<?php echo $thumb_url ? $thumb_url : bloginfo( 'template_url' ).'/img/news_img.webp'; ?>" alt="">
                </a>
            </div>
            <div class="news-list__item__contents">
                <div class="news-list__item__contents__title">
                    <a href="<?php the_permalink($thumb_id)?>">
                        <h4>
                        <?php 
                            $excerpt = strip_tags($recent_post_single->post_title);
                            cutText($excerpt);
                            ?>
                        </h4>
                    </a>
                </div>
                <div class="news-list__item__contents__descr">
                    <a href="<?php the_permalink($thumb_id)?>">
                        <?php
                            $excerpt = strip_tags($recent_post_single->post_content);
                            cutText($excerpt);
                        ?>
                    </a>
                </div>
                <div class="news-list__item__contents__link">
                    <a href="<?php the_permalink($thumb_id)?>">
                        <span><?php echo $linlText; ?></span> 
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php
        endforeach;
        wp_reset_postdata();
    ?>
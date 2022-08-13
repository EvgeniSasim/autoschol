<section class="promotions-section">
    <div class="container">
        <div class="promotions-list">
        <?php 
            $promotions = new WP_Query(array(
                'post_type'      => 'promotions',
                "posts_per_page" => 6,             
            ));
            foreach ($promotions->posts as $key => $promotion) {
                $values = get_post_meta( $promotion->ID);
                $end_date = strtotime(get_field('data_okonchaniya_akczii', $promotion->ID));
                $start_date = strtotime(get_field('data_nachala', $promotion->ID));
                $now_date = strtotime(date('Y-m-d'));
                if($end_date < $now_date) {
                    continue;
                }
        ?>
            <a href="<?php the_permalink($promotion->ID); ?>" title="<?php the_title_attribute($promotion->ID); ?>" class="promotions-list__item">
                <div class="promotions-list__item__img">
                    <?php echo $thumb = get_the_post_thumbnail( $promotion->ID, 'full' ); ?>
                </div>
                <div class="promotions-list__item__descr">
                    <h4><?php echo $post_title = get_the_title( $promotion->ID ); ?></h4>
                    <div class="promotions-list__item__descr__excerpt">
                        <p><?php
                            if( get_the_excerpt($promotion->ID) ) {
                                $excerpt = get_the_excerpt($promotion->ID);
                            } else {
                                $excerpt = strip_tags($promotion->post_content);
                            }
                            add_action( 'wp_cutText', 'cutText', 10, 2 );
                            do_action( 'wp_cutText', $excerpt, 90);
                            ?>
                        </p>
                    </div>
                    <div class="promotions-list__item__descr__date">
                        <span class="promotions-list__item__descr__date__title">
                        <?php the_field('srok_dejstviya', $promotion->ID); ?>
                        </span>
                        <span class="promotions-list__item__descr__date__date">
                            <?php the_field('data_nachala', $promotion->ID);
                            if(get_field('data_okonchaniya_akczii', $promotion->ID)) {
                                echo ' '.'-'.' ';
                                the_field('data_okonchaniya_akczii', $promotion->ID); 
                            } ?>
                        </span>
                    </div>
                </div>
            </a>
        <?php } 
            wp_reset_postdata();
        ?>
        </div>
    </div>
</section>
<?php 
    $id = $args['id'];
    $teachers = get_posts( array(
        'post_type'      => 'instructors',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'	 => array(
            'relation'		=> 'OR',
            array(
                'key'		=> 'instructors_or_teachers',
                'value'		=> 'inst',
                'compare'	=> 'LIKE'
            ),
            array(
                'key'		=> 'instructors_or_teachers',
                'value'		=> 'teach',
                'compare'	=> 'LIKE'
            )
        )
        )
    );
?>
 <section class="btn-section">
    <div class="container">
        <ul class="btn-list"> 
            <li data-value="teach" class="btn-list__item active"><span>Преподаватели</span></li>
            <li data-value="inst" class="btn-list__item"><span>Инстуктора</span></li>
        </ul>
        <div class="filteres teach">
            <div class="data-select">
                <select name="name" id="select-rank">
                    <option value="" disabled selected hidden>По рейтингу</option>
                    <option value="ABC">С наивысшим рейтингом</option>
                    <option value="ZWX">С наименьшим рейтингом</option>
                </select>
                <span></span>
            </div>
            <div class="data-select">
                <select name="name" id="select-cat">
                    <option value="" disabled selected hidden>Выберите категорию прав</option>
                    <option value="A">Категория А</option>
                    <option value="B">Категория Б</option>
                </select>
                <span></span>
            </div>
        </div>
    </div>
</section>
<section class="instructors-and-teachers">
    <div class="container">
        <div class="instructors-and-teachers__wrapper">
            <div class="instructors-and-teachers__list">
                <?php foreach ($teachers as $key => $teacher) { 
                    $position = get_field('prinadlezhnost_k_otzyvam', $teacher->ID)->slug;
                    $arrRank = [];
                    $ranks = get_posts( array(
                        'post_type'      => 'testimonials',
                        'tag'            => $position,
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'meta_key'       => 'oczenka', 
                        'meta_value_num' => '0',
                        'meta_compare'   => '>',
                        )
                    );
                    foreach ($ranks as $key => $rank) {
                        array_push($arrRank, $rank->oczenka);
                    }
                    $length = count($arrRank);
                    $meanRank = round(array_sum($arrRank) / ($length === 0 ? 1 : count($arrRank)));
                    $s = $meanRank == 0 ? 5 : $meanRank;
                ?>
                <div 
                    class="instructors-and-teachers__list__item <?php 
                    if(array_search('teach',$teacher->instructors_or_teachers) !== false) { 
                        echo 'active'; 
                    } ?>" 
                    data-value="<?php 
                        foreach ($teacher->instructors_or_teachers as $key => $value) {
                            if($key !== 0) {
                                echo ' '.$value;
                            } else echo $value;
                        }
                ?>"
                    data-rank="<?php echo $s; ?>"
                    data-cat="<?php 
                        foreach ($teacher->kategoriya_prav as $key => $value) {
                           echo $value;
                        }
                ?>">
                    <a href="<?php the_permalink($teacher->ID); ?>" title="<?php the_title_attribute($teacher->ID); ?>">
                        <div class="header">
                            <div class="header__img">
                                    <?php echo $thumb = get_the_post_thumbnail($teacher->ID, 'full' );?>
                            </div>
                            <div class="header__title">
                                <h4>
                                    <?php echo $teacher->post_title; ?>
                                </h4>
                                <span>
                                    <?php do_action( 'wp_num_decline', $length, 'отзыв, отзыва, отзывов'); ?>
                                </span>
                            </div>
                        </div>
                        <ul class="rank">
                                <?php 
                                    for ($i=0; $i < 5; $i++) { ?>
                                    <?php if($i < $s) { ?>
                                    <li class="rank__star-bg"></li>
                                <?php } else { ?>
                                    <li class="rank__star"></li>
                                <?php }
                                    } ?>
                        </ul>
                        <div class="description">
                            <p><?php do_action( 'wp_cutText', $teacher->post_content, 120); ?></p>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php 
    $scripts = '
        filterTeachers();
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );
?>
<?php get_header(); ?>
    <main class="main top_bg blog">
        <div class="breadcrumbs-section">
            <div class="container">
                <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs-page">','</p>' );
                    }
                ?>
            </div>
        </div>
        <section class="title-section">
            <div class="container">
                <?php echo '<h1>'. get_the_title() .'</h1>'; ?>
            </div>
        </section>
        <div class="simple-img-half-bg blog-top-img">
            <div class="container">
                <div class="img-wrapper">
                    <?php 
                       the_post_thumbnail(get_post_thumbnail_id(),);
                    ?>
                </div>
            </div>
        </div>
        <?php if( get_the_content() ){ ?>
        <div class="content-page-section">
            <div class="container">
                <?php the_content(); ?>
            </div>
        </div>
        <?php } 
            if( have_rows('gibkoe_soderzhimoe_construct') ):
                $layouts = get_field('gibkoe_soderzhimoe_construct');
                foreach ($layouts as $layout):
                    $acfLayoutName = $layout['acf_fc_layout'];
                    get_template_part("/UI/$acfLayoutName", null, $layout );
                endforeach;
            endif;
        ?>
        <div class="post-footer">
            <div class="container">
                <div class="blog-post-attr">
                    <span class="author-name">
                        <?php the_author(); ?>
                    </span>
                    <div class="social-list">
                        <?php
                            $socials = get_field('dobavit_soczialnye_seti', 'option');
                            foreach ($socials as $key => $soc) {
                                $socName = $soc['vybrat_soczialnuyu_set'];
                                $socUrl = $soc['ukazhite_url'];
                        ?>
                            <!-- <a href="<?php echo $socUrl['url']; ?>" target="<?php echo $socUrl['target'] ?>">
                                <i class="fa fa-<?php echo $socName['value']; ?>" aria-hidden="true"></i>
                            </a> -->
                        <?php } ?>
                    </div>
                    <span class="post-date">
                        <?php echo get_the_date (); ?>
                    </span>
                </div>
            </div>
        </div>
<?php get_footer(); ?>
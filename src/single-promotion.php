<?php 
/****
 Template Name: Акции
 Template Post Type: promotions
****/
get_header(); ?>
    <main class="main">
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
                <?php the_title( '<h1>', '</h1>' ); ?>
            </div>
        </section>
        <?php if( get_the_content() ){ ?>
        <section class="content-promotions-section">
            <div class="container">
                <div class="content-promotions-wrapper">
                    <?php echo $thumb = get_the_post_thumbnail(null, 'full' ); ?>
                    <div class="content-promotions">
                        <?php the_content() ?>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>
        <?php if( get_field('dopolnitelnyj_kontent') ){ ?>
        <section class="content-promotions-section">
            <div class="container">
                <?php the_field('dopolnitelnyj_kontent'); ?>
            </div>
        </section>
        <?php } ?>
        <?php
            if( have_rows('construct') ):
                $layouts = get_field('construct');
                foreach ($layouts as $layout):
                    $acfLayoutName = $layout['acf_fc_layout'];
                    get_template_part("/UI/$acfLayoutName", null, $layout );
                endforeach;
            endif;
        ?>
<?php get_footer(); ?>
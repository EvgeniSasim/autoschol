<?php 
/****
 Template Name:Flexible_template
****/
get_header(); ?>
    <?php $top_bg = get_field('add_color_bg') === 'true' ? 'main top_bg' : 'main'; ?>
    <main <?php body_class($top_bg); ?> id="post-<?php the_ID(); ?>">
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
                <?php if(get_field('sub_title')) { ?>
                    <div class="title-section__subtitle">
                        <span><?php echo get_field('sub_title'); ?></span>
                    </div>
                <?php } ?>
            </div>
        </section>
        <?php if(get_the_content()): ?>
        <section class="content-page-section">
            <div class="container">
               <?php the_content() ?>
            </div>
        </section>
        <?php endif; ?>
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
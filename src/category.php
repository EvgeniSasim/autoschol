<?php get_header();?>
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
    <section class="title-section">
        <div class="container">
            <h1><?php single_cat_title(); ?></h1>
        </div>
    </section>
    <?php
        $term = get_queried_object();
        if( have_rows('construct', $term) ):
            $layouts = get_field('construct', $term);
            foreach ($layouts as $layout):
                $acfLayoutName = $layout['acf_fc_layout'];
                get_template_part("/UI/$acfLayoutName", null, $layout );
            endforeach;
        endif;
    ?>
<?php get_footer(); ?>
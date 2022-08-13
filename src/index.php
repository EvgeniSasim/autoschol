<?php get_header(); ?>
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
        <?php if( get_the_content() ){ ?>
        <section class="content-page-section">
            <div class="container">
               <?php the_content() ?>
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
<?php 
/****
 Template Name:Home_template
****/
get_header(); ?>
<main class="main">
    <section class="home-top-section">
        <div class="home-top-section__content">
            <div class="container">
                <div class="home-top-section__content__wrapper">
                    <h1><?php the_field('zagolovok'); ?></h1>
                    <h2><?php the_field('podzagolovok'); ?></h2>
                    <div class="button">
                        <a href="<?php the_field('sobytie_knopki'); ?>" class="primary-btn">
                            <?php the_field('tekst_knopki'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-top-section__img">
            <?php $img = get_field('fonovoe_izobrazhenie');?>
            <img 
                src="<?php echo $img['url'] ?>" 
                alt="<?php echo $img['alt'] ?>"
                title="<?php echo $img['title'] ?>"
                width="<?php echo $img['width'] ?>"
                height="<?php echo $img['height'] ?>"
            >
        </div>
    </section>
    <?php
        if( have_rows('construct') ):
            $layouts = get_field('construct');
            foreach ($layouts as $layout):
                $acfLayoutName = $layout['acf_fc_layout'];
                get_template_part("/UI/$acfLayoutName", null, $layout );
            endforeach;
        endif;
    ?>
<?php get_footer();?>
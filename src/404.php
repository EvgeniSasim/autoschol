<?php 
/**
 * The template for 404 not found.
 *
 * @package Autoschool WordPress Theme
 * @version 0.0.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<div class="main">
	<section class="error-404-section">
		<div class="container">
			<div class="error-page__img">
				<img 
					src="<?php echo get_template_directory_uri().'/img/error_404.svg' ?>" 
					alt="Страница не найдена. Ошибка 404"
					title="Страница не найдена"
					width="259" 
					height="130"
					loading="lazy"
				>
			</div>
			<h1>Похоже, мы не можем найти нужную Вам страницу.</h1>
			<a href="<?php echo get_home_url(); ?>">Назад</a>
		</div>
	</section>
</div>
<?php get_footer(); ?>

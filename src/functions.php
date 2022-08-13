<?php
	add_action( 'wp_enqueue_scripts', 'autoschool_style' );
	add_action( 'wp_enqueue_scripts', 'autoschool_scripts' );
function autoschool_style() {
	wp_enqueue_style( 'style.min', get_template_directory_uri() . '/css/style.min.css');
}
function autoschool_scripts() {
	wp_enqueue_script( 'popper.min', get_template_directory_uri() .'/js/popper.min.js', array(), null, true );
	wp_enqueue_script( 'autoschool_scripts', get_template_directory_uri() .'/js/main.min.js', array(), null, true );
}
function wpassist_remove_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	}
	add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );
// helpers
require get_template_directory() . '/inc/helpers/helpers.php';
// Registering the menu
		add_action( 'after_setup_theme', function(){
			register_nav_menus( [
				'menu-header' => 'Header',
			] );
		});
// Walker Class Header Menu (popover menu) //
	require get_template_directory() . '/inc/classes/header-menu.php';
// Add selector menu item
function add_additional_class_on_li($classes, $item, $args) {
	if(isset($args->add_li_class)) {
		$classes[] = $args->add_li_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);
// Add active class item menu
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
// Settings pages
require get_template_directory() . '/inc/settings_page/settings_page.php';
/// Theme support
add_theme_support( 'custom-logo' );
add_theme_support('post-thumbnails', array('post', 'stats', 'promotions', 'instructors'));
add_theme_support( 'html5', array( 'search-form' ) );
//// acf-flexible-content-preview
add_filter( 'acf-flexible-content-preview.images_path', 'get_acf_preview_path' );
function get_acf_preview_path() {
    return 'inc/acf_flexible_content_preview';
}
// Google API ACF
function google_map_acf_init( $api ){
    $api['key'] = get_field('google_map_api_key', 'option');
    return $api;
}
add_filter('acf/fields/google_map/api', 'google_map_acf_init');
// Register taxonomy
require get_template_directory() . '/inc/taxonomy/tax.php';
// AJAX API
function util_script() {
      wp_enqueue_script('wp_util_script', get_template_directory_uri() . '/inc/util_ajax/get_stats_ajax.js', array(), null, true);
      wp_localize_script( 'wp_util_script', 'wp_util_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'wp_util_nonce' ),
    ));
}
//// Query processing
if( wp_doing_ajax() ){
	add_action( 'wp_ajax_getposts', 'ajax_handler' );
	add_action( 'wp_ajax_nopriv_getposts', 'ajax_handler' );
}
function ajax_handler() {
	check_ajax_referer( 'wp_util_nonce', 'nonce' );
	get_template_part("/inc/util_ajax/util_ajax", null, $_POST );
	wp_die();
}
// Posting testimonials from CF7
require get_template_directory() . '/inc/cf7/cf7_posting_testimonials.php';
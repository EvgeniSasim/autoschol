<?php
// loader script (async, defer, default)
function add_asyncdefer_attribute($tag, $handle) {
    if (strpos($handle, 'async') !== false) {
        return str_replace( '<script ', '<script async ', $tag );
    }
    else if (strpos($handle, 'defer') !== false) {
        return str_replace( '<script ', '<script defer ', $tag );
    }
    else {
        return $tag;
    }
}
add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);
// add scrips
function add_scripts_ui($scripts){
	wp_add_inline_script( 'autoschool_scripts', $scripts );
}
// Swiper
function init_swiper($swiper){
    wp_enqueue_script( 'swiper_scripts', get_template_directory_uri() .'/js/swiper-bundle.min.js', array(), null, true );
	wp_add_inline_script( 'swiper_scripts', $swiper);
}
// Lightbox
function init_lightbox(){
    wp_enqueue_style( 'glightbox.min', get_template_directory_uri() . '/dist/css/glightbox.min.css');
    wp_enqueue_script( 'glightbox.min', get_template_directory_uri() .'/dist/js/glightbox.min.js', array(), null, true );
	wp_add_inline_script( 'glightbox.min', '
    const lightbox = GLightbox(
        {
            closeButton: false, 
            closeOnOutsideClick: true, 
            loop: true,
        }
    );' 
);
}
// Air-datepicker
function init_air_datepicker() {
    wp_enqueue_style( 'air-datepicker', get_template_directory_uri() . '/dist/air-datepicker.css');
    wp_enqueue_script( 'air-datepicker', get_template_directory_uri() .'/dist/air-datepicker.js', array(), null, true );
	wp_add_inline_script( 'air-datepicker', "
		document.querySelectorAll('.goo_sheets_input').forEach((item, index) => { 
			let selector = '#date-filter__' + index;
			new AirDatepicker(selector, {
                autoClose: true,
				range: true,
				offset: 0,
				multipleDatesSeparator: ' - ',
			});
		})
	");
}
/// Google Map
function google_map() {
    $googleMapApiKey = get_field('google_map_api_key', 'option');
    wp_register_script('google_map_async', 'https://maps.googleapis.com/maps/api/js?key='.$googleMapApiKey.'&callback=initMap&v=weekly&channel=2', '', 2, false);
    wp_enqueue_script('google_map_async', array(), null, true );
}
// Cut text
add_action( 'wp_cutText', 'cutText', 10, 2 );
function cutText($excerpt, $num ) {
    if (strlen($excerpt) > $num) {
        $excerpt = mb_substr($excerpt, 0, $num);
        $excerpt = mb_substr($excerpt, 0, strrpos($excerpt, ' '));
        $excerpt .= '...';
    }
    echo $excerpt;
}
// End of calculable
add_action( 'wp_num_decline', 'num_decline', 10, 3 );
function num_decline( $number, $titles, $show_number = true ){
    if( is_string( $titles ) ){
        $titles = preg_split( '/, */', $titles );
    }
    if( empty( $titles[2] ) ){
        $titles[2] = $titles[1];
    }
    $cases = [ 2, 0, 1, 1, 1, 2 ];
    $intnum = abs( (int) strip_tags( $number ) );
    $title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
        ? 2
        : $cases[ min( $intnum % 10, 5 ) ];
    $res_string = ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
    echo $res_string;
};
// Format Date
add_action( 'wp_format_date', 'format_date', 10, 1 );
function format_date($date) {
   echo implode('.', array_reverse(explode('-', explode(' ', $date)[0])));
}
// Remove link from Menu
function artabr_menu_no_link($no_link){
    $in_link = array (
                    '!<li(.*?)class="(.*?)menu-item-object-custom(.*?)"><a(.*?)>(.*?)</a>!si',
                    '!<li(.*?)class="(.*?)current-menu-item(.*?)"><a(.*?)>(.*?)</a>!si'
                );
    $out_link = array (
                    '<li$1class="\\2menu-item-object-custom\\3"><span>$5</span>',
                    '<li$1class="\\2current-menu-item\\3"><span>$5</span>'
                );
    return preg_replace($in_link, $out_link, $no_link );
    }
    add_filter('wp_nav_menu', 'artabr_menu_no_link');
// remove type='text/javascript'
add_action( 'template_redirect', function(){
    ob_start( function( $buffer ){
       $buffer = str_replace( array( 'type="text/javascript"', "type='text/javascript'" ), '', $buffer );
       $buffer = str_replace( array( 'type="text/css"', "type='text/css'" ), '', $buffer );
       return $buffer;
    });
 });
 /// remove global_css
 function remove_global_css() {
    // Paste the code here
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
}
add_action('init', 'remove_global_css');
// AJAX API
function get_reviews_ajax() {
    wp_enqueue_script('wp_get_reviews_ajax_script', get_template_directory_uri() . '/inc/util_ajax/outside_reviews_ajax.js', array(), null, true);
    wp_localize_script( 'wp_get_reviews_ajax_script', 'wp_get_reviews_ajax', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => wp_create_nonce( 'wp_get_reviews_ajax_nonce' ),
  ));
}

if( wp_doing_ajax() ){
	add_action( 'wp_ajax_getreviews', 'ajax_get_reviews' );
	add_action( 'wp_ajax_nopriv_getreviews', 'ajax_get_reviews' );
}
function ajax_get_reviews() {
  check_ajax_referer( 'wp_get_reviews_ajax_nonce', 'nonce' );
  get_template_part("/inc/util_ajax/outside_reviews_ajax", null, $_POST );
  wp_die();
}
/* Get Google Sheets Data */
function get_google_sheet_data_ajax() {
    wp_enqueue_script('wp_get_google_sheets_ajax', get_template_directory_uri() . '/inc/util_ajax/get_google_sheets_ajax.js', array(), null, true);
    wp_localize_script( 'wp_get_google_sheets_ajax', 'wp_get_sheet', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => wp_create_nonce( 'wp_get_sheet_nonce' ),
  ));
}

if( wp_doing_ajax() ){
	add_action( 'wp_ajax_sheets', 'ajax_get_google_sheets' );
	add_action( 'wp_ajax_nopriv_sheets', 'ajax_get_google_sheets' );
}
function ajax_get_google_sheets() {
  check_ajax_referer( 'wp_get_sheet_nonce', 'nonce' );
  get_template_part("/inc/util_ajax/google_sheets_ajax", null, $_POST );
  wp_die();
}
/* Paginate */
function get_paginate_ajax() {
    wp_enqueue_script('wp_get_paginate_ajax_script', get_template_directory_uri() . '/inc/util_ajax/paginate_ajax.js', array(), null, true);
    wp_localize_script( 'wp_get_paginate_ajax_script', 'wp_get_paginate_ajax', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => wp_create_nonce( 'wp_get_paginate_ajax_nonce' ),
  ));
}
if( wp_doing_ajax() ){
	add_action( 'wp_ajax_getpaginate', 'ajax_get_paginate' );
	add_action( 'wp_ajax_nopriv_getpaginate', 'ajax_get_paginate' );
}
function ajax_get_paginate() {
  check_ajax_referer( 'wp_get_paginate_ajax_nonce', 'nonce' );
  get_template_part("/inc/util_ajax/outside_reviews_ajax", null, $_POST );
  wp_die();
}

function paginate_ajax($wp_query, $currentPage) {
    $res = '';
    $paginate = paginate_links( [
        'base'    => user_trailingslashit( wp_normalize_path( '/%#%/' ) ),
        'current' => $currentPage,
        'total'   => $wp_query->max_num_pages,
        'format'  => '',
        'prev_text'    => __(''),
        'next_text'    => __(''),
        "type"    => "array"
    ] );
    foreach ($paginate as $key => $item) {
        $search  = array('<a', 'href', '</a>',);
        $replace = array('<button', 'data-href', '</button>',);
        $res .= ''.str_replace($search, $replace, $item).'';
    }
    return $res;
}
/* Blog sort */
function get_blogPostSortData_ajax() {
    wp_enqueue_script('wp_get_blogPostSortData_ajax_script', get_template_directory_uri() . '/inc/util_ajax/blog_ajax.js', array(), null, true);
    wp_localize_script( 'wp_get_blogPostSortData_ajax_script', 'wp_get_blogPostSortData_ajax', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => wp_create_nonce( 'wp_get_blogPostSortData_ajax_nonce' ),
  ));
}
if( wp_doing_ajax() ){
	add_action( 'wp_ajax_getblogPostSortData', 'ajax_get_blogPostSortData' );
	add_action( 'wp_ajax_nopriv_getblogPostSortData', 'ajax_get_blogPostSortData' );
}
function ajax_get_blogPostSortData() {
  check_ajax_referer( 'wp_get_blogPostSortData_ajax_nonce', 'nonce' );
  get_template_part("/inc/util_ajax/blog_ajax", null, $_POST );
  wp_die();
}
// Count postviews post
add_action( 'wp_head', 'count_postviews' );
function count_postviews( $args = [] ){
	global $user_ID, $post, $wpdb;
	if( ! $post || ! is_singular() )
		return;
	$rg = (object) wp_parse_args( $args, [
		'meta_key' => 'views',
		'who_count' => 0,
		'exclude_bots' => true,
	] );
	$do_count = false;
	switch( $rg->who_count ){
		case 0:
			$do_count = true;
			break;
		case 1:
			if( ! $user_ID )
				$do_count = true;
			break;
		case 2:
			if( $user_ID )
				$do_count = true;
			break;
	}
	if( $do_count && $rg->exclude_bots ){
		$notbot = 'Mozilla|Opera';
		$bot = 'Bot/|robot|Slurp/|yahoo';
		if(
			! preg_match( "/$notbot/i", $_SERVER['HTTP_USER_AGENT'] ) ||
			preg_match( "~$bot~i", $_SERVER['HTTP_USER_AGENT'] )
		){
			$do_count = false;
		}
	}
	if( $do_count ){
		$up = $wpdb->query( $wpdb->prepare(
			"UPDATE $wpdb->postmeta SET meta_value = (meta_value+1) WHERE post_id = %d AND meta_key = %s",
			$post->ID, $rg->meta_key
		) );
		if( ! $up )
			add_post_meta( $post->ID, $rg->meta_key, 1, true );
			wp_cache_delete( $post->ID, 'post_meta' );
	}
}
// Disable emojis
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    }
    return array();
}
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
        foreach ( $urls as $key => $url ) {
            if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
                unset( $urls[$key] );
            }
        }
    }
    return $urls;
}
// Logo wp-admin
function wpdev_filter_login_head() {
    if ( has_custom_logo() ) :
        $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
        ?>
        <style type="text/css">
            .login h1 a {
                background-image: url(<?php echo esc_url( $image[0] ); ?>);
                -webkit-background-size: <?php echo absint( $image[1] )?>px;
                background-size: <?php echo absint( $image[1] ) ?>px;
                height: <?php echo absint( $image[2] ) ?>px;
                width: <?php echo absint( $image[1] ) ?>px;
            }
        </style>
        <?php
    endif;
}
add_action( 'login_head', 'wpdev_filter_login_head', 100 );
function new_wp_login_url() {
    return home_url();
}
add_filter('login_headerurl', 'new_wp_login_url');
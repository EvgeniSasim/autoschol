<?php

add_action( 'wpcf7_before_send_mail', 'create_testimonials_from_cf7' );

function create_testimonials_from_cf7( $contact_form ) {

    $submission = WPCF7_Submission::get_instance();

    $title = $_POST['your-name'] && ! empty( $_POST['your-name'] ) ? sanitize_text_field( $_POST['your-name'] ) : '';
    $name = $_POST['text-432'] && ! empty( $_POST['text-432'] ) ? sanitize_text_field( $_POST['text-432'] ) : '';
    $testimonial = $_POST['textarea-297'] && ! empty( $_POST['textarea-297'] ) ? wp_strip_all_tags( $_POST['textarea-297'] ) : '';
    $rank = $_POST['number-909'] && ! empty( $_POST['number-909'] ) ? sanitize_text_field( $_POST['number-909'] ) : '';
    
    $arg = [
        'post_type'     => 'testimonials',
        'post_title'    => 'Отзыв о: '.$name. ' от ' .$title .'',
	    'post_content'  => $testimonial,
	    'post_status'   => 'pending',
        'tags_input'     => array( $name ),  
        'meta_input'    => [ 
            'oczenka'            =>  $rank,
            'fio_avtora_otzyva'  =>  $title,
        ],
    ];

    $post_id = wp_insert_post( $arg );

}

//// Шорт код 
add_filter( 'wpcf7_form_elements', 'do_shortcode' );
function select_date_cf7_func() {
    $schedule = get_field('schedule', 'option');
    $res =  '<select name="name" id="select__schedule" class="wpcf7-form-control wpcf7-select">';
    foreach ($schedule as $key => $table) {
        foreach ($table['gruppa'] as $index => $row) { 
            $res .= '<option 
                            id="'.$row['data_nachala'].'"
                            data-type="'.$table['tip_gruppy'].'"
                            data-cat="'.$table['vyberite_kategoriyu_prav'].'"
                            value='.$row['data_nachala'].'>'.$row['data_nachala'].
                    '</option>';
        }
    }
    $res .= '<option id="not_data" value="" disabled hidden>Нет подходящей даты</option></select>';
    return $res;
}
add_shortcode('select_date', 'select_date_cf7_func');

add_filter('wpcf7_mail_components', 'do_shortcode_mail', 10, 3);
function do_shortcode_mail( $components, $contactForm, $mailComponent ){
	if( isset($components['body']) ){
		$components['body'] = do_shortcode($components['body']);
	}

	return $components;
}
?>
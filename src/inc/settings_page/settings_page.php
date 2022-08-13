<?php 
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
                'page_title' 	=> 'Настройки сайта',
                'menu_title'	=> 'Настройки сайта',
                'menu_slug' 	=> 'theme-general-settings',
                'capability'	=> 'edit_posts',
                'redirect'		=> false,
                'position'      => 3,
                'update_button' => __('Сохранить', 'acf'),
            )
        );
        acf_add_options_page(array(
                'page_title' 	=> 'Расписание школы',
                'menu_title'	=> 'Расписание школы',
                'menu_slug' 	=> 'schedule',
                'icon_url'      => 'dashicons-calendar-alt',
                'capability'	=> 'edit_posts',
                'redirect'		=> false,
                'position'      => 3,
                'update_button' => __('Сохранить', 'acf'),
            )
        );
    }
?>
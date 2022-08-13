<?php
    add_action( 'init', 'create_stats_taxonomies' );
    function create_stats_taxonomies(){
        register_taxonomy('statistics', 'stats', array(
            'hierarchical'  => false,
            'labels'        => array(
                'name'                        => _x( 'Статистика за год', 'taxonomy general name' ),
                'singular_name'               => _x( 'stats', 'taxonomy singular name' ),
                'search_items'                =>  __( 'Search statistics' ),
                'popular_items'               => __( 'Popular statistics' ),
                'all_items'                   => __( 'All statistics' ),
                'parent_item'                 => null,
                'parent_item_colon'           => null,
                'edit_item'                   => __( 'Edit statistics' ),
                'update_item'                 => __( 'Update statistics' ),
                'add_new_item'                => __( 'Add New statistics' ),
                'new_item_name'               => __( 'New statistics Name' ),
                'separate_items_with_commas'  => __( 'Укажите за какой год статистика.' ),
                'add_or_remove_items'         => __( 'Add or remove statistics' ),
                'choose_from_most_used'       => __( 'Выбрать из наиболее часто используемых' ),
            ),
            'show_ui'            => true,
            'show_admin_column'  => true,
            'query_var'          => true,
            'show_in_menu'       => false,
            'show_in_nav_menus'  => false,
        ));
    }
    add_action( 'init', 'register_post_types' );
    function register_post_types(){
        register_post_type( 'stats', [
            'label'  => null,
            'labels' => [
                'name'               => 'Статистика сдачи по годам',
                'singular_name'      => 'Статистика сдачи за год', 
                'add_new'            => 'Добавить статистику',
                'add_new_item'       => 'Добавление статистика за', 
                'edit_item'          => 'Редактирование', 
                'new_item'           => 'Новоя статистика за год', 
                'view_item'          => 'Смотреть статистику', 
                'search_items'       => 'Искать статистику', 
                'not_found'          => 'Не найдено', 
                'not_found_in_trash' => 'Не найдено в корзине', 
                'parent_item_colon'  => '', 
                'menu_name'          => 'Статистика сдачи', 
            ],
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'show_in_menu'        => null,
            'show_in_rest'        => null, 
            'rest_base'           => null, 
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-chart-line',
            'map_meta_cap'        => true, 
            'hierarchical'        => false,
            'supports'            => [ 'title','custom-fields','post-formats','thumbnail',], 
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ] );
        register_post_type( 'promotions', [
            'hierarchical'  => true,
            'taxonomies' => array('category'),
            'label'  => null,
            'labels' => [
                'name'               => 'Акции',
                'singular_name'      => 'Акция', 
                'add_new'            => 'Добавить акцию',
                'add_new_item'       => 'Добавление акции', 
                'edit_item'          => 'Редактирование', 
                'new_item'           => 'Новоя акция', 
                'view_item'          => 'Смотреть акцию', 
                'search_items'       => 'Искать акцию', 
                'not_found'          => 'Не найдено', 
                'not_found_in_trash' => 'Не найдено в корзине', 
                'parent_item_colon'  => '', 
                'menu_name'          => 'Акции', 
            ],
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'show_in_menu'        => null,
            'show_in_rest'        => null, 
            'rest_base'           => null, 
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-star-empty',
            'map_meta_cap'        => true, 
            'hierarchical'        => false,
            'supports'            => [ 'title','custom-fields','thumbnail','editor','excerpt','page-attributes'], 
            'has_archive'         => false,
            'query_var'           => true,
            'rewrite'   => array( 'slug' => 'akczii', 'with_front' => false ),  
        ] );
        register_post_type( 'instructors', [
            'hierarchical'  => true,
            'taxonomies' => array('category'),
            'label'  => null,
            'labels' => [
                'name'               => 'Инструктора и преподаватели',
                'singular_name'      => 'Инструктора и преподаватели', 
                'add_new'            => 'Добавить',
                'add_new_item'       => 'Добавление', 
                'edit_item'          => 'Редактирование', 
                'new_item'           => 'Новый', 
                'view_item'          => 'Смотреть', 
                'search_items'       => 'Искать', 
                'menu_name'          => 'Инструктора и преподаватели', 
            ],
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'show_in_menu'        => null,
            'show_in_rest'        => null, 
            'rest_base'           => null, 
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-welcome-learn-more',
            'map_meta_cap'        => true, 
            'hierarchical'        => false,
            'supports'            => [ 'title','custom-fields','thumbnail','editor','excerpt','page-attributes'], 
            'has_archive'         => false,
            'query_var'           => true,
            'rewrite'   => array( 
                'slug' => 'instruktora-i-prepodavateli',
                'with_front' => false,
                'with_front' => false,
                'pages'      => true,
                'feeds'      => false,
                'feed'       => false
            ),  
        ] );
        register_post_type( 'testimonials', [
            'hierarchical'  => false,
            'taxonomies' => array('category'),
            'label'  => null,
            'labels' => [
                'name'               => 'Отзывы',
                'singular_name'      => 'Отзыв', 
                'add_new'            => 'Добавить отзыв',
                'add_new_item'       => 'Добавление отзыва', 
                'edit_item'          => 'Редактирование', 
                'new_item'           => 'Новый отзыв', 
                'view_item'          => 'Смотреть отзыв', 
                'search_items'       => 'Искать отзыв', 
                'not_found'          => 'Не найдено', 
                'not_found_in_trash' => 'Не найдено в корзине', 
                'parent_item_colon'  => '', 
                'menu_name'          => 'Отзывы',
                'attributes'         => 'Свойства', 
            ],
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'show_in_menu'        => null,
            'show_tagcloud'        => true,
            'show_in_rest'        => null, 
            'rest_base'           => null, 
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-format-status',
            'map_meta_cap'        => true, 
            'hierarchical'        => false,
            'supports'            => ['title','custom-fields','editor','page-attributes'], 
            'has_archive'         => false,
            'rewrite'   => array( 
                'with_front' => false,
                'with_front' => false,
                'pages'      => true,
                'feeds'      => false,
                'feed'       => false
            ),  
            'query_var'           => true,
        ] );
        register_post_type( 'socials', [
            'hierarchical'  => false,
            'taxonomies' => array('category'),
            'label'  => null,
            'labels' => [
                'name'               => 'Внешние отзывы',
                'singular_name'      => 'Внешний отзыв', 
                'add_new'            => 'Добавить отзыв',
                'add_new_item'       => 'Добавление отзыва', 
                'edit_item'          => 'Редактирование', 
                'new_item'           => 'Новый отзыв', 
                'view_item'          => 'Смотреть отзыв', 
                'search_items'       => 'Искать отзыв', 
                'not_found'          => 'Не найдено', 
                'not_found_in_trash' => 'Не найдено в корзине', 
                'parent_item_colon'  => '', 
                'menu_name'          => 'Внешние отзывы (Гугл, Яндекс, Видео)',
                'attributes'         => 'Свойства', 
            ],
            'description'         => '',
            'public'              => true,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'show_in_menu'        => null,
            'show_tagcloud'        => true,
            'show_in_rest'        => null, 
            'rest_base'           => null, 
            'menu_position'       => 4,
            'menu_icon'           => 'dashicons-testimonial',
            'map_meta_cap'        => true, 
            'hierarchical'        => false,
            'supports'            => ['title','custom-fields','editor','page-attributes'], 
            'has_archive'         => false,
            'rewrite'   => array( 
                'with_front' => false,
                'with_front' => false,
                'pages'      => true,
                'feeds'      => false,
                'feed'       => false
            ),  
            'query_var'           => true,
        ] );
    }
    function post_tag_for_pages(){
        register_taxonomy_for_object_type( 'post_tag', 'testimonials');
    }
     
    add_action( 'init', 'post_tag_for_pages' );
?>
<?php

add_filter( 'use_block_editor_for_post', '__return_false', 10 );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/styles/style.css' );
    wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/scripts/script.js', array(), 'null', true );
    wp_enqueue_script( 'ajax-filter', get_template_directory_uri() . '/assets/scripts/ajax.js', array('jquery'), 'null', true );
    wp_localize_script( 'ajax-filter', 'ajaxurl', ['url' => admin_url('admin-ajax.php')] );
});

add_theme_support( 'post-thumbnails' );

function shoesstore_create_post_type() {
    register_taxonomy( 'gender', 'shoes', [
        'label' => 'Gender'
    ]);
    register_taxonomy( 'peculiarities', 'shoes', [
        'label' => 'Peculiarities'
    ]);

    register_post_type('shoes', [
        'label' => __('Shoes'),
        'supports' => [
            'title',
            'thumbnail',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-tag',
        'taxonomies' => [
            'gender',
            'peculiarities'
        ]
    ]);
}
add_action('init', 'shoesstore_create_post_type' );

if (wp_doing_ajax()) {
    add_action( 'wp_ajax_filter', 'shoes_filter' );
    add_action( 'wp_ajax_nopriv_filter', 'shoes_filter' );
}
function shoes_filter() {
    $args = [
        'post_type' => 'shoes',
        'posts_per_page' => 12,
        'order_by' => 'date',
        'order' => 'asc'
    ];
    $filter_args = [
        'gender' => [],
        'peculiarities' => [],
        'meta_query' => [
            'relation' => 'AND'
        ]
    ];
    if (!$_POST) {
        $filter_args = [];
    } else {
        $post_data_arr = explode("&", $_POST['data']);
        
        $gender = get_terms(['taxonomy' => 'gender']);
        if ($gender) {
            foreach ($gender as $gender) {
                in_array("{$gender->slug}=on", $post_data_arr) ? array_push($filter_args['gender'], "{$gender->slug}") : null;
            }
        }
        
        $peculiarities = get_terms(['taxonomy' => 'peculiarities']);
        if ($peculiarities) {
            foreach ($peculiarities as $pec) {
                in_array("{$pec->slug}=on", $post_data_arr) ? array_push($filter_args['peculiarities'], "{$pec->slug}") : null;
            }
        }
        
        $shoes_arr = new WP_Query(['post_type' => 'shoes', 'posts_per_page' => -1]);
        while ( $shoes_arr->have_posts() ) {
            $shoes_arr->the_post();

            if(get_field('color')) {
                foreach(get_field('color') as $colors) {
                    foreach($colors as $color => $value) {
                        if ($value) {
                            in_array("$color=on", $post_data_arr) ? array_push($filter_args['meta_query'], ['key' => "color_0_$color", 'value' => true]) : null;
                        }
                    }
                }
            }

            if(get_field('size')) {
                foreach(get_field('size') as $sizes) {
                    foreach($sizes as $size => $value) {
                        if ($value) {
                            in_array("size-option-$size=on", $post_data_arr) ? array_push($filter_args['meta_query'], ['key' => "size_0_$size", 'value' => true]) : null;
                        }
                    }
                }
            }
        }
    }

    $query = new WP_Query(array_merge($args, $filter_args));
    // $response = [
    //     'shoes' => [],
    //     'peculiarities' => [],
    //     'gender' => []
    // ];

    // if ( $query->have_posts() ) {
    //     while ( $query->have_posts() ) {
    //         $query->the_post();
    //         $price = get_field('price');
    //         if ($price >= $_POST['price_min'] && $price <= $_POST['price_max']) {
    //             // get_template_part("components/single-card");
    //             $id = get_the_ID();
    //             $thumb = get_the_post_thumbnail();
    //             $title = get_the_title();
    //             $price = number_format(get_field('price'), 2, '.', ' ');
    //             array_push($response['shoes'], ['id' => $id, 'thumbnail' => $thumb, 'title' => $title, 'price' => $price]);
    //             // $peculiarities = get_terms(['taxonomy' => 'peculiarities', 'orderby' => 'none']);
    //             $peculiarities = get_the_terms($post_id, 'peculiarities');
    //             array_push($response['peculiarities'], [$peculiarities]);
    //             $gender = get_the_terms($post_id, 'gender');
    //             in_array($gender, $response['gender']) ? null : array_push($response['gender'], $gender);
    //         }
    //     }
    // }

    // echo json_encode($response);

    require('components/sidebar.php'); ?>
        <div class="catalog__showcase">
            <div class="sort-wrapper">
                <button class="sort__filter-btn"><img src="<?php bloginfo('template_url'); ?>/assets/svg/filter-logo.svg" alt="filter">Filter</button>
                <div class="sort">
                    <div class="sort__select">Sort by</div>
                    <ul class="sort__list">
                        <li class="sort__list-item">Price increase</li>
                        <li class="sort__list-item">Price reduction</li>
                        <li class="sort__list-item">The most popular</li>
                        <li class="sort__list-item">Biggest discount</li>
                    </ul>
                </div>
            </div>
            <div class="showcase__items">
                <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $price = get_field('price');
                        if ($price >= $_POST['price_min'] && $price <= $_POST['price_max']) {
                            get_template_part("components/single-card");
                        }
                    }
                ?>
            </div>
            <div class="catalog__pagination">
                <button class="pagination__item">1</button>
                <button class="pagination__item">2</button>
                <button class="pagination__item selected">3</button>
                <div class="pagination__item dots">...</div>
                <button class="pagination__item">16</button>
            </div>
        </div>
    <?php

    wp_reset_postdata();

    wp_die();
}

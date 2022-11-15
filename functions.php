<?php

add_filter( 'use_block_editor_for_post', '__return_false', 10 );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/styles/style.css' );
    wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/scripts/script.js', array(), 'null', true );
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

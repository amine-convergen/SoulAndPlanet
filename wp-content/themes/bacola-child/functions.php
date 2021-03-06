<?php
/**
 * Theme functions and definitions.
 * This child theme was generated by Merlin WP.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

/*
 * If your child theme has more than one .css file (eg. ie.css, style.css, main.css) then
 * you will have to make sure to maintain all of the parent theme dependencies.
 *
 * Make sure you're using the correct handle for loading the parent theme's styles.
 * Failure to use the proper tag will result in a CSS file needlessly being loaded twice.
 * This will usually not affect the site appearance, but it's inefficient and extends your page's loading time.
 *
 * @link https://codex.wordpress.org/Child_Themes
 */
function bacola_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style' , get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'bacola-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'bacola-style' ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style( 'parent-style-2', get_template_directory_uri() . '/custom-style.css' , array(), rand(111,9999), 'all' );
}

add_action(  'wp_enqueue_scripts', 'bacola_child_enqueue_styles', 99 );

// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Ajouter au panier', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Ajouter au panier', 'woocommerce' );
}
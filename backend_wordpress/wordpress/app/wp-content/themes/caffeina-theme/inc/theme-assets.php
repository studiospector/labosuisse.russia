<?php

/**
 * Enqueue site scripts
 */
add_action('wp_enqueue_scripts', 'cf_register_scripts');
function cf_register_scripts()
{
    // // Register scripts
    // wp_register_script('slick-js', LB_BUILD_LIB_URI . '/js/slick.min.js', ['jquery'], false, true);
    // wp_register_script('cf-main-js', LB_BUILD_JS_URI . '/main.js', ['jquery', 'slick-js'], filemtime(LB_BUILD_JS_DIR_PATH . '/main.js'), true);

    // // Enqueue scripts
    // wp_enqueue_script('slick-js');
    // wp_enqueue_script('cf-main-js');
}



/**
 * Enqueue site style
 */
add_action('wp_enqueue_scripts', 'cf_register_styles');
function cf_register_styles()
{
    // // Register styles
    // wp_register_style('slick-css', LB_BUILD_LIB_URI . '/css/slick.css', [], false, 'all');
    // // wp_register_style('slick-theme-css', LB_BUILD_LIB_URI . '/css/slick-theme.css', ['slick-css'], false, 'all');
    // wp_register_style('cf-main-css', LB_BUILD_CSS_URI . '/main.css', [], filemtime(LB_BUILD_CSS_DIR_PATH . '/main.css'), 'all');

    // // Enqueue style
    // wp_enqueue_style('slick-css');
    // // wp_enqueue_style('slick-theme-css');
    // wp_enqueue_style('cf-main-css');

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wp-block-library-css');
}



/**
 * Enqueue admin style
 */
add_action('admin_enqueue_scripts', 'cf_register_admin_styles');
function cf_register_admin_styles()
{
    // // Register styles
    // wp_register_style('cf-custom-admin', LB_BUILD_CSS_URI . '/admin.css', [], filemtime(LB_BUILD_CSS_DIR_PATH . '/admin.css'), 'all');

    // // Enqueue Styles
    // wp_enqueue_style('cf-custom-admin');
}



/**
 * Enqueue editor scripts and styles
 * 
 * Note:
 * The 'enqueue_block_assets' hook includes styles and scripts both in editor and frontend
 * except when is_admin() is used to include them conditionally
 */
add_action('enqueue_block_assets', 'cf_enqueue_editor_assets');
function cf_enqueue_editor_assets()
{
    if (is_admin()) {
        // Gutenberg blocks JS
        wp_enqueue_script(
            'cf-blocks-js',
            LB_BUILD_JS_URI . '/blocks.js',
            ['wp-polyfill'],
            filemtime(LB_BUILD_JS_DIR_PATH . '/blocks.js'),
            true
        );

        // Gutenberg blocks CSS
        wp_enqueue_style(
            'cf-blocks-css',
            LB_BUILD_CSS_URI . '/blocks.css',
            ['wp-block-library-theme', 'wp-block-library',],
            filemtime(LB_BUILD_CSS_DIR_PATH . '/blocks.css'),
            'all'
        );
    }
}
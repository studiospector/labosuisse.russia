<?php

/**
 * Remove classes from body_class function
 */
add_filter('body_class','lb_set_wc_custom_body_classes');
function lb_set_wc_custom_body_classes($classes) {

    $filtered_classes = array_filter(
        $classes,
        function ($val) {
            return !in_array($val, ['woocommerce']);
        }
    );

    return $filtered_classes;
}



/**
 * Custom select for product variations
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'lb_set_custom_data_attribute_product_variations', 10, 2);
function lb_set_custom_data_attribute_product_variations($html, $args)
{

    $label = ucfirst(str_replace("pa_", "", $args['attribute']));

    $html = str_replace("id=\"{$args['attribute']}\"", "id=\"{$args['attribute']}\" " . "data-variant=\"tertiary\" data-label=\"$label\"", $html);

    return $html;
}



/**
 * Customize WC breadcrumb
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'lb_woocommerce_breadcrumbs' );
function lb_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' <span class="woocommerce-breadcrumb__separator"><svg width="7" height="8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.675.12a.5.5 0 0 0-.055.705L4.341 4l-2.72 3.175a.5.5 0 0 0 .759.65L5.659 4 2.379.175A.5.5 0 0 0 1.676.12Z" fill="#474747"/></svg></span> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb container" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Homepage', 'breadcrumb', 'woocommerce' ),
    );
}



/**
 * Move single product price after short description
 */
add_action('woocommerce_single_product_summary', 'lb_move_single_product_price', 1);
function lb_move_single_product_price() {
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 29);
}
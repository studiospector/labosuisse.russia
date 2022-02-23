<?php

require_once(LB_DIR_PATH . '/inc/wc-product-cat-pages/macro.php');
require_once(LB_DIR_PATH . '/inc/wc-product-cat-pages/zona.php');
require_once(LB_DIR_PATH . '/inc/wc-product-cat-pages/esigenza.php');

/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



// Current term
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
// Direct parents of current taxonomy
$level = get_category_parents_custom($term->term_id, 'product_cat');

//$context = [];

switch ($level) {
    // Macro
    case 1:
    
        $macro = new macro('macro',$term);
        $macro->render();
        break;


    // Zona
    case 2:
 
        $zona = new zona('zona',$term);
        $zona->render();
        break;


    // Esigenza
    case 3:
        
        $esigenza = new esigenza('esigenza',$term);
        $esigenza->render();
        break;


    // Tipologia
    case 4:
        echo "Tipologia";
        break;


    // Default
    default:
        echo "Level others";
}

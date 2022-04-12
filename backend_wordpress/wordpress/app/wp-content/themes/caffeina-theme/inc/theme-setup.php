<?php

use Caffeina\LaboSuisse\Menu\Menu;
use Caffeina\LaboSuisse\Menu\MenuFooter;
use Caffeina\LaboSuisse\Option\Option;

$composer_autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
    $timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {

    add_action(
        'admin_notices',
        function () {
            echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
        }
    );

    // add_filter(
    // 	'template_include',
    // 	function( $template ) {
    // 		return get_stylesheet_directory() . '/static/no-timber.html';
    // 	}
    // );

    return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = ['views'];

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class ThemeSetup extends Timber\Site
{

    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'theme_supports'));
        // add_filter( 'timber/context', array( $this, 'add_to_context' ) );
        add_filter('timber/twig', array($this, 'lb_add_to_twig'));
        add_filter('timber/loader/loader', array($this, 'lb_add_to_twig_loader'));
        add_action('init', array($this, 'lb_manage_thumbnails'));
        add_filter('fallback_intermediate_image_sizes', array($this, 'lb_disable_pdf_thumbnails'));
        add_filter('wpseo_breadcrumb_separator', array($this, 'lb_yoast_breadcrumb_separator'), 10, 1);
        add_filter('excerpt_length', array($this, 'lb_excerpt_length'), 999);

        parent::__construct();
    }

    /**
     * Add supports
     */
    public function theme_supports()
    {
        load_theme_textdomain('labo-suisse-theme', LB_DIR_PATH . '/languages');

        add_theme_support('title-tag');

        add_theme_support('post-thumbnails');
        add_post_type_support('page', 'excerpt');

        // add_theme_support('post-formats', array('aside', 'gallery'));

        add_image_size('lb-img-size-lg', 1800, 700, false);
        add_image_size('lb-img-size-md', 700, 400, false);
        add_image_size('lb-img-size-md-hero', null, 350, false);
        add_image_size('lb-img-size-sm', 400, 400, false);
        add_image_size('lb-img-size-xs', 200, 200, false);

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
            ]
        );

        // Gutenberg theme support
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('editor-styles');

        // Register Menus
        register_nav_menus(array(
            'lb_discover_labo' => 'Scopri Labo',
            'lb_discover_labo_footer' => 'Footer | Scopri Labo',
            'lb_support_footer' => 'Footer | Assistenza',
        ));

        // Theme Options page
        acf_add_options_page(array(
            'page_title' => 'Impostazioni Tema - Generali',
            'menu_title' => 'Opzioni Tema',
            'menu_slug' => 'lb-theme-general-settings',
            'capability' => 'edit_posts',
            'update_button' => 'Aggiorna',
            'updated_message' => 'Impostazioni aggiornate.',
            'redirect' => false
        ));

        acf_add_options_sub_page(array(
            'page_title' => 'Impostazioni Tema - Header e Menu',
            'menu_title' => 'Header e Menu',
            'parent_slug' => 'lb-theme-general-settings',
            'update_button' => 'Aggiorna',
            'updated_message' => 'Impostazioni aggiornate.',
        ));

        acf_add_options_sub_page(array(
            'page_title' => 'Impostazioni Tema - Footer e Prefooter',
            'menu_title' => 'Footer',
            'parent_slug' => 'lb-theme-general-settings',
            'update_button' => 'Aggiorna',
            'updated_message' => 'Impostazioni aggiornate.',
        ));

        /**
         * Path to our custom editor style
         * It allows you to link a custom stylesheet file to the TinyMCE editor within the post edit screen
         */
        // add_editor_style('gutenberg/editor.css');

        // Remove the core block patterns
        remove_theme_support('core-block-patterns');

        /**
         * WooCommerce
         */
        add_theme_support('woocommerce', [
            'product_grid' => ['default_columns' => 4],
            'single_image_width' => 480,
        ]);
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        /**
         * Set the maximum allowed width for any content in the theme
         * like oEmbeds and images added to posts
         */
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 1240;
        }
    }

    /**
     * This is where you add some context
     */
    // public function add_to_context( $context ) {
    // 	$context['foo']   = 'bar';
    // 	$context['stuff'] = 'I am a value set in your functions.php file';
    // 	$context['notes'] = 'These values are available everytime you call Timber::context();';
    // 	$context['menu']  = new Timber\Menu();
    // 	$context['site']  = $this;
    // 	return $context;
    // }

    /**
     * Twig setup
     */
    public function lb_add_to_twig($twig)
    {
        $template_dir = get_template_directory();
        $assets_path = get_stylesheet_directory_uri() . "/assets";

        // Add Extensions
        $twig->addExtension(new Twig\Extension\StringLoaderExtension());

        // Global Variables
        $twig->addGlobal('theme', $template_dir);
        $twig->addGlobal('assets', $assets_path);

        /**
         * Add Custom Functions
         */
        $twig->addFunction(new Timber\Twig_Function('revision_files', [$this, 'revision_files']));

        $twig->addFunction(new Timber\Twig_Function('current_url', function () {
            return Timber\URLHelper::get_current_url();
        }));

        /**
         * Add Custom Filters
         */
        $twig->addFilter(new Timber\Twig_Filter('trans', function ($value, $params = [], $lang = false) {
            if ($lang) {
                global $sitepress;
                $current_lang = $sitepress->get_current_language();
                $sitepress->switch_lang($lang);
                $value = __($value, 'labo-suisse-theme');
                $sitepress->switch_lang($current_lang);
            } else {
                $value = __($value, 'labo-suisse-theme');
            }
            if (count($params)) {
                return vsprintf($value, $params);
            } else {
                return $value;
            }
        }));

        $twig->addFilter(new Timber\Twig_Filter('is_current_url', function ($link) {
            return (Timber\URLHelper::get_current_url() == $link) ? true : false;
        }));

        return $twig;
    }

    /**
     * Twig Load setup
     */
    public function lb_add_to_twig_loader($loader)
    {
        $template_dir = get_template_directory();
        $bundle_folder = 'static';
        $bundle_path = $template_dir . "/$bundle_folder";

        // Global Paths
        $loader->addPath($bundle_path, 'static');

        // Namespaces
        $loader->addPath($template_dir . '/views', 'PathViews');

        return $loader;
    }

    /**
     * Twig Function
     * Get paths to static files
     */
    public static function revision_files($file, $manifest_name = 'rev-manifest.json')
    {
        $bundle_folder = 'static';
        $manifest_path = __DIR__ . "/../../$bundle_folder/" . $manifest_name;

        $theme_path = get_template_directory_uri();

        if (file_exists($manifest_path)) {
            // die($manifest_path);
            $manifest = json_decode(file_get_contents($manifest_path), true);

            if (!isset($manifest[$file])) {
                throw new \InvalidArgumentException("File {$file} not defined in asset manifest.");
            }

            return "$theme_path/$bundle_folder/$manifest[$file]";
        }

        return "$theme_path/$bundle_folder/$file";
    }

    /**
     * Manage specific thumbnail sizes
     */
    public function lb_manage_thumbnails()
    {
        foreach (get_intermediate_image_sizes() as $size) {
            if (in_array($size, array('thumbnail', 'medium', 'medium_large', 'large', '1536x1536', '2048x2048'))) {
                remove_image_size($size);
            }
        }
    }

    /**
     * Disable PDF preview images
     */
    public function lb_disable_pdf_thumbnails()
    {
        $fallbacksizes = array();
        return $fallbacksizes;
    }

    /**
     * Change Yoat SEO Bradcrumbs separator
     */
    public function lb_yoast_breadcrumb_separator($sep)
    {
        return '<span class="lb-icon lb-icon-arrow-right"><svg aria-label="arrow-right" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#arrow-right"></use></svg></span>';
    }

    /**
     * Filter the excerpt length to 20 words
     *
     * @param int $length Excerpt length
     *
     * @return int (Maybe) modified excerpt length
     */
    public function lb_excerpt_length($length)
    {
        if (is_admin()) {
            return $length;
        }
        return 20;
    }
}

new ThemeSetup();



/**
 * ACF Config
 */
// ACF Config JSON save point
add_filter('acf/settings/save_json', 'labo_acf_json_save_point');
function labo_acf_json_save_point($path)
{
    // var_dump($path);die;
    // unset($path[0]);
    $path = get_stylesheet_directory() . '/acf-config/fields';
    return $path;
}

// ACF Config JSON load point
add_filter('acf/settings/load_json', 'labo_acf_json_load_point');
function labo_acf_json_load_point($path)
{
    // unset($path[0]);
    $path = get_stylesheet_directory() . '/acf-config/fields';
    return $path;
}



/**
 * Add custom category for components to Gutenberg editor
 */
add_action('block_categories_all', 'labo_gutenberg_block_categories', 10, 2);
function labo_gutenberg_block_categories($categories)
{
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'caffeina-theme',
                'title' => 'Caffeina Theme Components',
            ],
        ]
    );
}



/**
 * Assign global $product object in Timber
 */
function timber_set_product($post)
{
    global $product;
    $product = isset($post->product) ? $post->product : wc_get_product($post->ID);
}



/**
 * Filter main query
 */
add_action('pre_get_posts', 'lb_post_filters');
function lb_post_filters($query)
{
    // "Brand" and "Linea di Prodotto" Archive pages
    if (is_tax('lb-brand') && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page()) {
        $query->set('posts_per_page', 12);
    }

    // Product Category Archive page
    // if (is_tax('product_cat') && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page()) {
    //     $query->set('posts_per_page', 12);
    // }

    // Posts page
    if (is_home() && !is_admin() && $query->is_main_query() && !is_front_page() && !is_archive()) {
        $query->set('posts_per_page', 12);
    }

    // Jobs Archive page
    if (is_post_type_archive('lb-job') && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page()) {
        $query->set('posts_per_page', 8);
    }

    // FAQs Archive page
    if (is_post_type_archive('lb-faq') && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page()) {
        $query->set('posts_per_page', 12);
    }

    // Archive page
    // if (is_archive() && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page()) {
    //     $query->set('posts_per_page', 12);
    //     $query->set('ignore_sticky_posts', 1);
    // }

    // Tag page
    // if (is_tag() && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page()) {
    //     $query->set('posts_per_page', 12);
    //     $query->set('ignore_sticky_posts', 1);
    // }

    // Search page
    // if (is_search() && !is_admin() && $query->is_main_query() && !is_home() && !is_front_page() && !is_archive()) {
    //     $query->set('posts_per_page', 12);
    //     $query->set('ignore_sticky_posts', 1);
    // }
}



/**
 * Add symbols.twig to WP admin area
 */
add_action('admin_footer', 'lb_add_symbols_to_admin');
function lb_add_symbols_to_admin()
{
    Timber::render('@PathViews/components/symbols.twig');
}



/**
 * Custom pagination
 */
function lb_pagination()
{
    $pagination_html = null;

    $pagination = get_the_posts_pagination([
        'mid_size' => 2,
        'prev_text' => '<div class="button button-tertiary">' . Timber::compile('@PathViews/components/icon.twig', ['name' => 'arrow-left']) . '</div>',
        'next_text' => '<div class="button button-tertiary">' . Timber::compile('@PathViews/components/icon.twig', ['name' => 'arrow-right']) . '</div>',
        'before_page_number' => '<div class="button button-secondary">',
        'after_page_number'  => '</div>'
    ]);

    if ($pagination) {
        $pagination_html = "<div class=\"lb-pagination container\"><hr class=\"lb-separator lb-separator--medium\" data-variant=\"medium\">$pagination</div>";
    }

    return $pagination_html;
}



/**
 * Unregister taxonomies
 */
add_action('init', 'lb_unregister_taxonomies', 999);
function lb_unregister_taxonomies()
{
    register_taxonomy('category', []);
    register_taxonomy('post_tag', []);
}



/**
 * Parse CF7 shortcode tags to implement custom HTML data attributes on fields
 */
add_filter('wpcf7_form_tag', function ($tag) {
    $datas = [];
    foreach ((array)$tag['options'] as $option) {
        if (strpos($option, 'data-') === 0) {
            $option = explode(':', $option, 2);
            $data_attribute = $option[0];
            $data_value = str_replace('|', ' ', $option[1]);
            $datas[$data_attribute] = apply_filters('wpcf7_option_value', $data_value, $data_attribute);
        }
    }
    if (!empty($datas)) {
        $id = $name = ($tag['basetype'] == 'select') ? "{$tag['name']}[]" : $tag['name'];
        add_filter('wpcf7_form_elements', function ($content) use ($name, $id, $datas) {
            return str_replace($id, $name, str_replace("name=\"$id\"", "name=\"$name\" " . wpcf7_format_atts($datas), $content));
        });
    }
    return $tag;
});



/**
 * Get posts archive years
 */
function lb_get_post_typologies()
{
    $items = [];
    $typologies = get_terms([
        'taxonomy' => 'lb-post-typology',
        'hide_empty' => false,
    ]);

    foreach ($typologies as $typology) {
        $items[] = [
            'label' => $typology->name,
            'value' => $typology->term_id,
        ];
    }

    return $items;
}



/**
 * Get posts archive years
 */
function lb_get_posts_archive_years()
{
    $years = array();
    $years_args = array(
        'type' => 'yearly',
        'format' => 'custom',
        'before' => '',
        'after' => '|',
        'echo' => false,
        'post_type' => 'post',
    );

    // Get Years
    $years_content = wp_get_archives($years_args);
    if (!empty($years_content)) {
        $years_arr = explode('|', $years_content);
        $years_arr = array_filter($years_arr, function ($item) {
            return trim($item) !== '';
        }); // Remove empty whitespace item from array

        foreach ($years_arr as $year_item) {
            $year_row = trim($year_item);
            preg_match('/href=["\']?([^"\'>]+)["\']>(.+)<\/a>/', $year_row, $year_vars);

            if (!empty($year_vars)) {
                $years[] = array(
                    'label' => $year_vars[2],
                    'value' => $year_vars[2]
                );
            }
        }
    }

    return $years;
}



/**
 * Get header and menu
 */
function lb_header()
{
    $lang_selector = do_shortcode('[wpml_language_selector_widget]');

    return array(
        'language_selector' => (!empty($lang_selector)) ? true : false,
        'header_links' => ['items' => (new Option())->getHeaderLinks()],
        'mobile_search' => [
            'type' => 'search',
            'name' => 'search',
            'label' => __('Cerca un prodotto, una linea...', 'labo-suisse-theme'),
            'disabled' => false,
            'required' => false,
            'buttonTypeNext' => 'button',
            'variants' => ['secondary'],
        ],
        'menu_desktop' => ['items' => Menu::desktop()],
        'menu_mobile' => ['items' => Menu::mobile()],
    );
}



/**
 * Get footer and prefooter
 */
function lb_footer()
{
    return MenuFooter::get();
}

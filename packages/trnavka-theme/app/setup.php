<?php

/**
 * Theme setup.
 */

namespace App;

use App\Entity\Campaign;
use App\Metabox\CampaignMetabox;
use App\Metabox\FinancialSubjectMetabox;
use App\Metabox\SmallThumbnailMetabox;
use App\Repositories\CampaignRepository;
use function Roots\bundle;
use function Roots\view;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();

//    wp_dequeue_style('wp-block-library');
//    wp_dequeue_style('wp-block-library-theme');
//    wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
}, 100);

add_action('admin_enqueue_scripts', function (): void {
    bundle('media')->enqueue();
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     *
     * @link https://roots.io/plugins/soil/
     */
//    add_theme_support( 'soil', [
//        'clean-up',
//        'nav-walker',
//        'nice-search',
//        'relative-urls',
//    ] );

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
//    add_theme_support( 'post-thumbnails' );

    /**
     * Enable responsive embed support.
     *
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
     */
//    add_theme_support( 'responsive-embeds' );

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    add_theme_support('disable-custom-colors');

    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
//    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
//    add_theme_support( 'customize-selective-refresh-widgets' );
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
            'name' => __('Primary', 'sage'),
            'id' => 'sidebar-primary',
        ] + $config);

    register_sidebar([
            'name' => __('Footer', 'sage'),
            'id' => 'sidebar-footer',
        ] + $config);
});

add_filter('rest_authentication_errors', function (
    $result
) {
    // If a previous authentication check was applied,
    // pass that result along without modification.
    if (true === $result || is_wp_error($result)) {
        return $result;
    }

    // No authentication has been performed yet.
    // Return an error if user is not logged in.
    if (!is_user_logged_in()) {
        return new \WP_Error(
            'rest_not_logged_in',
            __('You are not currently logged in.'),
            array('status' => 401)
        );
    }

    // Our custom authentication check should have no effect
    // on logged-in requests
    return $result;
});

add_filter('xmlrpc_enabled', '__return_false');

// Disable all xml-rpc endpoints
add_filter('xmlrpc_methods', function () {
    return [];
}, PHP_INT_MAX);

// remove some meta tags from WordPress
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

//remove json api capabilities
add_action('after_setup_theme', function () {

    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    add_filter('embed_oembed_discover', '__return_false');

    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
});

//completely disable json api
add_action('after_setup_theme', function () {

    // Filters for WP-API version 1.x
    add_filter('json_enabled', '__return_false');
    add_filter('json_jsonp_enabled', '__return_false');

    // Filters for WP-API version 2.x
    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
});

// Remove auto generated feed links
add_action('after_setup_theme', function () {
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
});

add_filter('wp_resource_hints', function (
    $hints,
    $relation_type
) {
    if ('dns-prefetch' === $relation_type) {
        return array_diff(wp_dependencies_unique_hosts(), $hints);
    }

    return $hints;
}, 10, 2);

//remove emoji scripts from head
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action('wp_head', 'rel_canonical');

add_action('init', function () {
    header("Access-Control-Allow-Origin: *");

    add_rewrite_rule('dajnato-form/?$', 'index.php?static_template=dajnato-form', 'top');

    // Not required. Just here for easier local development.
    flush_rewrite_rules();

    if (!is_admin() && 'productions' === WP_ENV) {
        wp_deregister_script('jquery');
//        wp_register_script('jquery', false);
    }

    register_post_status('archived', [
        'label' => _x('Archived', 'post'),
        'label_count' => _n_noop('Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>'),
        'public' => true,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true
    ]);

    if (is_admin()) {
        $campaignRepository = new CampaignRepository();

        $defaultAttributes = [
            'dajnato-cta' => [
                'title' => [
                    'type' => 'string',
                    'default' => 'Chcem podporiť Daj na to!'
                ],
                'button' => [
                    'type' => 'string',
                    'default' => 'Pokračovať'
                ],
                'button_url' => [
                    'type' => 'string',
                    'default' => ''
                ],
                'campaign_id' => [
                    'type' => 'string',
                    'default' => '',
                ],
                'campaigns' => [
                    'type' => 'array',
                    'default' => collect($campaignRepository->findAll())->map(fn(
                        Campaign $campaign
                    ) => [
                        'id' => $campaign->id,
                        'title' => $campaign->title,
                    ])->toArray()
                ],
            ]
        ];
    }

    foreach (scandir(TEMPLATEPATH . '/resources/views/blocks/') as $filename) {
        preg_match('~([a-zA-Z0-9-]+)\.blade\.php~', $filename, $matches);

        if (isset($matches[1])) {
            register_block_type('theme/' . $matches[1] . '-block', [
                'attributes' => $defaultAttributes[$matches[1]] ?? [],
                'render_callback' => fn(
                    $attributes,
                    $content
                ): string => view('blocks/' . $matches[1], compact('attributes', 'content'))->render()
            ]);
        }
    }
});

add_filter('query_vars', function (
    $queryVars
) {
    $queryVars[] = 'static_template';
    $queryVars[] = 'campaign_id';
    $queryVars[] = 'campaign_value';

    return $queryVars;
});

add_action('template_include', function (
    $template
) {
    $staticQueryVarValue = get_query_var('static_template');

    if ('dajnato-form' === $staticQueryVarValue) {
//dd(get_stylesheet_directory() . "/static-templates/resources/views/campaign.blade.php");
        return get_stylesheet_directory() . "/resources/views/dajnato-form.blade.php";
    }

    return $template;
});

add_theme_support('post-thumbnails');
add_filter('big_image_size_threshold', function () {
    return 3000;
});

add_action('admin_footer-edit.php', function () {
    echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"archived\">Archived</option>' );
        });
        </script>";
});

$addArchivedPostStatus = function () {
    global $post;

    if ($post->post_type === 'campaign') {
        if ($post->post_status === 'archived') {
            echo '
                <script>
                jQuery(document).ready(function($){
                    $("#post-status-display").text(" Archived");
                    $("select#post_status").append("<option value=\"publish\">Published</option>");
                });
                </script>';
        }

        echo '
            <script>
            jQuery(document).ready(function($){
                $("select#post_status").append("<option value=\"archived\" ' . selected($post->post_status, 'archived', false) . '>Archived</option>");
            });
            </script>';
    }
};

add_action('post_submitbox_misc_actions', $addArchivedPostStatus, 0);

new CampaignMetabox();
new SmallThumbnailMetabox();
new FinancialSubjectMetabox();

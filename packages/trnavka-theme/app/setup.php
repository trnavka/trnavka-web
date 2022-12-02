<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', function () {
    bundle( 'app' )->enqueue();

    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
}, 100 );

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action( 'enqueue_block_editor_assets', function () {
    bundle( 'editor' )->enqueue();
}, 100 );

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action( 'after_setup_theme', function () {
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
    remove_theme_support( 'block-templates' );

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus( [
        'primary_navigation' => __( 'Primary Navigation', 'sage' ),
    ] );

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support( 'core-block-patterns' );

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support( 'title-tag' );

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
    add_theme_support( 'html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ] );

    add_theme_support( 'editor-color-palette' );
    add_theme_support( 'disable-custom-colors' );

    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
    remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
//    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
//    add_theme_support( 'customize-selective-refresh-widgets' );
}, 20 );

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action( 'widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ];

    register_sidebar( [
                          'name' => __( 'Primary', 'sage' ),
                          'id'   => 'sidebar-primary',
                      ] + $config );

    register_sidebar( [
                          'name' => __( 'Footer', 'sage' ),
                          'id'   => 'sidebar-footer',
                      ] + $config );
} );

add_filter( 'rest_authentication_errors', function ( $result ) {
    // If a previous authentication check was applied,
    // pass that result along without modification.
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }

    // No authentication has been performed yet.
    // Return an error if user is not logged in.
    if ( ! is_user_logged_in() ) {
        return new \WP_Error(
            'rest_not_logged_in',
            __( 'You are not currently logged in.' ),
            array( 'status' => 401 )
        );
    }

    // Our custom authentication check should have no effect
    // on logged-in requests
    return $result;
} );

add_filter( 'xmlrpc_enabled', '__return_false' );

// Disable all xml-rpc endpoints
add_filter( 'xmlrpc_methods', function () {
    return [];
}, PHP_INT_MAX );

// remove some meta tags from WordPress
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

//remove json api capabilities
add_action( 'after_setup_theme', function () {

    // Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Turn off oEmbed auto discovery.
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Don't filter oEmbed results.
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
} );

//completely disable json api
add_action( 'after_setup_theme', function () {

    // Filters for WP-API version 1.x
    add_filter( 'json_enabled', '__return_false' );
    add_filter( 'json_jsonp_enabled', '__return_false' );

    // Filters for WP-API version 2.x
    add_filter( 'rest_enabled', '__return_false' );
    add_filter( 'rest_jsonp_enabled', '__return_false' );
} );

// Remove auto generated feed links
add_action( 'after_setup_theme', function () {
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'feed_links', 2 );
} );

add_filter( 'wp_resource_hints', function ( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }

    return $hints;
}, 10, 2 );

//remove emoji scripts from head
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_action( 'init', function () {
    header("Access-Control-Allow-Origin: *");

    if (!is_admin() && 'productions' === WP_ENV) {
        wp_deregister_script('jquery');
//        wp_register_script('jquery', false);
    }

    $labels  = [
        'name'          => _x( 'Kampane', 'Daj na to campaign pluarl name' ),
        'singular_name' => _x( 'Kampaň', 'Daj na to campaign singular name' ),
        'add_new'       => _x( 'Pridať novú kampaň', 'Daj na to campaign add button' ),
    ];
    $rewrite = [
        'slug'       => 'dajnato',
        'with_front' => false,
    ];
    $args    = [
        'labels'       => $labels,
        'show_in_rest' => true,
        'supports'     => [ 'title', /*'editor', 'custom-fields'*/ ],
        'hierarchical' => false,
        'public'       => true,
        'has_archive'  => false,
        'rewrite'      => $rewrite,
    ];
    register_post_type( 'campaign', $args );
} );

add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'dajnato_campaign_meta_box', // $id
        'Daj na to kampaň', // $title
        function () {
            global $post;
            $meta = get_post_meta( $post->ID, 'dajnato_campaign', true ); ?>

            <input type="hidden" name="dajnato_campaign_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>">

            <style>
                .form-group {
                    margin-bottom: 20px;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                }
            </style>

            <div class="form-group">
                <label for="dajnato_campaign[goal_amount]">Cieľová suma</label>
                <input type="number" name="dajnato_campaign[goal_amount]" id="dajnato_campaign[goal_amount]" class="regular-text" value="<?php echo esc_html($meta['goal_amount'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="dajnato_campaign[start_amount]">Úvodná suma</label>
                <input type="number" name="dajnato_campaign[start_amount]" id="dajnato_campaign[start_amount]" class="regular-text" value="<?php echo esc_html($meta['start_amount'] ?? 0); ?>">
            </div>

            <div class="form-group">
                <label for="dajnato_campaign[darujme_id]">ID kampane na darujme.sk</label>
                <input type="text" name="dajnato_campaign[darujme_id]" id="dajnato_campaign[darujme_id]" class="regular-text" value="<?php echo esc_html($meta['darujme_id'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="dajnato_campaign[darujme_feed_id]">ID feedu darov na darujme.sk</label>
                <input type="text" name="dajnato_campaign[darujme_feed_id]" id="dajnato_campaign[darujme_feed_id]" class="regular-text" value="<?php echo esc_html($meta['darujme_feed_id'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="dajnato_campaign[short_description]">Krátky popis</label>
                <textarea name="dajnato_campaign[short_description]" id="dajnato_campaign[short_description]" style="width: 100%;" rows="5"><?php echo esc_html($meta['short_description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="dajnato_campaign[content]">Detailný popis</label>
                <?php
                wp_editor( $meta['content'] ?? '', 'dajnato_campaign_content_editor', array(
                    'wpautop'       => true,
                    'media_buttons' => false,
                    'textarea_name' => 'dajnato_campaign[content]',
                    'textarea_rows' => 10,
                    'teeny'         => true
                ) );
                ?>
            </div>
            <!-- All fields will go here -->

        <?php }, // $callback
        'campaign', // $screen
        'advanced', // $context
        'high' // $priority
    );
} );

add_action( 'save_post', function ( $postId ) {
    if ( array_key_exists( 'dajnato_campaign', $_POST ) ) {

        update_post_meta(
            $postId,
            'dajnato_campaign',
            $_POST['dajnato_campaign']
        );
    }
} );

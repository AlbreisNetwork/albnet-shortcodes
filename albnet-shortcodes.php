<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Albnet Shortcodes
 * 
 * @package Albnet
 * @author Albreis Network
 * @copyright 2018 Albreis Network
 * @license GPL 3.0
 * 
 * @wordpress-plugin
 * Plugin Name: Albnet Shortcodes
 * Plugin URI: https://shortcodes.albreis.com.br
 * Description: A lot of shortcodes to show posts
 * Version: 1.0.2
 * Author: Albreis Network <contato@albreis.com.br>
 * Author URI: https://albreis.com.br
 * Text Domain: albnet-shortcodes
 * Domain Path: /languages
 * License: GPL 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Load settings page
 */
require 'settings/init.php';

/**
 * Add admin menu
 */
add_action( 'admin_menu', function(){
    
  add_menu_page( 'Albnet Shortcodes', 'Albnet Shortcodes', 'publish_posts', 'albnet_shortcodes', function(){
    require 'settings/index.php';
  }, 'dashicons-schedule', 0 );

} );


/**
 * Load JS e CSS
 */
function albnet_shortcodes_scripts() {

    wp_enqueue_script( 'ui-kit-js', plugin_dir_url(__FILE__) . '/js/uikit.min.js', null, time(), true);
    wp_enqueue_script( 'ui-kit-js-icons', plugin_dir_url(__FILE__) . '/js/uikit-icons.min.js', null, time(), true);
    wp_enqueue_style( 'ui-kit-css', plugin_dir_url(__FILE__) . '/css/uikit.min.css', null, time(), 'all', true);
    wp_enqueue_style( 'style-albnet-shortcodes', plugin_dir_url(__FILE__) . '/style.css', null, time(), 'all', true);

}
add_action( 'wp_enqueue_scripts', 'albnet_shortcodes_scripts' );

/**
 * Images sizes
 */
add_image_size( '720x380', 720, 380, true );
add_image_size( '360x360', 360, 360, true );
add_image_size( '320x240', 320, 240, true );
add_image_size( '120x120', 120, 120, true );


/**
 * Load shortcodes
 */
add_shortcode('albnet_shortcodes', 'albnet_shortcodes');

function albnet_shortcodes($atts = []){

    $a = shortcode_atts( [
        // Layout
        'layout' => 'card',

        // Show Ads
        'show_ads' => false,

        // Interval in the loop to show ads
        'ads_step' => 3,

        // Thumbnail size
        'image_size' => '720x380',

        // Section title
        'title' => 'Vídeos',

        // Post type
        'post_type'=>'post',

        // Number of posts to show
        'posts_per_page' => 4,

        // Current page
        'paged' => '',

        // Show pagination? Only if "paged" is set
        'show_pagination' => false,

        // Start loop from (ignored if "paged" is set)
        'offset' => 0,

        // Taxonomy
        'taxonomy' => 'category',

        // Taxonomy field for filtering
        'field' => 'slug',

        // Taxonomy value (depends on filter)
        'terms' => '',

        //Show only posts with featured images?
        'only_with_thumb' => false,

        // Show post thumbnail?
        'show_thumb' => true,

        // Show vídeo iframe if post has it
        'show_video' => true,

        // Show post title?
        'show_title' => true,

        // Show post excerpt?
        'show_excerpt' => false,

        // Show post author?
        'show_author' => false,

        // Show post date?
        'show_date' => false,

        // Show post times ago?
        'show_times_ago' => false,

        // Show post category?
        'show_category' => false,

        // Show post comments?
        'show_comments' => false,

        // Icon to show before title
        'title_icon' => '',

        // Class of loop's container
        'container_class' => '',

        // Class for items inside loop
        'item_class' => ''
    ], $atts );

    /**
     * For show is required Albet Video plugin
     */
    if($a['show_video'] || $a['post_type'] == 'videos') {
        if ( ! is_plugin_active( 'albnet-videos/albnet-videos.php' ) && current_user_can( 'activate_plugins' ) ) {
            echo ('Sorry, but this plugin requires the Albnet Vídeos to be installed and active.');
        } else {            
            include 'shortcode-' . $a['layout'] . '.php';
        }
    }
    
}

function albnet_get_args($a) {
    
    /**
     * Post type
     */
    $args['post_type'] = $a['post_type'];

    /**
     * Posts per page
     */
    $args['posts_per_page'] = $a['posts_per_page'];

    /**
     * Current page
     */
    $args['paged'] = $a['paged'];

    /**
     * Check if has paged
     */
    if(!$args['paged']) {
        /**
         * If paged remove offset setting
         */
        $args['offset'] = $a['offset'];
    }

    /**
     * Show only posts with featured images
     */
    if($a['only_with_thumb']) {
        $args['meta_query'] = [
            [
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            ],
        ];
    }

    /**
     * Remove offset setting if is paginated
     */
    if($a['paged']) {
        unset($args['offset']);
    }
    
    /**
     * Check if has fields to filter by taxonomy
     */
    if($a['taxonomy'] && $a['field'] && $a['terms']) {
        $args['tax_query'] = [
            [
                'taxonomy' => $a['taxonomy'],
                'field' => $a['field'],
                'terms' => $a['terms']
            ]
        ];
    }

    return $args;
}
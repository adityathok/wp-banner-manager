<?php
/**
 * A file that defines a function for public
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/public
 */

// register shortcode
require plugin_dir_path( __FILE__ ) . 'shortcode.php';

if ( ! function_exists( 'wp_banner_manager_public_enqueue' ) ) {
    /**
     *
     * Register enqueue file for public area
     * with WordPress.
     *
     * @since    1.0.0
     */
	function wp_banner_manager_public_enqueue() {
		wp_enqueue_style( 'wp-banner-manager-public-styles', plugin_dir_url(__FILE__) . 'css/public.min.css', array(), WP_BANNER_MANAGER_VERSION, false );
        wp_enqueue_script( 'jquery');
        wp_enqueue_script( 'wp-banner-manager-public-script', plugin_dir_url(__FILE__) . 'js/public.js', array('jquery'), WP_BANNER_MANAGER_VERSION, true );
        wp_localize_script( 'wp-banner-manager-public-script', 'wpbannermanager_ajax',
            array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            )
        );
    }
} // endif function_exists( 'wp_banner_manager_public_enqueue' ).
add_action( 'wp_enqueue_scripts', 'wp_banner_manager_public_enqueue' );
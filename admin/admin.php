<?php
/**
 * A file that defines a function for admin
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/admin
 */


// register post type and metabox
require plugin_dir_path( __FILE__ ) . 'post-type.php';

// register metabox callback wpbannerman_display_main_metabox
require plugin_dir_path( __FILE__ ) . 'metabox-callback-main.php';

// register metabox callback wpbannerman_display_sideback
require plugin_dir_path( __FILE__ ) . 'metabox-callback-sideback.php';

// register metabox callback wpbannerman_display_sideback
require plugin_dir_path( __FILE__ ) . 'metabox-callback-statistic.php';

// register save custom metabox
require plugin_dir_path( __FILE__ ) . 'save-post.php';


if ( ! function_exists( 'wp_banner_manager_admin_enqueue' ) ) {
    /**
     *
     * Register enqueue file for admin area
     * with WordPress.
     *
     * @since    1.0.0
     */
    function wp_banner_manager_admin_enqueue($hook) {

        global $post;
        if ( isset($post->post_type) && 'wpbannerman' != $post->post_type ) {
            return;
        }

        wp_enqueue_script('wp-banner-manager-admin-script', plugin_dir_url(__FILE__) . 'js/admin.js');
        wp_enqueue_script('wp-banner-manager-admin-chartjs', plugin_dir_url(__FILE__) . 'js/chartjs.js');
        wp_enqueue_style( 'wp-banner-manager-admin-style', plugin_dir_url(__FILE__) . 'css/admin.css');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        wp_localize_script( 'wp-banner-manager-admin-script', 'wpbannermanager_ajax',
            array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            )
        );

        if(isset($post->ID)) {
            wp_enqueue_media(array(
                'post' => $post->ID,
            ));
        }
    }
}
// endif function_exists( 'wp_banner_manager_admin_enqueue' ).
add_action('admin_enqueue_scripts', 'wp_banner_manager_admin_enqueue');

///add action when delete post
add_action( 'before_delete_post', 'wpbannerman_delete_banner_post' );
function wpbannerman_delete_banner_post( $postid ) {
 
    global $post_type;   
 
    if ( 'wpbannerman' !== $post_type ) {
        return;
    }
 
    // Delete data hits
    $hits   = New Wpbannerman_hits;
    $hits->deleteDataByPostId($postid);
    $click  = New Wpbannerman_click;
    $click->deleteDataByPostId($postid);

}
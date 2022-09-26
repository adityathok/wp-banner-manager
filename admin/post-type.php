<?php
/**
 * A file that defines a function for post type registration
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/admin
 */

/**
 * Register the Custom Post type.
 *
 * @since    1.0.0
 */
function wp_banner_manager_register_post_type() {

    register_post_type('wpbannerman', array(
        'labels' => array(
            'name' => 'My Banner',
            'singular_name' => 'wpbannerman',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Banner',
            'edit_item' => 'Edit Banner',
            'view_item' => 'View Banner',
            'search_items' => 'Search Banner',
            'not_found' => 'Banner Not Found',
            'not_found_in_trash' => 'Banner Not Found in Trash',
        ),
        'menu_icon' => 'dashicons-images-alt2',
        'public' => true,
        'exclude_from_search' => true,
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'publicly_queryable'  => false,
        'query_var'           => false,
        'supports' => array(
            'title',
        ),
    ));

}
add_action('init', 'wp_banner_manager_register_post_type');

/**
 * register meta box.
 *
 * @since    1.0.0
 */
function wp_banner_manager_add_meta_box() {
    add_meta_box(
        'wpbannerman-meta', 
        'Detail Banner', 
        'wpbannerman_display_main_metabox', 
        'wpbannerman',
        'normal',
        'high',
        ''
    );
    add_meta_box(
        'wpbannerman-statistic', 
        'Statistics Banner', 
        'wpbannerman_display_statistic', 
        'wpbannerman',
        'normal',
        'high',
        ''
    );
    add_meta_box(
        'wpbannerman-meta-side', 
        'Shortcode Banner', 
        'wpbannerman_display_sideback', 
        'wpbannerman',
        'side',
        'high',
        ''
    );
}
add_action( 'add_meta_boxes', 'wp_banner_manager_add_meta_box' );

/**
 * register Custom columns.
 *
 * @since    1.0.0
 */
add_filter( 'manage_wpbannerman_posts_columns', 'set_custom_edit_wpbannerman_columns' );
function set_custom_edit_wpbannerman_columns($columns) {
    $columns['shortcode']   = __( 'Shortcode', 'wpbannerman' );
    $columns['hit']         = __( 'Hit', 'wpbannerman' );
    return $columns;
}
add_action( 'manage_wpbannerman_posts_custom_column' , 'custom_wpbannerman_column', 25, 2 );
function custom_wpbannerman_column( $column, $post_id ) {
    switch ( $column ) {
        case 'shortcode' :
            echo '[wpbannerman id="'.$post_id.'"]';
            break;
        case 'hit' :
            $hits = New Wpbannerman_hits;
            echo $hits->view($post_id);
            break;
    }
}
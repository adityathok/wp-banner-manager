<?php
/**
 * A file that defines a function for wpbannerman_save_post_class_meta
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/admin
 */


if ( ! function_exists( 'wpbannerman_save_post_class_meta' ) ) {

    add_action( 'save_post', 'wpbannerman_save_post_class_meta', 10, 2 );

    function wpbannerman_save_post_class_meta( $post_id, $post ) {

        if (isset($post->post_type) && $post->post_type != 'wpbannerman') {
            return;
        }

        /* Verify the nonce before proceeding. */
        if ( !isset( $_POST['wpbannerman_post_nonce'] ) || !wp_verify_nonce( $_POST['wpbannerman_post_nonce'], 'wpbannerman_post_nonce' ) )
        return $post_id;

        /* Get the post type object. */
        $post_type = get_post_type_object( $post->post_type );

        /* Check if the current user has permission to edit the post. */
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

        /* save meta wpbannerman-media. */
        $media_value = ( isset( $_POST['wpbannerman-media'] ) ? $_POST['wpbannerman-media'] : '' );
        update_post_meta( $post_id, 'wpbannerman-media', $media_value ); 
         
        /* save meta wpbannerman-link. */
        $link_value = ( isset( $_POST['wpbannerman-link'] ) ? $_POST['wpbannerman-link'] : '' );
        update_post_meta( $post_id, 'wpbannerman-link', $link_value );      

    } 

}
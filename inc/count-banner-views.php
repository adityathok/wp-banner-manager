<?php
//
if ( ! function_exists( 'count_wpbannerman_views' ) ) {
    /**
     *
     * Counter for views of banner
     *
     * @since 1.0.0
     */
    function count_wpbannerman_views($post_id=null) {
        if(empty($post_id)){
            return false;
        }

        if ( current_user_can('administrator') ) {
            return false;
        }

        $count_key  = 'hit';
        $count      = (int) get_post_meta( $post_id, $count_key, true );

        $count++;

        update_post_meta( $post_id, $count_key, $count );

    }
}

if ( ! function_exists( 'wpbannerman_get_hit' ) ) {
    function wpbannerman_get_hit() {

        $count = get_post_meta( get_the_ID(), 'hit', true );
        return $count;

    }
}
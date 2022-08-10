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

        //update post meta
        $count = (int) get_post_meta( $post_id, 'hit', true );
        $count++;
        update_post_meta( $post_id, $count_key, $count );

        //database update
        global $wp;
        $url    =  $wp->request;
        $hits   = New Wpbannerman_hits;
        $hits->add($post_id,$url);
    }
}

if ( ! function_exists( 'wpbannerman_get_hit' ) ) {
    function wpbannerman_get_hit() {

        $count = get_post_meta( get_the_ID(), 'hit', true );
        return $count;

    }
}
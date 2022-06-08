<?php
/**
 * A file that defines a function for wpbannerman_display_main_metabox
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/admin
 */

function wpbannerman_display_main_metabox() {

    $getId      = isset($_GET['post'])?$_GET['post']:'';
    $metamedia  = get_post_meta( $getId, 'wpbannerman-media', true );
    print_r($metamedia);

    wp_nonce_field( 'wpbannerman_post_nonce', 'wpbannerman_post_nonce' );
    ?>
    <div class="wpbannerman-metabox">
        <div class="wpbannerman-main-upload">
            <div class="wpbannerman-main">
                <input class="wpbannerman-media-id" name="wpbannerman-media[id]" value="" type="hidden">
                <input class="wpbannerman-media-url" name="wpbannerman-media[url]" value="" type="hidden">
            </div>
            <div class="publishing-action">
                <span class="wpbannerman-delete-btn button button-large"> Delete Image</span>
                <span class="wpbannerman-upload-btn button button-primary button-large"> Upload Image</span>
            </div>
        </div>
    </div>
    <?php

}
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
    $nodeid     = uniqid();
    $metamedia  = get_post_meta( $getId, 'wpbannerman-media', true );
    $imageid    = $metamedia&&isset($metamedia['id'])?$metamedia['id']:'';
    $imageurl   = $metamedia&&isset($metamedia['url'])?$metamedia['url']:'';
    $urlmedia   = $imageid?wp_get_attachment_image_url( $metamedia['id'], 'full' ):'';
    $hasimage   = $imageid?'has-image':'';

    wp_nonce_field( 'wpbannerman_post_nonce', 'wpbannerman_post_nonce' );
    ?>
    <div class="wpbannerman-metabox">
        <div class="wpbannerman-main-upload <?php echo $hasimage;?>">
            <div class="wpbannerman-main-image">
                <div class="wpbannerman-box-image">
                <?php if($imageurl): ?>
                    <div class="wpbannerman-image wpbannerman-image-<?php echo $imageid;?>" data-node="<?php echo $nodeid;?>" data-id="<?php echo $imageid;?>">
                        <img src="<?php echo $imageurl;?>" alt="">
                    </div>
                <?php endif; ?>
                </div>
                <input class="wpbannerman-media-id" name="wpbannerman-media[id]" value="<?php echo $imageid;?>" type="hidden">
                <input class="wpbannerman-media-url" name="wpbannerman-media[url]" value="<?php echo $urlmedia;?>" type="hidden">
                <div>
                    <span class="wpbannerman-delete-btn button button-large"> Delete Image </span>
                </div>
            </div>
            <div class="wpbannerman-button-upload">
                <div class="wpbannerman-upload-btn"> 
                    <span class="dashicons dashicons-upload"></span> Upload Image
                </div>
            </div>
        </div>
    </div>
    <?php

}
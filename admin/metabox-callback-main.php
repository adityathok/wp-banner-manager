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
    $imageid    = $metamedia&&isset($metamedia[0])?$metamedia[0]:'';
    $mediaurl   = $imageid?wp_get_attachment_image_url( $imageid, 'full' ):'';
    $hasimage   = $imageid?'has-image':'';
    $metalink   = get_post_meta( $getId, 'wpbannerman-link', true );
    $linkurl    = $metalink&&isset($metalink['url'])?$metalink['url']:'';
    $linktarget = $metalink&&isset($metalink['target'])&&$metalink['target']=='blank'?'checked':'';

    wp_nonce_field( 'wpbannerman_post_nonce', 'wpbannerman_post_nonce' );
    ?>
    <div class="wpbannerman-metabox">
        <div class="wpbannerman-main-upload <?php echo $hasimage;?>">
            <div class="wpbannerman-main-image">
                <div class="wpbannerman-box-image">
                <?php if($mediaurl): ?>
                    <div class="wpbannerman-image wpbannerman-image-<?php echo $imageid;?>" data-node="<?php echo $nodeid;?>" data-id="<?php echo $imageid;?>">
                        <img src="<?php echo $mediaurl;?>" alt="">
                        <input class="wpbannerman-media-id" name="wpbannerman-media[]" value="<?php echo $imageid;?>" type="hidden">
                        <div class="wpbannerman-delete-btn"> <span class="dashicons dashicons-dismiss"></span> </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
            <div class="wpbannerman-button-upload">
                <div class="wpbannerman-upload-btn"> 
                    <span class="dashicons dashicons-upload"></span> Upload Image
                </div>
            </div>
            <div class="wpbannerman-main-input">
                <h3>Banner Attribute</h3>
                <p>Add banner attribute in here</p>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"> Link </th>
                            <td>
                                <input type="text" value="<?php echo $linkurl;?>" id="wpbannerman-link-url" name="wpbannerman-link[url]" class="regular-text">
                                <br>
                                <span class="description">Add link when banner is clicked.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"> Link Target </th>
                            <td>
                                <label>
                                    <input type="checkbox" value="blank" name="wpbannerman-link[target]" id="wpbannerman-link-target" <?php echo $linktarget;?>>
                                    Blank
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php

}
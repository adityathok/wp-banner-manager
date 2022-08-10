<?php
/**
 * A file that defines a function for shortcode
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/public
 */

if ( ! function_exists( 'wp_banner_manager_wpbannerman_shortcode' ) ) {
    /**
     *
     * Register shortcode 
     * [wpbannerman id=""]
     *
     * @since    1.0.0
     */
	function wp_banner_manager_wpbannerman_shortcode($atts) {
        ob_start();
		$att        = shortcode_atts( array(
            'id'    => '',
        ), $atts );
        $id             = $att['id'];
        $nodeid         = 'wpbannerman'.uniqid();
        $datameta       = get_post_meta( $id, 'wpbannerman', true );

        $imageid        = $datameta&&isset($datameta['media'])?$datameta['media']:'';
        $mediaurl       = $imageid?wp_get_attachment_image_url( $imageid, 'full' ):'';

        $metalink       = $datameta&&isset($datameta['link'])?$datameta['link']:'';
        $linkurl        = $metalink&&isset($metalink['url'])?$metalink['url']:'';
        $linktarget     = $metalink&&isset($metalink['target'])&&$metalink['target']=='blank'?'_blank':'';
        
        $infobanner     = isset($datameta['info'])?$datameta['info']:'';
        $closebutton    = isset($datameta['closebutton'])?$datameta['closebutton']:'';
        ?>
        <div class="wpbannerman-object <?php echo $nodeid;?>" data-node="<?php echo $nodeid;?>" data-id="<?php echo $id;?>">
            <?php if($mediaurl): ?>                
                <div class="wpbannerman-image">

                    <?php if($linkurl ): ?>
                        <a href="<?php echo $linkurl;?>" target="<?php echo $linktarget;?>">
                    <?php endif; ?>

                    <img src="<?php echo $mediaurl;?>" alt="">

                    <?php if($linkurl ): ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if($infobanner): ?>
                        <span class="wpbannerman-info">
                            <span class="wpbannerman-info-icon">i</span>
                            <div class="wpbannerman-info-bubble">
                                <?php echo $infobanner;?>
                            </div>
                        </span>
                    <?php endif; ?>

                    <?php if($closebutton=='true'): ?>
                        <span class="wpbannerman-close-btn" data-node="<?php echo $nodeid;?>">
                            <span class="wpbannerman-close-icon">x</span>
                        </span>
                    <?php endif; ?>

                </div>
            <?php else: ?>
                <div class="wpbannerman-no-image">
                    No image available
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
	}
    add_shortcode( 'wpbannerman', 'wp_banner_manager_wpbannerman_shortcode' );
} 
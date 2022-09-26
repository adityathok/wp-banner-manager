<?php
/**
 * A file that defines a function for wpbannerman_display_sideback
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/admin
 */

 function wpbannerman_display_sideback( $post ) {
    $getId      = isset($_GET['post'])?$_GET['post']:'';
    $shortcode  = $getId?'[wpbannerman id="'.$getId.'"]':'';
    ?>
    <div class="atbanner-meta-side">
        <p>Copy and paste this shortcode to display the banner.</p>
        <input type="text" value='<?php echo $shortcode; ?>' readonly="readonly" class="widefat" onfocus="this.select();" />
    </div>
    <?php
 }
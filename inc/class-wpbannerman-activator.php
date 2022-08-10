<?php
/**
 * Fired during plugin activation
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class Wpbannerman_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        self::create_db_wpbannerman();
	}

    public static function create_db_wpbannerman() {
        
        global $wpdb;
        $charset_collate    = $wpdb->get_charset_collate();
        $table_hits         = $wpdb->prefix . 'wpbannerman_hits';
        $sql                = "CREATE TABLE $table_hits (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            banner_id bigint(20) NOT NULL,
            uri varchar(255) NOT NULL,
            date date NOT NULL,
            hit bigint(20) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

}
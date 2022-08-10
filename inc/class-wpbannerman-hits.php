<?php
/**
 * Wpbannerman_Activator
 */
class Wpbannerman_hits {
    
    public $wpdb;
    private $table_name;

    function __construct() {
        global $wpdb;
        $this->wpdb         = $wpdb;
        $this->table_name   = $this->wpdb->prefix . 'wpbannerman_hits';
    }

    public static function create_db() {
        
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

    /// add data hits
    public function add($bannerid=null,$uri=null){
        if( $bannerid ) {
            $date = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
            //check if avalibe
            $getdata = $this->wpdb->get_results("SELECT * FROM $this->table_name WHERE banner_id = $bannerid AND uri = '$uri' AND date = '$date'");
            If(empty($getdata)) { //if empty. insert new data
                $this->wpdb->insert($this->table_name, array(
                    'banner_id'     => $bannerid,
                    'uri'           => $uri,
                    'date'          => $date,
                    'hit'           => 1,
                ) );
            } else {
                $this->wpdb->update($this->table_name, array(
                    'hit'           => $getdata[0]->hit + 1,
                ), array(
                    'banner_id'     => $bannerid,
                    'uri'           => $uri,
                ) );
            }
        }
    }

    
    public function get($query=null){
        
        $query = $query?' WHERE '.$query:'';
        
        $getdata = $this->wpdb->get_results("SELECT * FROM $this->table_name $query", ARRAY_A);
        return $getdata;
    }


}
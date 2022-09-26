<?php
/**
 * Wpbannerman_Activator
 */
class Wpbannerman_hits {
    
    public $wpdb;
    private $table_name;
    public $metakey = 'wpbannerman_hits';

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
            type varchar(180) NOT NULL,
            uri_id bigint(20) NOT NULL,
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

    public function deleteDataByPostId($post_id){
        
        if(empty($post_id))
        return false;

        $this->wpdb->delete( $this->table_name, array( 'banner_id' => $post_id ) );

    }

    public function addbyPostID($post_id){
        
        if(empty($post_id)){
            return false;
        }

        if ( current_user_can('administrator') ) {
            return false;
        }

        //update post meta
        $count_key = $this->metakey;
        $count = (int) get_post_meta( $post_id, $count_key, true );
        $count++;
        update_post_meta( $post_id, $count_key, $count );

        //database update
        global $wp;
        $url    = '/'.$wp->request;
        $this->add($post_id,$url);

    }
    
    public function view($post_id){
        
        if(empty($post_id))
        return false;

        $count = get_post_meta( $post_id, $this->metakey, true );
        return $count?$count:'0';

    }

}
<?php
/*
Plugin Name: Mentorship Matchmaking
Plugin URI: 
Description: Allows matchmaking between students and mentors
Version: 1.0
Author: Stepan Stepasyuk
Author URI: 
License: LGPL2
*/

register_activation_hook(__FILE__, "mntrsp_matchmaking_activate");
function mntrsp_matchmaking_activate() // Create a table for our plugin to store a list of all created posters
{
	global $wpdb;
	$table_name = $wpdb->prefix . "mntrsp_matchmaking";
	$sql = "CREATE TABLE $table_name (
	  id bigint(20) NOT NULL AUTO_INCREMENT,
	  creation_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  mentor_id bigint(20) NOT NULL,
	  mentor_name varchar(255) NOT NULL,
	  student_id bigint(20) NOT NULL,
	  student_name varchar(255) NOT NULL,
	  matched_by varchar(255) DEFAULT '' NOT NULL,
	  UNIQUE KEY id (id)
	);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

register_uninstall_hook(__FILE__, "mntrsp_matchmaking_uninstall");
function mntrsp_matchmaking_uninstall() // Let's clean up after ourselves
{
 // 	global $wpdb;

 //    $table_name = $wpdb->prefix . "mntrsp_matchmaking";
	// $wpdb->query("DROP TABLE IF EXISTS $table_name");

}


add_action('admin_menu', 'mntrsp_matchmaking_actions'); // Displays link to our settings page in the admin menu
function mntrsp_matchmaking_actions()
{
	add_options_page("Mentorship_matchmaking", "Mentorship Matchmaking", 1, "Mentorship_matchmaking", "mntrsp_matchmaking");    
}

add_action( 'admin_enqueue_scripts', 'mnt_admin_style' ); 
function mnt_admin_style($hook) // Link our already registered script only to settings page of our plugin
{ 
	 if( 'settings_page_Mentorship_matchmaking' != $hook ){
     	return;
     }else{
    	wp_register_style( 'mnt_admin_style', plugins_url( 'css/mnt_admin_style.css', __FILE__ ) );
    	wp_enqueue_style( 'mnt_admin_style' );
   }
}

function mntrsp_matchmaking() // Function that includes the actual settings page
{ 
	include('mentorship-matching-admin.php');
}

?>
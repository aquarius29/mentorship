<?php
/* Plugin Name: Pass parameters
Plugin URI: http://webopius.com/
Description: A plugin to allow parameters to be passed in the URL and recognized by WordPress
Author: Adam Boyse
Version: 1.0
Author URI: http://www.webopius.com/
*/
add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars( $qvars )
{
$qvars[] = 'form';
return $qvars;
}

// this plugin is used solely to pass the needed variable (form) into the registration form. 
// the usage is done in the file: wp-content/themes/firmasite/registration/register.php 
// around line 70
// use with responsibility! :)
?>

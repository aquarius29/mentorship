<?php
/*
Plugin Name: Site Plugin for mentorshipit.se
Description: nice additions to the mentorshipit.se site
*/
/* Start Adding Functions Below this Line */

/* Start of the mentorship widget 
    creating a widget which will contain:
	- user's profile info if the user is logged in
	- registrations and login buttons if the user is not logged in	*/

// Creating the widget 
class mentorship_widget extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'mentorship_widget', 

		// Widget name will appear in UI
		__('Mentorship Widget', '_domain'), 
	
		// Widget description
		array( 'description' => __( 'Displays user\' profile if loggedin or login+register buttons', 'wpb_widget_domain' ), ) 
	);
}

// Creating widget front-end
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );	
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

	// This is where you run the code and display the output
	if ( is_user_logged_in() ){ 
		global $bp;

//		echo __( 'Helloooo, there, we know you!', 'wpb_widget_domain' );	
		$member_id = $bp->loggedin_user->id;	?>
		<a href="<?php echo bp_core_get_user_domain( $member_id ) ?>" title="<?php echo $bp->loggedin_user->fullname ?>">
		<?php echo bp_core_fetch_avatar ( array( 'item_id' => $member_id, 'judy_type(array)e' => 'full' ) ) ?></a> 
		Hello <?php echo $bp->loggedin_user->fullname ?>
	<?php }else{ ?>
	<p>Register to participate in the IT Mentorship Program:</p>
	<p><a href="/mentorship/register?form=mentor"><button type="button" class="btn btn-warning">as MENTOR</button></a>
	<a href="/mentorship/register?form=student"><button type="button" class="btn btn-danger">as STUDENT</button></a></p>
        <p>If you have an account:<br>
	<a href="/mentorship/wp-login.php?action=login"><button type="button" class="btn btn-success">Login</button></a></p>	
	<?php }
	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	}else {
		$title = __( 'New title', 'wpb_widget_domain' );
	}
// Widget admin form
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
} // Class mentorship_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'mentorship_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


/* End of the mentorship widget */



/* Stop Adding Functions Below this Line */
?>

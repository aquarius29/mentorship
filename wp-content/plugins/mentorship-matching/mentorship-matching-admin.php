<?php

// Header for our settings page
$content = "<h2>" . __( 'Mentorship Match Making' ) . "</h2><hr />"; 

// Delete a match (by id) 
if(isset($_GET['unmatch']) && is_numeric($_GET['unmatch']))
{
	mnt_unmatch($_GET['unmatch']);
}

// Check if this request was a form submission
if(isset($_POST['mnt_save_changes']) && $_POST['mnt_save_changes'] == 'Y'){

	// If it was, check the values that we need and send them to db
	if(isset($_POST['mnt_mentor_select']) && isset($_POST['mnt_student_select'])) {

		$mentor_id = $_POST['mnt_mentor_select'];
		$student_id = $_POST['mnt_student_select'];
		mnt_match($mentor_id, $student_id);
	}

	// Say that settings are saved.
	$content .= '<div class="updated"><p>Changes saved</p></div>';
}

// Function for deleting a match
function mnt_unmatch($match_id){

	global $wpdb;
	$table_name = $wpdb->prefix . "mntrsp_matchmaking";

	$wpdb->delete($table_name, array( 'id' => $match_id));

}

// Function for creating a match
function mnt_match($mentor_id, $student_id){

	global $wpdb;
	$table_name = $wpdb->prefix . "mntrsp_matchmaking";

	$mentor_name = $wpdb->get_var("SELECT value FROM wp_bp_xprofile_data WHERE user_id = $mentor_id AND value != 'Mentor'");
	$student_name = $wpdb->get_var("SELECT value FROM wp_bp_xprofile_data WHERE user_id = $student_id AND value != 'Student'");

	$current_user = wp_get_current_user();

	$wpdb->insert($table_name, array( 
		'creation_date' => current_time('mysql'),
		'mentor_id' => mysql_real_escape_string($mentor_id), 
		'mentor_name' => mysql_real_escape_string($mentor_name),
		'student_id' => mysql_real_escape_string($student_id), 
		'student_name' => mysql_real_escape_string($student_name),
		'matched_by' => mysql_real_escape_string($current_user->user_login)
	));
}

// Function for getting either all students or mentors
function mentorship_get_everybody($who){

	global $wpdb;

	return $wpdb->get_results("SELECT user_id, value FROM wp_bp_xprofile_data WHERE user_id IN (SELECT user_id FROM wp_bp_xprofile_data WHERE value = '$who') AND value != '$who'");

}

// Get all existing matches
function mnt_get_matches(){

	global $wpdb;
	$table_name = $wpdb->prefix . "mntrsp_matchmaking";

	return $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
}

$students = mentorship_get_everybody('Student');
$mentors = mentorship_get_everybody('Mentor');

	// $content is a variable that holds the whole http response. 
	// Creating a submission form. Form consists of two drop down lists (one with students and one with mentors), a hidden service
	// input and a submit button	
	$content .= '<form name="mnt_matching_form" method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">';
	$content .= '<p><label for="mnt_student_select">Select a student</label>';
	$content .= '<div class="wrap"><select name="mnt_student_select" id="mnt_student_select">';

	// Filling first dropdown list with students
	foreach ( $students as $student ) // Print info about posters
	{					
		$content .= '<option value="'.$student->user_id.'">'.$student->value.'</option>';
	}
	$content .= '</select></p>';

	$content .= '<p><label for="mnt_mentor_select">Select a mentor</label>';
	$content .= '<div class="wrap"><select name="mnt_mentor_select" id="mnt_mentor_select">';

	// Filling the second one with mentors
	foreach ( $mentors as $mentor ) // Print info about posters
	{					
		$content .= '<option value="'.$mentor->user_id.'">'.$mentor->value.'</option>';
	}
	$content .= '</select></p>';

	$content .= '<p><input type="hidden" name="mnt_save_changes" value="Y" />';
	$content .= '<input type="submit" value="Make a Match" /></p></form>';

	// Building a table to display current matches.
	$content .= '<hr />';
	$content .= '<h2>Matches (if empty, try adding some users who are mentors or students)</h2>';
	$content .= '<table id="mnt_existing_matches" style="border:1px solid black;">';
	$content .= '<tr><td><b>Mentor Name</b></td><td><b>Student Name</b></td><td><b>Matched</b></td><td><b>Matched by</b></td><td><b>Unmatch</b></td></tr>';

	// Populating the table
	$matches = mnt_get_matches();
	foreach ( $matches as $match ) // Print info about posters
	{					
		$content .= '<tr><td>'.$match->mentor_name.'</td><td>'.$match->student_name.'</td><td>'.$match->creation_date.'</td><td>'.$match->matched_by.'</td><td><a href="'.$_SERVER['PHP_SELF'].'?page=Mentorship_matchmaking&unmatch='.$match->id.'">Unmatch</a></td>';
	}
	$content .= '</table>';

	// Finally, output our content
	echo $content;
			?>
	</div>   
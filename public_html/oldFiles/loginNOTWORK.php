<?php  # login.php
// this page processes the login form submission
// this script uses sessions

	require_once 'lib/startsession.php';
// Check if form has been submitted:
//if($_SERVER['REQUEST_METHOD'] == 'POST') {

	require_once '../jcres_connect.php';
//    require_once 'includes/login_functions.inc.php';

    // check the login
list($check, $data) = check_login($dbc, $_POST['user_id'], $_POST['pass']);
    
    if ($check) {// ok
        
        // Set the session data;
        session_start();
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['status'] = $data['status'];
        
        //redirect
        redirect_user('loggedin.php');
    } else { // unsucsseful
    
        // Assign $dats to $errors for login page
        $errors = $data;
        
    } // end else
    
//mysqli_close($dbc);  // close the database connection

//} // end of main submittal
function jcres_content() {
?>
		<div class="main-content">
			    <h2>Login page</h2>
	    <p>under construction </p>
		</div>
		
		
<?php
include 'includes/login_page.inc.php';

}

	// Now that the function jcres_content has been defined, call the main_template.php
	// Since main_template.php calls jcres_content, the function must be defined first.
	require_once 'lib/main_template.php';

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream

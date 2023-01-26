<?php # login.php
// This page both displays and handles the login form.

// need the utilities file;
require_once('includes/utilities.inc.php');
//require('class/User.php');

// create a new form
ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('loginForm');

// Add the user name
$username = $form->addElement('text', 'user');
$username->setLabel('User Name');
$username->addFilter('trim');
$username ->addrule('required', 'Please enter your user name');

// add the password field 
$password = $form->addElement('password', 'pass');
$password->setLabel('Password');
$password->addFilter('trim');
$password->addRule('required', 'Please enter your password.');

// add the submit button; 
$form->addElement('submit', 'submit', array('value'=>'Login'));

// Check for a form submission:
if($_SERVER['REQUEST_METHOD']== 'POST') { // Handle the form submission
	
	// validate the for data;
	if ($form->validate()) {
		// Check against the Database
		$q = 'SELECT username, password, userid, userlevel, status, dsort, unit_num, dbadge_no, rank, dname, phone_home, phone_work, phone_cell, cellcarrier, email, timestamp, probationary, code, squad, f_name, m_name, l_name, id FROM users WHERE username=:username AND password=MD5(:password)';
		$stmt = $pdo->prepare($q);
		$r = $stmt->execute(array(':username' => $username->getValue(), ':password' => $password->getValue()));
		// Try to fetch results
		if ($r) {
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
			$user = $stmt->fetch();
		}
		
		if ($user) {
		$_SESSION['user'] = $user;

		// redirect 
		header("Location:index1.php");
		exit;
		}	

		

	} // end of Validation
//}	// end of Validation
} //End of form submission IF 

// Show the login page 
$pageTitle = 'Login';
include('includes/header.inc.php');
include('views/login.html');
//include('includes/footer.inc.html');
?>
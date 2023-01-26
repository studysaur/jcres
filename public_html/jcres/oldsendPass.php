<?php // sendPass.php
session_start();
include 'includes/pass_function.inc.php';
$username = $_SESSION['usernm'];
echo $username;
if (!trim($username))
$pass = generatePassword();
echo '<p>The password generator returns ' . $pass . '</p>';
echo '<p> email address is ' . $_SESSION['f_name'] . '_' . $_SESSION['l_name'] . '@co.jackson.ms.us</p>';


echo '<p>this is the sendPass script</p>';
ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('loginForm');

// Add the user name
$username = $form->addElement('text', 'user');
$username->setLabel('User Name');
$username->addFilter('trim');
$username ->addrule('required', 'Please enter your user name');


// add the submit button; 
$form->addElement('submit', 'submit', array('value'=>'Reset'));

// Check for a form submission:
if($_SERVER['REQUEST_METHOD']== 'POST') { // Handle the form submission
	
	// validate the for data;
	if ($form->validate()) {
	
		// check for valid username
		try {
		$_SESSION["usernm"] = $username->getValue();
		$sql = 'SELECT status, count(*) AS howmany FROM users WHERE username=:username';
		$chk = $pdo->prepare($sql);
		$chk->execute(array(':username' => $username->getValue()));
		$row = $chk->fetch(); # will get one row only
		$status = $row['status'];
			if ($status == 0x800000000) {
				$error = "disabled";
			} else {
			if ($row['howmany'] == 1) { # we have one user	
					} else  { //username not found 
		 			$error = "nouser";
				}	
				// Check against the Database
				$q = 'SELECT username, password, userid, userlevel, status, unit_num, rank, phone_home, phone_work, phone_cell, cellcarrier, email, timestamp, probationary, code, squad, f_name, m_name, l_name, uid FROM users WHERE username=:username AND password=MD5(:password)';
				$stmt = $pdo->prepare($q);
				$r = $stmt->execute(array(':username' => $username->getValue(), ':password' => $password->getValue()));
					// Try to fetch results
					if ($r) {
						$stmt->setFetchMode(PDO::FETCH_CLASS, 'user');
						$user = $stmt->fetch();
					}		
			if ($user) {
				if ($user->isValidUser()){
					$_SESSION['user'] = $user;
					// redirect 
					header("Location:index1.php");
					exit;				

				}
			} // end if 
		}// end else disable
	}// end try
	// catch exception
	catch(Exception $e) {
		echo $e->getMessage();
	}		
	} // end of Validation
//}	// end of Validation
} //End of form submission IF 

// Show the login page 
$pageTitle = 'Login';
// include('includes/header.inc.html');
include('views/login.html');
//include('includes/footer.inc.html');
?>



?>
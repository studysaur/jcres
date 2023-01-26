<?php #Script login_page.inc.php
// This page prints errors associated with logging in
// and it create the entire login page, including the form

// echo 'this is the login_page.inc.php';
$page_title = 'Login';
include ('includes/header.html');
 	
 	// print any error messages, if they exist;
/* 	if (isset($errors) && !empty($errors)) {
 	    echo '<h1> Error!</h1> <p class="error">The following error(s) occurred:<br />';
 	    foreach ($errors as $msg) {
 	        echo " - $msg <br />\n";
 	    }
 	    echo '</p><p> Please try again.</p>';
 	}
 	
 	*// Display the form
?>
 	<h1>Login</h1>
 	<form action="login.php" method="post">
 	    <p>User_ID:<input type="text"name="user_id" size="20" maxlength="60"/></p>
 	    <p>Password:<input type="password" name="pass" size="20" maxlength="20" /></p>
 	    <p>input type="submit" name="submit" value="Login" /></p>
 	</form>
 
 	
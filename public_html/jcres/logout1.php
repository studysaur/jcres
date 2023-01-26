<?php # logout1.php
// Log the user out
$pageTitle = "test logout";
require('includes/utilities1.inc.php');

// check that user is actually logged include

	
	//  Clear the variable
	$user = null;
	
	// Clear the session_commit()
	$_SESSION = array();
	$_SESSION['user'] = null;
	$_SESSION['username'] = null;
	// Clear the COOKIE
	setcookie(session_name(), false, time()-3600);
	
	// Destroy the session data
	session_destroy();
	

$pagetitle = 'Logout';
include('includes/header.inc.html');
include 'includes/banner.inc.html';
include 'includes/menu.inc.php';

// Need the view
include('views/logout.html');

?>
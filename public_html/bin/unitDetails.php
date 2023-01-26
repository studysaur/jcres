<?php //  class/unitDetails.php

require_once '../includes/utilities1.inc.php';
// $user = $_SESSION['user'];
// echo 'username is ' . $_SESSION['username'];

if (!is_object($user) ){
	header("Location:../index.php");
	exit();
	} 
//	echo 'user is ' . $user->getFname() . '<br>';
	// set up first query to get all the non posted details
	try {
	$q = 'SELECT * FROM details WHERE sheetPosted =0  ORDER BY date';
	$r = $pdo->query($q);
	if ($r && $r->rowcount() > 0) {
	$pageTitle = "Open Details";
	include '../includes/header.inc.html';
	include '../includes/menu.inc.php';
		$r->setFetchMode(	PDO::FETCH_CLASS, 'detail');
		//echo "we have records<br>";
		//Records fetched in the view
		include '../views/details.html';
	}  else {
	throw new exception('no details returned');
	}
}  catch  (Exception $e) {
	include '../includes/header.inc.html';
 	include '../includes/menu.inc.php';
	include('../views/error.html');
}
echo 'now back in the class unitDetails<br>';


<?php # resetPass.php
// This uses tpass table to save values related to resetting 
// a forgotten password.  
// resetPass recieves a request mail with a Temporary Pass word token (tpass).
// the token is first checked to see if it exsist then considerable error checking prior to 
// going to the database, if it passess that then it checks for expiration and if it has been 
// set to used.  Once it passes it will set the tpass to used and store the tpass in session.
// once in session a password reset form is opened for the user to reset their password

require('includes/utilities.inc.php');
date_default_timezone_set('America/Chicago');
// private $detailsTable;

try{
//$detailsTable = new \Gen\DatabaseTable($pdo, 'details', 'detailNum', '\Aux\Entity\Detail');
//$usersTable = new \Gen\DatabaseTable($pdo, 'users', 'uid', '\Aux\Entity\User', [&$detailsTable]);
//$tpassTable = new \Gen\DatabaseTable($pdo, 'tpass', 'tid');
//$rtid = null;
$tid = null;
$tid = $_GET['tid'];
// check to ensure a tid was in the request
if ($tid == null) throw new Exception('No link present');
// simple check to ensure the link is 32 characters
if (strlen($tid)<>32) throw new Exception("Invalid Link");
// check the string to ensure it is hexadecimal format
if (!ctype_xdigit($tid)) throw new Exception("invalid Format");
$sql = "SELECT * FROM tpass WHERE tid=:tid";
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$tp = $pdo->prepare($sql);
$tp->bindparam(':tid', $tid);
$r= $tp->execute();
$now = new DateTime();
if ($r){ // see if something was returned
	$tp->setFetchMode(PDO::FETCH_CLASS, '\Aux\Entity\tpass');
	$tpass = $tp->fetch(); // pulls in one record
	if ($tpass){
		$_SESSION['tpass']=$tpass;
		$uid = $tpass->uid;
		$exp = new DateTime($tpass->expires);
		if ($now>$exp) throw new Exception('Link has expired, request a new Password reset'); // Disable to trouble shoot
	}else{
		throw new Exception('Record not found, Request new password!');
		}
	}else{
	throw new Exception('No records returned, database error');
	}
$sql="SELECT * FROM user WHERE uid=:uid";
$usr=$pdo->prepare($sql);
$usr->bindparam(':uid', $uid);
$r=$usr->execute();
	if ($r) {
	$usr->setFetchMode(PDO::FETCH_OBJ);
	$user=$usr->fetch();  //pull in the USER
	echo '<p>We have user ' . $user->username . '</p>';
//if (!$user->isValidUser()) throw new Exception('Invalid User');
//if ( $user->isUser(DIS)) throw new Exception('User has been Diabled, please contact your supervisor');
//if ( $user->isUser(LOA)) throw new Exception('User is on Leave of Absence, please contact your supervisor');
$_SESSION['uid'] = $user->uid;
header("Location:setPass.php");
exit;
}
}catch(exception $e) {
$pageTitle  = "Error";
include('includes/header.inc.php');
include('../../views/error.html');
} //end catch


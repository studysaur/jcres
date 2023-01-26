<?php #aEdit.php
/* This script displays a form with user information displayed for the Adimistrator to edit
 * It is called from the Admin edit page from the edit button which passes the uid via _POST['uid']
 * from there the user is called from the database.  When the Admin saves the data back to the Database
 * the user is changed.
 */
// require_once('/home/studysaurs/public_html/jcresFlagConstants.php');
require_once('../includes/utilities.inc.php');
$pageTitle='Admin Edit';
ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
if($_SESSION['user']== null){
	header("Location: ../index1.php");
	exit;
}
try{
$user =  $_SESSION['user'];
if (!$user->isUser(ADM))throw new Exception('Not Admin');
$uid=$_POST["uid"];
if($uid==null)throw new Exception('No link');
$sql = 'SELECT * FROM users WHERE uid = :uid';
$usr = $pdo->prepare($sql);
$usr->bindparam(':uid', $uid);
$r = $usr->execute();
if ($r){
	$usr->setFetchMode(PDO::FETCH_CLASS, 'user');
	$us = $usr->fetch();
	
} else {
throw new Exception('Failed to get user');
}
}catch(exception $e){
$pageTitle = "Error";
include '../includes/header.inc.html';
include '../includes/menu1.inc.php';
include '../views/error.html';
}// end catch
include '../includes/header.inc.html';
include '../includes/menu1.inc.php';
require('HTML/QuickForm2.php');
$form=new HTML_Quickform2
echo $user->getUsername();
echo ($user->isUser(ADM)?  ' admin' : ' not admin');
echo $uid;

echo $us->getUsername();
echo "  aEdit   ";
echo "  at the end";
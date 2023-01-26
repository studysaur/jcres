<?php // class/newUser.php
require_once '../includes/utilities1.inc.php';
if (!isset($user)){
	header("Location:../index.php");
	exit();
	} 

ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require(‘HTML/QuickForm2.php’);


if ($user->isUser(ADM)){
$pageTitle = "New User";
include '../includes/header.inc.html';
include '../includes/menu.inc.php'
echo ‘This page is being developed, right now does not work’;

$newUser = new HTML_QuickForm2(‘loginForm’);
echo 'form created';


if ($_SERVER[‘REQUEST_METHOD’] ==  ‘POST’){



}// end of main POST submission
$userName = "Fred_Flinttone";
$r = $user::userExist($pdo, $userName);
echo  ‘ ‘ . $userName .  ($r ? ‘ uid = ‘ . $r : ‘ not found’);
echo ‘<h1>class newUser.php</h1><h1>Target page</h2>’;


} else {
	header("Location:../index.php");
	exit();
}
?>

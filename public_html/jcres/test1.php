<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include('../jcresFlagConstants.php');
require 'includes/utilities.inc.php';
/* if (!user->isADMIN){
	header("location:index1.php");
	exit;
} */
$pageTitle = 'test page';
include 'includes/header.inc.html';
include 'includes/menu.inc.php';

// ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
$user = $_SESSION['user'];

$chk = CHK;
$cchk = CCHK;
$status = 134746368;
$adm = ADM;
if ($user->isUser(AUX)) {
	echo "<p> User is AUX</p>";
	} else {
	echo "<p>User is not AUX</p>";
}
echo $user->isValidUser() . '<br>';
echo "<p> CHK = " . CHK . " </p>";
$ts = $user->getts();
echo "<p> Time stamp = " . $ts . " </p>";
$mydate=date('m,d,Y H:i', $ts);
echo "<p>" . $mydate . " </p>";

// $to = $user->getFname() . "_" . $user->getLname() ."@co.jackson.ms.us";
// echo $to;
// $sub = "test  email";
//$msg = "this is just a with built name test message";
//$headers = "From: dean@sellars.family" . "\r\n";

// mail($to,$sub,$msg,$headers);


$test = 134746368;
$res = $test & $cchk;
echo CHK . '<br>';
echo CCHK . '<br>';
echo $_SESSION["usernm"];
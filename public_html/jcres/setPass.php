<?php // setPass.php
require_once('includes/utilities.inc.php');
// $pageTitle='Set New Password';
// include 'includes/header.inc.html';
// include 'includes/menu.inc.php';
ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require('HTML/QuickForm2.php');

try{
if (!$_SESSION['uid']) throw new Exception('You can not call this page directly');
$uid = $_SESSION['uid'];
// echo '<h1>uid is ' . $uid . '</h1>';
$form = new HTML_QuickForm2('setpass');
$pass1 = $form->addElement('password', 'pass1', array('size'=>30));
$pass1->setLabel('Password');
$pass1->addFilter('trim');
// $pass1->addRule('pass1', 'ERROR: Password must be between 8 and 29 characters', 'rangelength' , array(8,29));
$pass1->addRule('required', 'Please enter your password');
$pass2 = $form->addElement('password','pass2', array('size'=>30));
$pass2->setLabel('Re Enter Password');
$pass2->addFilter('trim');
$pass2->addRule('required','Please reenter your password');
// $pass2->addRule('pass2', 'ERROR: Password must be between 8 and 29 characters', 'rangelength' , array(8,29));
$pass1->addRule('empty')
			->and_($pass2->createRule('empty'))
			->or_($pass1->createRule('length', 'Password must be between 8 and 30 chacters', 8, 30))
			->and_($pass2->createRule('eq', 'The passwords do not match', $pass1));
// Add the submit Button
$form->addElement('submit', 'Reset Password', array('value'=>'Reset Password'));

// check for a form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form
//	echo $pass1;
	$pass = md5($pass1->getValue());
	// echo $pass;
	$sql = 'UPDATE user SET password = :pass WHERE uid = :uid';
	$stmt = $pdo->prepare($sql);
	$stmt->bindparam(':pass', $pass);
	$stmt->bindparam(':uid', $uid);
	$r=$stmt->execute();
		if($r ){
			include 'includes/header.inc.html';
			include 'includes/menu.inc.php';
			include '../../views/resetsucess.html';
			exit;
			}else{
			echo "we had a boo boo";
		}
}
} catch(exception $e){
$pageTitle = "Error";
include 'includes/header.inc.html';
include 'includes/menu.inc.php';
include '../../views/error.html';
exit;
} // end catch
$pageTitle = "Reset";
include 'includes/header.inc.html';
include 'includes/menu.inc.php';
include '../../views/reset.html';
// echo 'we are at the end';
<?php # sendPass.php
$tid = $_GET['tid'];
if(strlen($tid)== 32){
require_once('includes/utilities.inc.php');
$pageTitle = "test Reset Password";
include 'includes/header.inc.html';
// include 'includes/banner.inc.html';
include 'includes/menu.inc.php';
include_once 'includes/constants.php';

ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require('HTML/QuickForm2.php');

// set the default timezone, not individual timezones on each object!
$error = '';
date_default_timezone_set('America/Chicago');
$date = new DateTime();
// $now = $date->format('Y-m-d H:i:s');
// $unow = $date->format('U');
echo '<p> now = ' . $now . '  unow = ' . $unow . '</p>';

$meth = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
$meth = 'get';
} else { $meth = 'nada';}
echo '<p> meth = ' . $meth . '</p>';

$sql = 'SELECT uid, expires, count(*) AS hmany FROM tpass WHERE tid = :tid';
$chk = $pdo->prepare($sql);
$chk->bindParam(':tid', $tid);
$chk->execute();
$row = $chk->fetch();  // get one rowCount()
$uid = $row['uid'];
$hmany = $row['hmany'];
echo '<p> num = ' . $hmany . '</p>';
if ($hmany == 0){
$error = "noreset";
}
$expires = $row['expires'];
echo '<p>uid = ' .  $uid . 'expires ' . $expires . '</p>';

$exp = new DateTime($expires);

$uexp = $exp->format('U');

echo '<p> exp = ' . $exp->format('Y-m-d H:i:s') . ' uexp = ' . $uexp . '</p>';

$stat = ($date > $exp  ? 'expired':'good');
echo '<p> $stat = ' . $stat . '</p>';
$form = new HTML_QuickForm2('reset');

// add password 1 and set rules
$password1 = $form->addElement('text', 'password1');
$password1->setLabel('Password');
$password1->addFilter('trim');
$password1->addrule('required', 'Please enter a password');
$password1->addrule('length', 'Password must be between 5 and 32 characters', array('min' => 1, 'max' => 32) );
// add password 2 and set rules
$password2 = $form->addElement('text', 'password1');
$password2->setLabel('Password');
$password2->addFilter('trim');
$password2->addrule('required', 'Please enter a password');
$password2->addrule('length', 'Password must be between 5 and 32 characters', array('min' => 1, 'max' => 32) );


// add the submit button; 
$form->addElement('submit', 'submit', array('value'=>'reset password'));
?>

<h1>Reset password script is being developed</h1>
<p>This will test for valid reset request and ensure it has not expired</p>

<?php

// Check for a form submission:
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form submission
// $errormsg = '';
// $error = '';	
// validate the for data;
if ($form->validate()) {
// check for valid username
$sql = 'SELECT status, username, f_name, l_name, uid, count(*) AS howmany FROM users WHERE username=:username';
$chk = $dbc->prepare($sql);
$chk->execute(array(':username' => $username->getValue()));
$row = $chk->fetch(); # will get one row only
$howmany = $row['howmany'];
$status = $row['status'];
$uid = $row['uid'];
$ip = $_SERVER['REMOTE_ADDR'];
$fname = $row['f_name'];
$lname = $row['l_name'];
// echo "<p>uid = " . $uid . "</p>";
if ($row['howmany'] == 0) $error = "nouser";
elseif (($status & DIS) == DIS) $error = "disabled";				
elseif (($status & CCHK) <> CHK) $error = "invalid";
elseif (($status & LOA) == LOA) $error = "loa";
if ($error == ''){

} // end of if error
} // end of Validation
} //End of form submission IF 

// Show the login page 
$pageTitle = 'reset password';
// include('includes/header.inc.html');
include('views/login.html');}
//include('includes/footer.inc.html');

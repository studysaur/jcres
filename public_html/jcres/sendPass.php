<?php # sendPass.php

/* sendPass.php uses a form to get a username.  The form results from the form are then
 * checked against the user information stored in the database.  It displays errors if
 * username not found, also checks the user status to ensure the user is an active user 
 * displays error messages for disabled or users on LOA.  Also returns an error if the 
 * status variable is not set correctly indicating tamering
 */
 
require_once('includes/utilities.inc.php');
$pageTitle = "Send Password";
include 'includes/header.inc.html';
// include 'includes/banner.inc.html';
include 'includes/menu.inc.php';
// include_once 'includes/constants.php';

ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('reset');

// Add the user name
// echo 'page not working<br>';


/*if (isset($_SESSION['status'] )) {
	echo dechex($_SESSION['status']) . ' is the status<br>';
} else {
	echo 'status not set<br>';
}
if (isset($_SESSION['stat'])) {
	echo $_SESSION['stat'] . '  is the session stat<br>';
}
$cchk = \Aux\Controllers\Login::CCHK;
echo dechex($cchk) . ' is the CCHK';*/
$result = 

$username = $form->addElement('text', 'username');
$username->setLabel('User Name');
$username->addFilter('trim');
$username->addrule('required', 'Please enter your user name');

// add the submit button; 
$form->addElement('submit', 'submit', array('value'=>'SendReset'));
?>
<?php

// Check for a form submission:
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form submission

	// validate the for data;
if ($form->validate()) {
	
// check for valid username and retrieve associated values
$sql = 'SELECT status, username, f_name, l_name, uid, count(*) AS howmany FROM user WHERE username=:username';
$chk = $pdo->prepare($sql);
$chk->execute(array(':username' => $username->getValue()));
$row = $chk->fetch(); # will get one row only
// assign values from database to variables
$howmany = $row['howmany'];
$status = $row['status'];

$uid = $row['uid'];
$fname = $row['f_name'];
$lname = $row['l_name'];
$username = $row['username'];
// error to empty prior to checking
$error = '';
// retrieve remote ip address so it can be stored
$ip = $_SERVER['REMOTE_ADDR'];


// check for user if = 0 then nouser
if ($row['howmany'] == 0) $error = "nouser";


// check the status variable
elseif (($status & 0X10000000) == 0X10000000) $error = "disabled";				
elseif (($status &  \Aux\Controllers\Login::CCHK) <> 0x8081100) $error = "invalid";
elseif (($status &0x800000) == 0x800000) $error = "loa";
if ($error == ''){
// no errors found get ready to insert record into tpass
// create date and add one hour
$date = new DateTime();
$date->setTimezone(new DateTimeZone('America/Chicago'));
$date->add(new DateInterval('PT1H'));
$rtime = $date->format('Y-m-d H:i:s');
// get unix timestamp format and add to user id to make a tid
$utime = $date->format('U');
// echo '<p> utime = ' .$utime . '</p>';
$iden = $utime + $uid;
// echo "<p> iden = " . $iden . "</p>";
$tid = md5($iden);
// $iden = '';
// echo "<p> tid = " . $tid . "</p>";
// echo '<p> ip = ' . $ip . '</p>';
$sql = "INSERT INTO tpass (uid, expires, tid, ip) VALUES ( :uid, :expires, :tid, :ip)";

// echo $sql;
try {
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$tpass = $pdo->prepare($sql);
$tpass->bindParam(':uid', $uid);
$tpass->bindParam(':expires', $rtime);
$tpass->bindParam(':tid', $tid);
$tpass->bindParam(':ip', $ip);
if ($tpass->execute()) {

$to = $username . "@co.jackson.ms.us";
//$to = 'studysaur@gmail.com';
// echo $to;
$sub = "Password Reset";
$msg = "You have requested a password reset from jcres.us.  Please follow this link to reset your password.\n https://jcres.us/resetPass.php?tid=$tid \n If you did not request this password reset please forward the link to dean_sellars@co.jackson.ms.us so the offending sender may be blocked";
$headers = "From: webmaster@jcres.us";

mail($to,$sub,$msg,$headers);
include 'includes/header.inc.html';
// include 'includes/menu.inc.php';
include '../../views/passSent.html';
exit;

}
}
catch (exception $e) {
//echo 'Exception -> ' ;
var_dump($e->getMessage());
}
} // end of if error
} // end of Validation
} //End of form submission IF 

// Show the login page 
$pageTitle = 'Login';
// include('includes/header.inc.html');
include('../../views/login.html');
//include('includes/footer.inc.html');
?>
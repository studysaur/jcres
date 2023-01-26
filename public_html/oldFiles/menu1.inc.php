<?php 
if(!isset($_SESSION)) {
	session_start();
}
?>

<div id="menu">
<nav role="navigation">
<?php #menu1.php
// This script is for the menus
echo '<ul><li><a href="//jcres.us/index1.php">Home</a></li> ' . "\n";
if(isset($user)) {

    echo '<li><a href="//jcres.us/class/unitDetails.php">Details</a>' . "\n\t" . '<ul>'  . "\n\t\t";
    echo '<li><a href="//jcres.us/myDetails.php">My Details</a></li> ' . "\n\t\t";
    if ($user->isUser(EDET) || $user->isUser(ADM) || $user->isUser(PDET)) {
    	if ($user->isUser(EDET) || $user->isUser(ADM)) {
    			echo '<li><a href="//jcres.us/form/addDetail.php" >Create</a></li>' . "\n\t\t";
    		}
    	if ($user->isUser(PDET) || $user->isUser(ADM)) {
    			echo '<li><a href="//jcres.us/postDetails.php" >Post</a></li>' . "\n\t";
    		}
    	echo '</ul></li>' . "\n";
    } else {
    echo '</ul></li>' . "\n";
	}
	if ($user->isUser(ADM)) {
        echo '<li><a href="javascript:void(0)">Admin</a><ul>' . "\n\t\t";
        echo '<li><a href="newUser.php">New User</a></li>' . "\n\t\t";
        echo '<li><a href="../class/admin.php">Edit Users</a></li>' . "\n\t" . '</ul></li>' . "\n";
    }
	echo '<li><a href="//jcres.us/aux_roster.php">Roster</a></li>' . "\n";
	echo '<li><a href="//jcres.us/myAccount.php">Account Settings</a></li>' . "\n";
// echo '<li><a href="//jcres.us/test1.php">Test</a></li>' . "\n";
//    echo '<li><a class="menu-link" href="userinfo.php?user=$user->getUsername()>My Account</a></li>'); 
   echo '<li><a href="personal_detail_sheet.php">Account Balance</a></li>' . "\n";
     
    echo '<li><a href="citation_report.php">Various Reports</a></li>' . "\n\t";

	echo '<li id="logout"><a href="../logout1.php">Logout</a></li></ul>' . "\n";
    } else { // not logged in 
   		echo '<li><a href="//jcres.us/sendPass.php">Reset Password</a></li>' . "\n";
   		
    	echo '<li id="logout"><a href="//jcres.us/main1.php">Login</a></li></ul>' . "\n";   		
	} // end else
echo '</nav>' .  "\n" . '</div>';
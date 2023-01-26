<?php 
if(!isset($_SESSION)) {
	session_start();
}
//require_once("../jcresConstants.php");
//require 'includes/utilities.inc.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($pageTitle)) ? $pageTitle : 'Jackson County Sheriff Auxiliary Division'; ?></title>
    <meta name="keywords" content="jackson county, auxiliary, reserves, sheriff, mississippi, gulf coast"/>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/new_main.css">
<? if(isset($pageTitle)){
	 	if ($pageTitle=="Auxiliary Roster"){
    	echo '<link rel="stylesheet" href="css/roster.css">';
    	} // end if pageTitle
    	if($pageTitle=="Auxiliary Roster1"){
    	echo '<link rel="stylesheet" href="css/roster1.css">';
    	} // end if pageTitle 1
	}//end isset
?>
</head>
<body>
<header>		
	<img src="images/badge150.png" />
	<div class="banner">
		<h1>Jackson County Sheriff Auxiliary Division</h1>
		<div class="subbanner">
			<div id="sheriff"><h2>Mike Ezell</h2><h3>Sheriff</h3></div>
			<div id="chief"><h2>John Ledbetter</h2><h3>Chief Deputy</h3></div>
		</div>
	</div>
</header>
<nav role="navigation">
<?php #menu1.php
// This script is for the menus
echo '<ul><li><a class="menu-link" href="index1.php">Home</a></li><br>';
if(isset($user) && is_object($user)) {
    echo '<li><a class="menu-link" href="aux_roster1.php">Roster</a></li><br>';
    if ($user->isUser(EDET) || $user->isUser(ADM)) {
    	echo '<li><br>';
    	echo	'<a href="javascript:void(0)" class="menu-link">Details</a><br>';
    		echo '<div class="dropdown-content"><ul><br>';
    			echo '<li><a href="#">Create Detail</a></li><br>';
    			echo '<li><a href="unit_details.php">View Details</a></li><br>';
    		echo '</ul></div><br>';
    	echo '</li><br>';
    } else {
    echo '<li><a class="menu-link" href="unit_details.php">Details</a></li><br>';
	}
	echo '<li><a class="menu-link" href="test1.php">Test</a></li><br>';
//    echo '<li><a class="menu-link" href="userinfo.php?user=$user->getUsername()>My Account</a></li>'); 
   echo '<li><a class="menu-link" href="personal_detail_sheet.php">Account Balance</a></li><br>';
     
    echo '<li><a class="menu-link" href="citation_report.php">Various Reports</a></li><br>';
    if ($user->isUser(ADM)) {
        echo '<li><a class="menu-link" href="./admin/admin.php">Admin</a></li><br>';
    	}
	echo '<li id="logout"><a class="menu-link" href="logout1.php">Logout</a></li></ul><br>';
    } else { //we have a username but not logged in 
    echo '<li><a class="menu-link" href="login1.php">Login</a></li><br>';
    if(isset($_SESSION['usernm'])) {
    	echo '<li><a class="menu-link" href="sendPass.php">Send Password</a></li><br>';
		} // end if(isset)
	} // end else
echo '</nav><br>';
echo '<main><br>';
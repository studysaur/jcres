<?php  //index.php
//Start the session
//require_once('includes/startsession.php');
//require_once 'includes/utilities1.inc.php';
//Set page title
session_start();
if(session_status() == PHP_SESSION_NONE) echo 'NO SESSION <br>' ;
echo $_SESSION['username'];
$pageTitle = 'Auxiliary Home';
phpinfo();
//set up page header
//include 'includes/header.inc.html';
//include 'includes/banner.inc.html';
// include './include/session.php';
//include 'includes/menu.inc.php';
//include __dir__ . '/../../templates/Aux/home.html.php';
//include 'includes/footer.inc.php';

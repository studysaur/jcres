<?php # utilities.inc.php - Script 9.3
// This page needs to do the setup and configuration required by every other page.
//  require_once("/home/studysaurs/public_html/jcresContants.php");
// Autoload classes from "classes" directory:
require_once __DIR__ . '/../../../includes/jcres/jcresConstants.php';
require_once __DIR__ . '/../../../includes/Aux/autoload.php';

// Start the session:
// Start the session:
if (session_status() == PHP_SESSION_NONE) {
	session_start();
	$_SESSION['stat'] = 'session had to be started';
} else {
	$_SESSION['stat'] = 'session was already started<br>';
}

ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
// Check for a user in the session:
$username = (isset($_SESSION['username'])) ? $_SESSION['username'] : null;

// Create the database connection as a PDO object:
try { 

    // Create the object:
    $pdo = new PDO(DB_SERVER, DB_USER, DB_PASS);

} catch (PDOException $e) { // Report the error!
    
    $pageTitle = 'Error!';
    include('/home/studysaurs/public_html/jcres/includes/header.inc.html');
    include('/home/studysaurs/public_html/jcres/views/error.html');
    include('/home/studysaurs/public_html/jcres/includes/footer.inc.php');
    exit();
    
}
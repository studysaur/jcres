<?php # utilities1.inc.php 
// This page needs to do the setup and configuration required by every other page.
//  require_once("/home/studysaurs/public_html/jcresContants.php");
// Autoload classes from "classes" directory:
require_once __DIR__ . '/../../../includes/jcres/jcresConstants.php';
require_once __DIR__ . '/../../../includes/Aux/autoload.php';
/*function autoloader($className) {
	$file = __DIR__ . '/../../class/' . $className . '.php';
	include $file;
}
spl_autoload_register('autoloader');
*/
// Start the session:
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


// Create the database connection as a PDO object:
try { 
    // Create the object:
    $pdo = new PDO(DB_SERVER, DB_USER, DB_PASS);
} catch (PDOException $e) { // Report the error!
    $pageTitle = 'Error!';
    include('includes/header.inc.html');
    include('views/error.html');
    include('includes/footer.inc.php');
    exit();
}
// Check for a user in the session:
$user = (isset($_SESSION['user']) ? $_SESSION['user'] : null);
if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	//echo 'username is ' . $username . ' from utilities1<br>';
	} else {
	$username = null;
	}
if ($user == null && $username <> null) {
	$q ='SELECT * FROM user WHERE username = :username';
	$stmt = $pdo->prepare($q);
	$stmt->bindParam(':username', $username);
	$r=$stmt->execute();
	if ($r){
	// echo 'we have r';
	$stmt->setFetchMode(PDO::FETCH_CLASS, '\stdClass');
	$user = $stmt->fetch();
	}
	}
	


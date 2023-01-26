<?php #msjcgop.org/includes/utilities.inc.php - Script 9.3
// This page needs to do the setup and configuration required by every other page.
//  require_once("/home/studysaurs/public_html/jcresContants.php");
// Autoload classes from "classes" directory:
require_once('../jcresDBConstants.php');
function class_loader($class) {
    require('class/' . $class . '.php');
}
spl_autoload_register('class_loader');

// Start the session:
session_start();

ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
// Check for a user in the session:
$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : null;

// Create the database connection as a PDO object:
try { 

    // Create the object:
    $pdo = new PDO(DB_SERVER, DB_USER, DB_PASS);

} catch (PDOException $e) { // Report the error!
    
    $pageTitle = 'Error!';
    include('includes/header.inc.php');
    include('views/error.html');
    include('includes/footer.inc.php');
    exit();
    
}
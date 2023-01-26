<?php
/**
 * This sniff prohibits the use of Perl style has comments
 * PHP version 5.6
 * 
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */
try {
    include __DIR__ . '/../../includes/autoload.php';
    include __DIR__ . '/../../includes/DatabaseConnection.php';
    include __DIR__ . '/../../controllers/jcres/Users.php';

    $usersTable = new DatabaseTable($pdo, 'users', 'uid');
    $detailsTable = new DatabaseTable($pdo, 'details', 'detailNum');

    $usersController = new UsersController($usersTable);

    if (isset($_GET['list'])) {
        $page = $usersController->ulist();
    } elseif (isset($_GET['details/list'])) {
        $page = $detailController->list();
    } else {
        $page = $usersController->home();
    }

    $title = $page['title'];
    $output = $page['output'];

} catch(PDOException $e){
    $title = 'An error has occured';

    $output = 'Database error: ' . $e->getMessage() . ' in '
     . $e->getFile() . ' line ' . $e->getLine();

 
}
require __DIR__ . '/../../templates/jcres/layout.html.php';
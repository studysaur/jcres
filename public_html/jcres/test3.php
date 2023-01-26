<?php
try {
    include __DIR__ . '/../../includes/autoload.php';
    include __DIR__ . '/../../includes/DatabaseConnection.php';
    $title = 'Test 3';
    // $loggedIn = 'test';
    session_start();
    $usersTable = new \Gen\DatabaseTable($pdo, 'users', 'uid', '\Aux\Entity\Users');
    $username = 'username';
    $user = $usersTable->find($username, 'dean_sellars');
    $username = $user['username'];
    $status = $user['status'];

     //$_SESSION['username'] = $username;

    
    
    $output = '$status set to ' . $status ;
} 
catch (PDOException $e) {
    $output = 'PDOException = ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

}

include __DIR__ . '/../../templates/Aux/layout.html.php';
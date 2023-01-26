<?php
/**
 * This sniff prohibits the use of Perl style has comments
 * PHP version 5.6 This is the index for the jcres.us
 * website
 * 
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */
try {
    include __DIR__ . '/../../includes/autoload.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $layout = '/Aux/layout.html.php';
        

    $entryPoint = new \Gen\EntryPoint(
        $route, 
        $_SERVER['REQUEST_METHOD'],
        new \Aux\AuxRoutes(),
        $layout
    );
    $entryPoint->run();
}
catch (PDOException $e) {
    $title = 'An error has occured';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . 
    $e->getFile() . ':' . $e->getLine();

    include __DIR__ . '/../../templates/Aux/layout.html.php';
}
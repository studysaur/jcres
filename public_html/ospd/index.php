<?php //index.php

try {
    include __DIR__ . '/../../includes/ospd/autoload.php';
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    if ($route == 'index.php' || $route == 'main.php'){$route = '';}
    $layout =  'Ospd/layout.html.php';
    $entryPoint = new \Gen\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Ospd\OspdRoutes(), $layout );
    $entryPoint->run();
    
}  catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . 
       $e->getFile() . ':' . $e->getLine;
    include __DIR__ . '/../../templates/Aux/layout.html.php';
} 


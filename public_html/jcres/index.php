<?php
try {
    include __DIR__ . '/../../includes/Aux/autoload.php';
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    if ($route == 'index.php' || $route == 'main.php'){$route = '';}
    //$layout =  'Aux/layout.html.php';
    $entryPoint = new \Gen\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Aux\AuxRoutes(), 'Aux/layout.html.php' );
    $entryPoint->run();
    
}  catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . 
       $e->getFile() . ':' . $e->getLine();
    include __DIR__ . '/../../templates/Aux/layout.html.php';
}

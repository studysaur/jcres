<?php
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    echo 'route is ' . $route;
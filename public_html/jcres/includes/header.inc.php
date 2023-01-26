<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($pageTitle)) ? $pageTitle : 'Jackson County Sheriff Reserves'; ?></title>
    <meta name="keywords" content="jackson county, auxiliary, reserves, sheriff, mississippi, gulf coast"/>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/new_main.css">
    
<?php 
	if ($pageTitle=="Reserve Roster"){
//		echo '<link rel="stylesheet" href="/css/table.css">';
    	echo '<link rel="stylesheet" href="/css/roster.css">';
    } 
?>
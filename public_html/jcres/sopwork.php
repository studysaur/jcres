<?php #sop.php
 if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $location = $_GET['location'];
    $detailNum = $_GET['detailNum'];
    $field = $_GET['field'];
        } else {
    header('location:main.php');
    } 
if (stristr($location, 'school')) {
    $template = '/../../templates/Aux/school.html';
} elseif (stristr($location, 'center')) {
    $template = '/../../templates/Aux/center.html';
} else {
    $template = '/../../templates/Aux/traffic.html';
}
$title = 'Detail SOP';

ob_start();

include __DIR__ . $template;

$output = ob_get_clean();
 include __DIR__ . '/../../templates/Aux/sop.html.php';
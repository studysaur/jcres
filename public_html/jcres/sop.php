<?php #sop.php
require_once 'includes/utilities1.inc.php';
$pageTitle = 'Operating Instructions';
 if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $location = $_GET['location'];
    $detail = $_GET['detail'];
    $field = $_GET['field'];
    $loggedIn = true;
      } else {
   header('location:main.php');
   } 
 //echo $location . '<br>';
 //echo $detail . '<br>';
 //echo $field . '<br>';
if (stristr($location, 'school')) {
    $template = '/../../templates/Aux/school.html';
} elseif (stristr($location, 'center')) {
    $template = '/../../templates/Aux/center.html';
} else {
    $template = '/../../templates/Aux/traffic.html';
}
$title = 'Detail SOP';

ob_start();
//    "<td><a href=\"volunteer.php?type=edit&detail=$detail\"><img src=\"images/edit.jpg\"/></a></td>";
include __DIR__ . $template;
    echo '<li><div class="nav"><a href="volunteer.php?type=volunteer&detail=' . $detail . '&field=' . $field . '&location=' . $location . '">Accept Detail</a></div></li>';
$output = ob_get_clean();

//    echo '<li><a href=\"volunteer.php?type=volunteer&detail=$detail&field=$num_assigned&location=$location\">Accept Detail</a></li>';
//<form action="unit_details.php">
//    <button type="submit">Back to Details</button>
//    <button type="submit" formaction="volunteer.php?type=edit&">Accept Detail


 include __DIR__ . '/../../templates/Aux/layout.html.php'; 
<?php #menu1.php
// This script is for the menus
echo '<nav>';
if(isset($_SESSION['username'])&&($_SESSION['username']!='Guest')) {
    $user = $_SESSION['username'];
    echo '<ul><li><a class="menu-link" href="index.php">Home</a></li>';
    echo '<li><a class="menu-link" href="unit_details.php">Details</a></li>';
    if ($session->username != 'Guest') { 
        print("<li><a class=\"menu-link\" href=\"userinfo.php?user=$session->username\">My Account</a></li>"); 
    }
    if($session->username != 'Guest') { 
       echo '<li><a class="menu-link" href="personal_detail_sheet.php">Account Balance</a></li>';
       }
    echo '<li><a class="menu-link" href="citation_report.php">Various Reports</a></li>';
    
    
    if ($session->isAdmin()) {
        echo '<li><a class="menu-link" href="./admin/admin.php">Admin</a></li>';
    }
	echo '<li><a class="menu-link" href="aux_roster.php">Roster</a></li>';
	echo '<li id="logout"><a class="menu-link" href="process.php">Logout</a></li></ul>';
	
    } else {
    echo '<li><a class="menu-link" href="main.php">Login</a></li>';
    }
echo '</nav>';
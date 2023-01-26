
<nav role="navigation">
    <ul><li><a href="/">Home</a></li>

<?php #menu1.php
// This script is for the menus
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $admin = (($_SESSION['status'] & \Aux\Entity\User::ADMIN) == \Aux\Entity\User::ADMIN) ? true : false ;
    $edit = (($_SESSION['status'] & \Aux\Entity\User::EDIT_DETAILS) == \Aux\Entity\User::EDIT_DETAILS) ? true : false ;
    $post = (($_SESSION['status'] & \Aux\Entity\User::POST_DETAILS) == \Aux\Entity\User::POST_DETAILS) ? true : false ;
 //	echo $username;
    echo '<li><a href="/aux_roster.php">Roster</a></li>';
 //   echo '<li><a href="/detail/list">Details</a><ul>';
     	echo '<li><a href="unit_details.php">Details</a></li>';
    if ($edit || $admin || $post) {
        if ($edit || $admin) {
            //    echo '<li><a href="/class/unitDetails.php" >new detail page being devloped</a></li>';
            //    echo '<li><a href="/class/createDetail.php" >Create to be developed</a></li>';
            //    echo '<li><a href="/sop.php">Instructions</a></li>';
            }
        if ($post || $admin) {
             //   echo '<li><a href="/class/postDetails.php" >Post to be developed </a></li>';
            }
            echo '</li>'; // delete this to use the lists
         //   echo '</ul></li>';
 //   } else {
 //   echo '</ul></li>';
    }
    echo '<li><a class="menu-link" href="/userinfo.php?user=' .$username .'">My Account</a></li>'; 
    echo '<li><a href="/personal_detail_sheet.php">Account Balance</a></li>';
    echo '<li><a href="/citation_report.php">Various Reports</a></li>';
    if ($admin) {
        echo '<li><a href="javascript:void(0)">Admin</a><ul>';
        echo '<li><a href="/user/register">New User</a></li>';
        echo '<li><a href="/user/ulist">Edit Users</a></li></ul></li>';
    }
       echo '<li id="logout"><a href="process.php">Logout</a></li></ul>';
    } else { // not logged in 
        echo '<li><a href="/sendPass.php">Reset Password</a></li>';
        echo '<li id="logout"><a href="main.php">Login</a></li>';   		
    }
echo '</ul></nav>';
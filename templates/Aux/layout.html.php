<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo (isset($title)) ? $title : 'Jackson County Sheriff Reserves'; ?></title>
    <meta name="keywords" content="jackson county, auxiliary, reserves, sheriff, mississippi, gulf coast"/>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/new_main.css">
    <?php
    if (isset($cssa)) {
         foreach($cssa as $css){
        echo (isset($cssa)) ? '<link rel="stylesheet" href="/css/'.$css.'.css"><br>' : '';
         } 
    }?>
</head>
<body>
<header>		
    <img src="/images/badge150.png"/>
    <div class="banner">
        <h1>Jackson County Sheriff Reserves</h1>
        <div class="subbanner">
            <div id="sheriff"><h2>John Ledbetter</h2><h3>Sheriff</h3></div>
            <div id="chief"><h2>Gerald Bartz</h2><h3>Chief</h3></div>
        </div>
    </div>
</header>
<main>
<nav class="main-nav" role="navigation">
    <ul><li><a href="/">Home</a></li>
<?php 

if($loggedIn) {
    $username = $_SESSION['username'];
    $admin = (($_SESSION['status'] & \Aux\Entity\User::ADMIN) == \Aux\Entity\User::ADMIN) ? true : false ;
    $edit = (($_SESSION['status'] & \Aux\Entity\User::EDIT_DETAILS) == \Aux\Entity\User::EDIT_DETAILS) ? true : false ;
    $post = (($_SESSION['status'] & \Aux\Entity\User::POST_DETAILS) == \Aux\Entity\User::POST_DETAILS) ? true : false ;
    $test = (($_SESSION['status'] & \Aux\Entity\User::TEST) == \Aux\Entity\User::TEST) ? true : false ;
//	echo $username;
    echo '<li><a href="/aux_roster.php">Roster</a></li>';
    //echo '<li><a href="/detail/list">Details</a><ul>';
   	echo '<li><a href="/unit_details.php">Details</a></li>';
    if ($edit || $admin || $post) {
        echo '<ul>';
        if ($edit || $admin) {

            }
        else if ($post || $admin) {

            }
        echo '</ul>'; // disable this to make list
     //       echo '</ul></li>';
//    } else {
 //   echo '</ul></li>';
    }
    echo '<li><a class="menu-link" href="/detail/list">T Detail</a></li>';
    echo '<li><a class="menu-link" href="/userinfo.php?user=' .$username .'">My Account</a></li>'; 
    echo '<li><a href="/personal_detail_sheet.php">Account Balance</a></li>';
    echo '<li><a href="/citation_report.php">Various Reports</a></li>';
    if ($admin) {
        echo '<li><a href="javascript:void(0)">Admin</a><ul>';
        echo '<li><a href="/user/register">New User</a></li>';
        echo '<li><a href="/user/ulist">Edit Users</a></li></ul></li>';
    }
    echo '<li id="logout"><a href="/logout">Logout</a></li></ul>';
    } else { // not logged in 
        echo '<li><a href="/sendPass.php">Reset Password</a></li>';
        echo '<li><a href="/user/register">New User</a></li>';
        echo '<li id="logout"><a href="/login">Login</a></li>';   		
    } // end else
?>
</div>
<div class="break"></div>
</ul></nav>
        <?= $output?>
    </main> 
    <div class="footer">
        <footer class="footer">
            <small>&copy; <?= date('Y'); ?> Dean Sellars- Website design by Dean Sellars</small>
        </footer>
    </div>
</body>
</html>
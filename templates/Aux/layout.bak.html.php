<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($pageTitle)) ? $pageTitle : 'Jackson County Sheriff Auxiliary Division'; ?></title>
    <meta name="keywords" content="jackson county, auxiliary, reserves, sheriff, mississippi, gulf coast"/>
    <link rel="stylesheet" href="https://jcres.us/css/reset.css">
    <link rel="stylesheet" href="https://jcres.us/css/new_main.css">
    
</head>
<body>
<header>		
    <img src="/images/badge150.png"/>
    <div class="banner">
        <h1>Jackson County Sheriff Auxiliary Division</h1>
        <div class="subbanner">
            <div id="sheriff"><h2>Mike Ezell</h2><h3>Sheriff</h3></div>
            <div id="chief"><h2>Stephen Strickler</h2><h3>Chief</h3></div>
        </div>
    </div>
</header>

<nav role="navigation">
    <ul><li><a href="/">Home</a></li>
<?php 


if ($loggedIn) {
    $username = $_SESSION['username'];
    $admin = (($_SESSION['status'] & \Aux\Entity\User::ADMIN) == \Aux\Entity\User::ADMIN) ? true : false ;
    $edit = (($_SESSION['status'] & \Aux\Entity\User::EDIT_DETAILS) == \Aux\Entity\User::EDIT_DETAILS) ? true : false ;
    $post = (($_SESSION['status'] & \Aux\Entity\User::POST_DETAILS) == \Aux\Entity\User::POST_DETAILS) ? true : false ;
//	echo $username;
    echo '<li><a href="/aux_roster.php">Roster</a></li>';
    echo '<li><a href="/detail/list">Details</a><ul>';
//    	echo '<li><a href="//jcres.us/myDetails.php">My Details</a></li>';
    if ($edit || $admin || $post) {
        if ($edit || $admin) {
            //    echo '<li><a href="/class/unitDetails.php" >new detail page being devloped</a></li>';
            //    echo '<li><a href="/class/createDetail.php" >Create to be developed</a></li>';
            //    echo '<li><a href="/sop.php">Instructions</a></li>';
            }
        if ($post || $admin) {
             //   echo '<li><a href="/class/postDetails.php" >Post to be developed </a></li>';
            }
        echo '</ul></li>';
    } else {
    echo '</ul></li>';
    }
    echo '<li><a class="menu-link" href="/userinfo.php?user=' .$username .'">My Account</a></li>'; 
    echo '<li><a href="/personal_detail_sheet.php">Account Balance</a></li>';
    echo '<li><a href="/citation_report.php">Various Reports</a></li>';
    if ($admin) {
        echo '<li><a href="javascript:void(0)">Admin</a><ul>';
        echo '<li><a href="/register.php">New User</a></li>';
        echo '<li><a href="/class/editUser.php">Edit Users</a></li></ul></li>';
    }
    echo '<li id="logout"><a href="/logout">Logout</a></li></ul>';
    } else { // not logged in 
           echo '<li><a href="/sendPass.php">Reset Password</a></li>';
           
        echo '<li id="logout"><a href="/login">Login</a></li>';   		
    } // end else
?>
</ul></nav>    <main>
        <?php echo $output?>
    </main> 
    <div class="footer">
        <footer class="threeColumns">
            <small>&copy; <?php echo date('Y'); ?> Dean Sellars- Website design by Dean Sellars</small>
        </footer>
    </div>
</body>
</html>
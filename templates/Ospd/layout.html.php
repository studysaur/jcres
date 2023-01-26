<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($title)) ? $title : 'Ocean Springs Police'; ?></title>
    <meta name="keywords" content="ocean spring, part time, reserves, police, mississippi, gulf coast"/>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/main.css">
    
</head>
<body>
<header>		
    <img src="/images/OceanSprings.png"/>
    <div class="banner">
        <h1>Ocean Springs Police Part Time/Reserve Division</h1>
        <div class="subbanner">
            <div id="sheriff"><h2>Mark Dunston</h2><h3>Police Chief</h3></div>
            <div id="chief"><h2>Torrey Hargrow</h2><h3>Department Head</h3></div>
        </div>
    </div>
</header>

<nav role="navigation">
    <ul><li><a href="/">Home</a></li>
<?php 

    if($loggedIn) {
        $username = $_SESSION['username'];
        $admin = (($_SESSION['status'] & \Aux\Entity\User::ADMIN) == \Aux\Entity\User::ADMIN) ? true : false ;
        $edit = (($_SESSION['status'] & \Aux\Entity\User::EDIT_DETAILS) == \Aux\Entity\User::EDIT_DETAILS) ? true : false ;
        $post = (($_SESSION['status'] & \Aux\Entity\User::POST_DETAILS) == \Aux\Entity\User::POST_DETAILS) ? true : false ;
    
    	echo $route . '<br>';
    echo '<li><a href="/aux_roster.php">Roster</a></li>';
    echo '<li><a href="javascript:void(0)">Details</a><ul>';
        echo '<li><a href="/detail/listall">All Details</a></li>';
        echo '<li><a href="/detail/listmine">My Details</a></li>';
      //  echo '<li><a href="/detail/sop"<SOP\'S></a></li>';
      // echo '<li><a href="/unit_details.php">Details</a></li>';
       
    if ($edit || $admin || $post) {

        if ($edit || $admin) {
            //    echo '<li><a href="/detail/listall" >new detail page being devloped</a></li>';
                echo '<li><a href="/detail/create" >Create to be developed</a></li>';
                echo '<li><a href="/detail/sop">Instructions</a></li>';
            }
        if ($post || $admin) {
                echo '<li><a href="/detail/post" >Post to be developed </a></li>';
            }
     //       echo '</li>'; // disable this to make list

    } else {
        echo '<li><a href="/detail/list">Details</a></li>';;
    }
    echo '</ul>';
    echo '<li><a class="menu-link" href="/userinfo.php?user=' .$username .'">My Account</a></li>'; 
    echo '<li><a href="/personal_detail_sheet.php">Account Balance</a></li>';
    echo '<li><a href="/citation_report.php">Various Reports</a></li>';
    if ($admin) {
        echo '<li><a href="javascript:void(0)">Admin</a><ul>';
        echo '<li><a href="/user/register">New User</a></li>';
        echo '<li><a href="/user/ulist">Edit Users</a></li></ul></li>';
    }
    echo '<li id="logout"><a href="/logout">Logout</a></li>';
    } else { // not logged in 
        echo '<li><a href="/reset">Reset Password</a></li>';
        echo '<li><a href="/user/register">Register</a></li>';
           
        echo '<li id="logout"><a href="/login">Login</a></li>';   		
    } // end else
?>
</ul></nav>    <main>
        <?php echo $output?>
    </main> 
    <div class="footer">
        <footer class="footer">
            <small>&copy; <?php echo date('Y'); ?> Dean Sellars- Website design by Dean Sellars</small>
        </footer>
    </div>
</body>
</html>
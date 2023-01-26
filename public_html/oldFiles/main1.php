<?
/**
 * Main1.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 */

include("include/session.php");

if($session->logged_in){

    header("Location:class/unitDetails.php"); 
    }
else
    {
?>
<html>
<title>Login Page</title>
<style type="text/css">
body {background:url(images/background-eagle-flag.jpg); 
background-repeat:no-repeat; margin-left:250px}
</style>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>You Might notice the little green lock on the URI bar!</p>
<p>This indicates the site is now secure!  Working on </p>
<p>changing the password modules!  Stay tuned</p>
<p align="left">	[<a href="index.php">Home</a>]
&nbsp;&nbsp;</p>
<h1 align="left">Login</h1>
<div align="left">
	<?
/**
 * User not logged in, display the login form.
 * If user has already tried to login, but errors were
 * found, display the total number of errors.
 * If errors occurred, they will be displayed.
 */
if($form->num_errors > 0){
   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
}
?>
</div>
<form action="process.php" method="POST">
	<div align="left">
		<table align="left" border="0" cellspacing="0" cellpadding="3">
			<tr><td><h3>Username:</h3></td><td><input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>"></td><td><? echo $form->error("user"); ?></td></tr>
			<tr><td><h3>Password:</h3></td><td><input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"></td><td><? echo $form->error("pass"); ?></td></tr>
			<tr><td colspan="2" align="right">
				<?
/*  Remove opening and closing php tags and comment symbols to add the Remember Me table row back
 *  <input type="checkbox" name="remember" <? if($form->value("remember") != ""){ echo "checked"; } ?>>
 *  <font size="2">Remember me next time &nbsp;&nbsp;&nbsp;&nbsp;
*/
?>
				<input type="hidden" name="sublogin" 
value="1">
			<input type="submit" value="Login"></td></tr>
			
		</table>
	</div>
</form>

<div align="center">
	<?
}

/**
 * Just a little page footer, tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. Active users are displayed,
 * with link to their user information.
 */

// include("include/view_active.php");



/* </td></tr>
 *</table>
 */
?>
</div>
</body>
</html>

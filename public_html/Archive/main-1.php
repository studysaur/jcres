<?
/**
 * Main.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("include/session.php");

/**
 * User has already logged in, so display relavent links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in){

    header("Location:mounted_patrol_roster.php"); 
    }
else
    {
?>
<html>
<title>Login Page</title>
<body background="images/background-eagle-flag.jpg">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">	[<a href="index.php">Home</a>]
&nbsp;&nbsp;</p>
<h1 align="center">Login</h1>
<div align="center">
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
	<div align="center">
		<table align="center" border="0" cellspacing="0" cellpadding="3">
			<tr><td>Username:</td><td><input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>"></td><td><? echo $form->error("user"); ?></td></tr>
			<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"></td><td><? echo $form->error("pass"); ?></td></tr>
			<tr><td colspan="2" align="left">
				<?
/*  Remove opening and closing php tags and comment symbols to add the Remember Me table row back
 *  <input type="checkbox" name="remember" <? if($form->value("remember") != ""){ echo "checked"; } ?>>
 *  <font size="2">Remember me next time &nbsp;&nbsp;&nbsp;&nbsp;
*/
?>
				<input type="hidden" name="sublogin" value="1">
			<input type="submit" value="Login"></td></tr>
			<tr><td colspan="2" align="left"><br><font size="2">[<a href="forgotpass.php">Forgot Password?</a>]</font></td><td align="right"></td></tr>
			<?
/* Remove opening and closing php tags and comment symbols to add the Register table row back
 * <tr><td colspan="2" align="left"><br>Not registered? <a href="register.php">Sign-Up!</a></td></tr>
 */
 ?>
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

include("include/view_active.php");



/* </td></tr>
 *</table>
 */
?>
</div>
</body>
</html>

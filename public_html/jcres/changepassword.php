<?
/**
 * ChangePassword.php
 *
 * This page is for users to edit their password when
 * their current password is the default password.
 * usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 *
 *  */
include("include/session.php");
?>

<html>
<title>Change Password</title>
<body>

<?
/* Link back to main */
echo "<br>Back To [<a href=\"main.php\">Main</a>]<br>";
/**
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */

/*  if(isset($_SESSION['changepass'])){
 *   unset($_SESSION['changepass']);
 *  
 *	header("Location: main.php");
 * }
 * else{
?>

<?
/**
 * If user is not logged in, then do not display anything.
 * If user is logged in, then display the form to edit
 * account information, with the current email address
 * already in the field.
 */

echo "<h1>Once you have changed your password,<br />you will have to 
login with your new password.";
echo "<p>This system was designed several years ago, and used the most up to date password encryption at the time!</p>";
echo "<p>Unfortunately things change and this system is easily hacked now.  It is on my list of things to upgrade.  The only saving grace is this system does not protect any information that a hacker would find very useful in identity theft, with the exception of the password itself!</p>";
echo "<p>Use a simple password one that you don't use on other systems that might have critical information like DOB, Social or Credit Card information.  Thanks for your understanding and cooperation!</p>";

?>

<h1>Change Password : <? echo $session->username; ?></h1>
<?
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<form action="process.php" method="POST">
<table width="395" align="left" border="0" cellspacing="0" 
cellpadding="3">
<tr>
<td width="153">Current Password:</td>
<td width "196"><input type="password" name="curpass" maxlength="30" 
value="
<?echo $form->value("curpass"); ?>"></td>
<td><? echo $form->error("curpass"); ?></td>
</tr>
<tr>
<td>New Password:</td>
<td><input type="password" name="newpass" maxlength="30" value="
<? echo $form->value("newpass"); ?>"></td>
<td><? echo $form->error("newpass"); ?></td>
</tr>

<tr><td colspan="2" align="right">
<input type="hidden" name="subpass" value="1">
<input type="submit" value="Change Password"></td></tr>
<tr><td colspan="2" align="left"></td></tr>
</table>
</form>

<?
/*  } */
/*  }  */
?>

</body>
</html>

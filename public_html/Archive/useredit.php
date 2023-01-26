<?
/**
 * UserEdit.php
 *
 * This page is for users to edit their account information
 * such as their password, email address, etc. Their
 * usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("include/session.php");
?>

<html>
<title>User Edit Account Page</title>
<body>

<?
/* Link back to main */
echo "<br>Back To [<a href=\"main.php\">Main</a>]<br>";
/**
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */
if(isset($_SESSION['useredit'])){
   unset($_SESSION['useredit']);
   
   echo "<h1>User Account Edit Success!</h1>";
   echo "<p><b>$session->username</b>, your account has been successfully updated. "
       ."<a href=\"main.php\">Main</a>.</p>";
}
else{
?>

<?
/**
 * If user is not logged in, then do not display anything.
 * If user is logged in, then display the form to edit
 * account information, with the current email address
 * already in the field.
 */
if($session->logged_in){
?>

<h1>User Account Edit : <? echo $session->username; ?></h1>
<?
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<form action="process.php" method="POST">
<table width="495" align="left" border="0" cellspacing="0" 
cellpadding="3">
<tr>
<td width="153">Current Password:</td>
<td width "296"><input type="password" name="curpass" maxlength="30" 
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
<tr>
<td>Home Phone:</td>
	<td><input type="text" name="phone_home" maxlength="12" value="
	<? 
	if($form->value("phone_home") == ""){
		echo $session->userinfo ['phone_home'];
	}else{
		echo $form->value("phone_home");
	}	
	?>">
</td>
<td><? echo $form->error("phone_home"); ?></td>
</tr>

<tr>
<td>Work Phone:</td>
	<td><input type="text" name="phone_work" maxlength="12" value="
	<? 
	if($form->value("phone_work") == ""){
		echo $session->userinfo ['phone_work'];
	}else{
		echo $form->value("phone_work");
	}	
	?>">
</td>
<td><? echo $form->error("phone_work"); ?></td>
</tr>

<tr>
<td>Cell Phone:</td>
	<td><input type="text" name="phone_cell" maxlength="12" value="
	<? 
	if($form->value("phone_cell") == ""){
		echo $session->userinfo ['phone_cell'];
	}else{
		echo $form->value("phone_cell");
	}	
	?>">
</td>
<td><? echo $form->error("phone_cell"); ?></td>
</tr>

<tr>
<td width "296">Email:</td>
<td><input type="text" name="email" maxlength="100" value="
<?
if($form->value("email") == ""){
   echo $session->userinfo['email'];
}else{
   echo $form->value("email");
}
?>">
</td>
<td><? echo $form->error("email"); ?></td>
</tr>
<tr><td colspan="2" align="right">
<input type="hidden" name="subedit" value="1">
<input type="submit" value="Save Changes"></td></tr>
<tr><td colspan="2" align="left"></td></tr>
<tr>
	<td colspan="3" style="color:#900; font-size:16px" align="center"><br>NOTE: When adding a phone number to a blank field, you need to hit backspace to make sure the cursor is at the left edge of the field. The Phone number format is: xxx-yyy-zzzz.</td>
</tr>
<tr>
	<td colspan="3" style="color:#900; font-size:16px" align="center"><br>NOTE: You do not need to change ALL the fields. Make only the changes you want and click the "Save Changes" button..</td>
</tr>
</table>
</form>

<?
}
}
?>

</body>
</html>

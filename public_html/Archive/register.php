<?
/**
 * Register.php
 * 
 * Displays the Add Useer form so the Administrator
 * can add a user to the system.
 */
include("include/session.php");
?>

<html>
<title>Add User</title>
<body>

<?
/**
 * The form has been submitted and the
 * results have been processed.
 */
if(isset($_SESSION['regsuccess'])){
   /* The user  was successfully added */
   if($_SESSION['regsuccess']){
      echo "<h1>User Added</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b> has been added to the database.</p>";
      echo "<br>Return to  [<a href=\"./admin/admin.php\">Admin Center</a>]<br>";
   }
   /* Registration failed */
   else{
      echo "<h1>Registration Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
?>

<h1>Add User</h1>
<?
/** Make sure an Administrator is processing this form  */
$level = $session->userlevel;
if($level == 9)	{

/** Check if there are errors in the form  */
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}

/* Display the Form  */
?>
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr>
	<td>Username:</td>
    <td><input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>"></td>
    <td><? echo $form->error("user"); ?></td>
</tr>
<tr>
	<td>Password:</td>
    <td><input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"></td>
    <td><? echo $form->error("pass"); ?></td>
</tr>
<tr>
	<td>User Level:</td>
    <td><select name="userlevel" >
		<option value="1">Normal User </option>
		<option value="2">Detail Coordinator</option>
		<option value="3">Account Admin</option>
		<option value="4">Firearms Coordinator</option>
		<option value="5">Detail Coord & Account Admin</option>
		<option value="6">Detail Coord & Firearms Coord</option>
		<option value="7">Account Admin & Firearms Coord</option>
		<option value="9">Administrator</option>
		</select></td>
    <td><? echo $form->error("userlevel");?></td>
</tr>
<tr>
	<td>Sort Order:</td>
    <td><input type="text" name="sort" maxlength="4" value="<? echo $form->value("sort");?>"></td>
    <td><? echo $form->error("sort");?></td>
</tr>
<tr>
	<td>Unit Number:</td>
    <td><input type="text" name="unit_num" maxlength="3" value="<? echo $form->value("unit_num");?>"></td>
    <td><? echo $form->error("unit_num");?></td>
</tr>
<tr>
	<td>Rank:</td>
    <td><select name="rank" >
		<option value=" "> </option>
		<option value="Chief">Chief</option>
		<option value="Assistant Chief">Assistant Chief</option>
		<option value="Major">Major</option>
		<option value="Captain">Captain</option>
		<option value="Lieutenant">Lieutenant</option>
		<option value="Sergeant">Sergeant</option>
		<option value="Corporal">Corporal</option>
		<option selected="yes" value="Deputy">Deputy</option>
		</select></td>
    <td><? echo $form->error("rank");?></td>
</tr>
<tr>
	<td>Name (Last/First):</td>
    <td><input type="text" name="name" maxlength="50" value="<? echo $form->value("name");?>"></td>
    <td> <? echo $form->error("name");?></td>
</tr>
<tr>
	<td>Home Phone:</td>
    <td><input type="text" name="phone_home" maxlength="12" value="<? echo $form->value("phone_home");?>"></td>
    <td><? echo $form->error("phone_home");?></td>
</tr>
<tr>
	<td>Work Phone:</td>
    <td><input type="text" name="phone_work" maxlength="12" value="<? echo $form->value("phone_work");?>"></td>
    <td><? echo $form->error("phone_work");?></td>
</tr>
<tr>
	<td>Cell Phone:</td>
    <td><input type="text" name="phone_cell" maxlength="12" value="<? echo $form->value("phone_cell");?>"></td>
    <td><? echo $form->error("phone_cell");?></td>
</tr>
<tr>
	<td>Email:</td>
    <td><input type="text" name="email" maxlength="50" value="<? echo $form->value("email"); ?>"></td>
    <td><? echo $form->error("email"); ?></td>
</tr>
<tr>
    <td>Probationary:</td>
    <td><input type="text" name="probation" value="1"></td>
    <td><? echo $form->error("probation"); ?></td>            
</tr>
<tr>
	<td>Display Name (First/Last):</td>
    <td><input type="text" name="displayname" maxlength="100" value="<? echo $form->value("displayname"); ?>"></td>
    <td><? echo $form->error("displayname");?></td>
</tr>    
<tr>
	<td colspan="2" align="right">
		<input type="hidden" name="subjoin" value="1">
		<input type="submit" value="Join!"></td>
</tr>
<tr>
	<td colspan="2" align="left"><a href="main.php">Back to Main</a></td>
</tr>
</table>
</form>

<?
}
else	{
	echo "You do not have the proper user level to access this form.<br/>";
	echo "Contact the administrator if you feel that this is incorrect.<br/>";
	echo "<br/>Click [<a href=\"main.php\">here</a>] to continue.";
	} 
}
?>

</body>
</html>

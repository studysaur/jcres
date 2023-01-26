<?php
/**
 * Register.php
 * 
 * Displays the Add Useer form so the Administrator
 * can add a user to the system.
 */
include "include/session.php";
?>

<html>
<title>Add User</title>
<body>

<?php
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
<?php
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
	<td>Username: This needs to match the county email</td>
    <td><input type="text" name="username" maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
    <td><?php echo $form->error("user"); ?></td>
</tr>
<tr>
	<td>First Name:</td>
    <td><input type="text" name="fname" maxlength="30" value="<?php echo $form->value("fname"); ?>"></td>
    <td><?php echo $form->error("fname"); ?></td>
</tr>
<tr>
	<td>Middle Name:</td>
    <td><input type="text" name="mname" maxlength="30" value="<?php echo $form->value("mname"); ?>"></td>
    <td><?php echo $form->error("mname"); ?></td>
</tr>
<tr>
	<td>Last Name:</td>
    <td><input type="text" name="lname" maxlength="30" value="<?php echo $form->value("lname"); ?>"></td>
    <td><?php echo $form->error("lname"); ?></td>
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
    <td><?php echo $form->error("userlevel");?></td>
</tr>
<tr>
	<td>Unit Number:</td>
    <td><input type="text" name="unit_num" maxlength="3" value="<?php echo $form->value("unit_num");?>"></td>
    <td><?php echo $form->error("unit_num");?></td>
</tr>
<tr>
	<td>Rank:</td>
    <td><select name="rankno" >
		<option value=" "> </option>
		<option value="1">Sheriff</option>
		<option value="2">Chief</option>
		<option value="3">Deputy Chief</option>
		<option value="4">Chaplin</option>
		<option value="5">Major</option>
		<option value="6">Captain</option>
		<option value="7">Lieutenant</option>
		<option value="8">Sergeant</option>
		<option value="9">Corporal</option>
		<option value="10">Investigator</option>
		<option selected="yes" value="11">Deputy</option>
		<option value="12">Explorer</option>
		</select></td>
    <td><?php echo $form->error("rank");?></td>
</tr>
<tr>
<tr>
	<td>Cell Phone:</td>
    <td><input type="text" name="phone_cell" maxlength="12" value="<?php echo $form->value("phone_cell");?>"></td>
    <td><?php echo $form->error("phone_cell");?></td>
</tr>
<tr>
	<td colspan="2" align="right">
		<input type="hidden" name="subjoin" value="1">
		<input type="submit" value="submit!"></td>
</tr>
<tr>
	<td colspan="2" align="left"><a href="main.php">Back to Main</a></td>
</tr>
</table>
</form>

<?php
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

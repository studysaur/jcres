<?php
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
require_once '../jcres_connect.php';

?>
<!DOCTYPE html>
<html>
<title>User Edit Account Page</title>
<body>

<?php
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

<?php
/**
 * If user is not logged in, then do not display anything.
 * If user is logged in, then display the form to edit
 * account information, with the current email address
 * already in the field.
 */
if($session->logged_in){
?>

<h1>User Account Edit : <?php echo $session->username; ?></h1>
<?php
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<form action="process.php" method="POST">
<table width="495" align="left" border="0" cellspacing="0" 
cellpadding="3">
<tr>
<td width="153">Current Password:</td>
<td width="296"><input type="password" name="curpass" maxlength="30" 
value="
<?php echo $form->value("curpass"); ?>"></td>
<td><?php echo $form->error("curpass"); ?></td>
</tr>
<tr>
<td>New Password:</td>
<td><input type="password" name="newpass" maxlength="30" value="
<?php echo $form->value("newpass"); ?>"></td>
<td><?php echo $form->error("newpass"); ?></td>
</tr>
<tr>
<td>Home Phone:</td>
	<td><input type="text" name="phone_home" maxlength="12" value="
	<?php 
	if($form->value("phone_home") == ""){
		echo $session->userinfo ['phone_home'];
	}else{
		echo $form->value("phone_home");
	}	
	?>">
</td>
<td><?php echo $form->error("phone_home"); ?></td>
</tr>


<tr>
<td>Cell Phone:</td>
	<td><input type="text" name="phone_cell" maxlength="12" value="
	<?php 
	if($form->value("phone_cell") == ""){
		echo $session->userinfo ['phone_cell'];
	}else{
		echo $form->value("phone_cell");
	}	
	?>">
</td>
<td><?php echo $form->error("phone_cell"); ?></td>
</tr>
<tr>
<td>Cell Phone Carrier:</td>
<td><select name="cellcarrier">
<?php
        $query = "SELECT cellcarrier, gateWay FROM smsGate ORDER BY cellcarrier";
        $result = db_query($query);
		$scpc = $session->userinfo ["cellcarrier"];     
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            $cpc=$row["cellcarrier"];  // allows us to use the value without ""
            if ($cpc == $scpc){
            	print<<<EOT
            	<option value="$cpc" selected> $cpc</option>\r\n
EOT;
				} else {            	
            	print<<<EOT
            	<option value="$cpc"> $cpc</option>\r\n
EOT;
				} // end else
        	} //end while
        } //end if
?>
</select></td>

<tr><td colspan="2" align="right">
<input type="hidden" name="subedit" value="1">
<input type="submit" value="Save Changes"></td></tr>
<tr><td colspan="2" align="left"></td></tr>
<tr><td colspan="3">Note:  This system uses an old encryption scheme that is easily hacked.  The only saving grace is there is no information that could be used for identity theft other than the password itself.  Please do not use a password that you use on other more secure systems!  This will be corrected in the near future!</td></tr>
<tr>
	<td colspan="3" style="color:#900; font-size:16px" align="center"><br>NOTE: When adding a phone number to a blank field, you need to hit backspace to make sure the cursor is at the left edge of the field. The Phone number format is: xxx-yyy-zzzz.</td>
</tr>
<tr>
	<td colspan="3" style="color:#900; font-size:16px" align="center"><br>NOTE: You do not need to change ALL the fields. Make only the changes you want and click the "Save Changes" button..</td>
</tr>
</table>
</form>

<?php
}
}
?>

</body>
</html>

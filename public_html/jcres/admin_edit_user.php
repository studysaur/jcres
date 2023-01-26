<?php
/**
 * Administrator Edit User.php
 * 
 * Allows an Administrator to edit the User information
 * for any user.
 */
// require_once '../jcres_connect.php'; 

include("include/session.php");
?>
<!DOCTYPE HTML>
<html>
<title>Administrator Edit User</title>
<body>

<?php
/** Make sure an Administrator is processing this form  */
$level = $session->userlevel;
if($level != 9)	{
	echo "You do not have the proper user level to access this form.<br/>";
	echo "Contact the administrator if you feel that this is incorrect.<br/>";
	echo "<br/>Click [<a href=\"main.php\">here</a>] to continue.";
} else {

/**
 * The form has been submitted and the
 * results have been processed.
 */
if(isset($_SESSION['updatesuccess'])){
   /* The user  was successfully added */
   if($_SESSION['updatesuccess']){
      echo "<h1>Record Updated</h1>";
      echo "<p>The record for <b>".$_SESSION['nameupdated']."</b> has been updated in the database.</p>";
      echo "<br>Return to  [<a href=\"./admin/admin.php\">Admin Center</a>]<br>";
   }
   /* Registration failed */
   else{
      echo "<h1>Record Update Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your record update for <b>".$_SESSION['nameupdated']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['updatesuccess']);
   unset($_SESSION['nameupdated']);
}

?>

	<h1>Administrator Edit User Information</h1>

<?php 
$q = "SELECT f_name, l_name, username, uid FROM ".TBL_USERS." ORDER BY l_name";
$result = $database->query($q);

	$option = "";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
		$name = $row['l_name'] . ',' . $row['f_name'];
		$username = $row['username'];
		$uid=$row['uid'];
		$option = $option."<option value='$username'>$username</option>";
	}
	$option = $option."</select>";
?>
<form action="" method="POST">
<table align="center" border="0" cellpadding="3" cellspacing="0">
<tr>
	<td><h2>Select User to edit:</h2></td>
    <td><select name="username"><?php echo "$option"?></td>
</tr>
<tr>
	<td colspan="2" align="right">
    	<input type="submit" value="Submit">
		<input type="hidden" name="getDeputy" value="1"></td>
</tr>
</table>
</form>

<?php
$q="SELECT * FROM " . TBL_USERS  ." WHERE username = '$username' ";
$result1 = $database->query($q);
$row = mysql_fetch_array($result1, MYSQL_ASSOC);
	// not sure if I will display this or status or sort
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$_SESSION['username'] = $_POST['username'];
}
if (isset($_POST['username'])){
	$username=$_POST["username"];
	$userlevel = $row['userlevel'];
	$status= $row['status'];	
	$unit_num = $row['unit_num'];
	$rank = $row['rank'];
	$phone_home = $row['phone_home'];
	$phone_work = $row['phone_work'];
	$phone_cell = $row['phone_cell'];
	$probationary = $row['probationary'];
	$code = $row['code'];
	$squad = $row['squad'];
	$fname = $row['f_name'];
	$mname = $row['m_name'];
	$lname = $row['l_name'];
	$uid = $row['uid'];
}


if(isset($_POST['getDeputy']))	{
	
/* Display the Form  */
?>
	<form action="process.php" method="POST">
	<table align="left" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td>Username:</td><td><input type="text" name="username" value="<?php echo $username;?>"</td>
    </tr>
    <tr>
    	<td>Editing </td><td><?php echo $username;?></td><td>ID</td><td><?php echo$uid; ?></td>
    </tr>
	<!--  <tr>
		<td>Name:</td>
    	<td><input type="text" name="name" maxlength="50" value=<?php echo $name;?></td>
	    <td> <? echo $form->error("name");?></td>
	</tr-->
	<tr>
		<td>First Name:</td>
    	<td><input type="text" name="fname" value="<?php echo $fname?>"></td>
	    <td> <?php echo $form->error("fname");?></td>
	</tr>
	<tr>
		<td>Middle Name:</td>
    	<td><input type="text" name="mname" maxlength="50" value="<? echo $mname;?>"></td>
	    <td> <? echo $form->error("mname");?></td>
	</tr>
	<tr>
		<td>Last Name:</td>
    	<td><input type="text" name="lname" maxlength="50" value="<? echo $lname;?>"></td>
	    <td> <? echo $form->error("lname");?></td>
	</tr>
	<tr>
		<td>User Level:</td>
    	<td><select name="userlevel" >
			<option value="1">Normal User </option>
            <? if ($userlevel == '2') { ?>
				<option selected="yes" value="2">Detail Coordinator</option>
			<? } else { ?>				
				<option value="2">Detail Coordinator</option> 
			<? } 
            if ($userlevel == '3') { ?>
            	<option selected="yes" value="3">Account Admin</option>
            <? } else { ?>     
				<option value="3">Account Admin</option>
            <? }
			if ($userlevel == '4') { ?>    
				<option selected="yes" value="4">Firearms Coordinator</option>
            <? } else { ?>   
                <option value="4">Firearms Coordinator</option>
            <? }
			if ($userlevel == "5") { ?>    
				<option selected="yes" value="5">Detail Coord & Account Admin</option>
            <? } else { ?>
                <option value="5">Detail Coord & Account Admin</option>
            <? }
			if ($userlevel == '6') { ?>
 				<option selected="yes" value="6">Detail Coord & Firearms Coord</option>
            <? } else { ?>    
				<option value="6">Detail Coord & Firearms Coord</option>
            <? }
			if ($userlevel == '7')	{ ?>    
				<option selected="yes" value="7">Account Admin & Firearms Coord</option>
            <? } else { ?>
                <option value="7">Account Admin & Firearms Coord</option>
            <? }
			if ($userlevel =='9') { ?>    
				<option selected="yes" value="9">Administrator</option>
            <? } else { ?>    
                <option value="9">Administrator</option>
            <? } ?>    
			</select></td>
    	<td><? echo $form->error("userlevel");?></td>
	</tr>
    <tr>
          <td>Squad:</td>
          <td><input type="text" name="squad" maxlength="4" value="<? echo $squad;?>"></td>
    </tr>	
    <tr>
    	<td>Code:</td>
    	<td><input type="text" name="code" maxlength="5" value="<? echo $code;?>"></td>
    </tr>        
	<tr>
		<td>Unit Number:</td>
	    <td><input type="text" name="unit_num" maxlength="3" value="<? 	echo $unit_num;?>"></td>
	    <td><? echo $form->error("unit_num");?></td>
	</tr>
	<tr>
		<td>Rank:</td><td><?echo $rank;?></td>
	</tr>
	<tr>
		<td>Rank:</td>
		<td><select name="rank">
<?
        // set up rank drop down box
        $query = "SELECT rank FROM rank";
        $res = $database->query($query);
        $n_rows = mysql_num_rows($res);
   //     echo $n_rows;
            while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
            $rnk=$row['rank'];
                if($rnk == $rank){
                print<<<EOT
                <option value="$rnk" selected> $rnk</option>
EOT;
                } else { // end if $rnk
                print<<<EOT
                <option value="$rnk">$rnk</option>
EOT;
                } //end else
            } // endwhile
     ?>
   
   </select>
   </td>
	</tr>
	<tr>
		<td>Home Phone:</td>
	    <td><input type="text" name="phone_home" maxlength="12" value="<? echo $phone_home;?>"></td>
	    <td><? echo $form->error("phone_home");?></td>
	</tr>
	<tr>
		<td>Work Phone:</td>
	    <td><input type="text" name="phone_work" maxlength="12" value="<? echo $phone_work;?>"></td>
	    <td><? echo $form->error("phone_work");?></td>
	</tr>
	<tr>
		<td>Cell Phone:</td>
    	<td><input type="text" name="phone_cell" maxlength="12" value="<? echo $phone_cell;?>"></td>
	    <td><? echo $form->error("phone_cell");?></td>
	</tr>
	<tr>
	    <td>Probationary:</td>
		<? if ($probationary == "1")	{?>
		    <td><input type="radio" name="probation" value="1" checked>Yes
			<input type="radio" name="probation" value="0">No
		    </td>
		<? } else { ?>
		    <td><input type="radio" name="probation" value="1">Yes
			<input type="radio" name="probation" value="0" checked>No
		    </td>
		<? } ?>
		    <td></td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="hidden" name="uid" value=<? echo $uid; ?>
			<input type="hidden" name="subAdminEditUser" value="1">
			<input type="submit" value="Submit Changes"></td>
	</tr>
	<tr>
		<td colspan="2" align="left"><a href="main.php">Back to Main</a></td>
	</tr>
	</table>
	</form>

<?php
} // if isset line 107
} // if else of level 9 line 20
?>

</body>
</html>

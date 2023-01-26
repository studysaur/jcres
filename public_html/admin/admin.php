<?
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("../include/session.php");

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
function displayUsers(){
   global $database;
   $q = "SELECT username,userlevel,email,timestamp "
       ."FROM ".TBL_USERS." ORDER BY userlevel DESC,username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Level</b></td><td><b>Email</b></td><td><b>Last Active</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname  = mysql_result($result,$i,"username");
      $ulevel = mysql_result($result,$i,"userlevel");
      $email  = mysql_result($result,$i,"email");
      $time   = mysql_result($result,$i,"timestamp");
      if ($time) {
      	   $date = date('H:i:s d-M-Y',$time); }
      else {
	   $date = chr(173); }

      echo "<tr><td>$uname</td><td>$ulevel</td><td>$email</td><td>$date</td></tr>\n";
   }
   echo "</table><br>\n";
}

/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayBannedUsers(){
   global $database;
   $q = "SELECT username,timestamp "
       ."FROM ".TBL_BANNED_USERS." ORDER BY username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Time Banned</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname = mysql_result($result,$i,"username");
      $time  = mysql_result($result,$i,"timestamp");

      echo "<tr><td>$uname</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}
   
/**
 * User not an administrator, redirect to main page
 * automatically.
 */
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else{
/**
 * Administrator is viewing page, so display all
 * forms.
 */
?>
<html>
<title>Admin Center</title>
<body>
<h1>Admin Center</h1>
<font size="5" color="#ff0000">
<b>::::::::::::::::::::::::::::::::::::::::::::</b></font>
<font size="4">Logged in as <b><? echo $session->username; ?></b></font><br><br>

Back to [<a href="../main.php">Main Page</a>]<br><br></td>
[<a href="../register.php">Add User</a>]<br><br></td>
[<a href="../admin_edit_user.php">Edit User Account</a>]<br><br></td>

<?
if($form->num_errors > 0){
   echo "<font size=\"4\" color=\"#ff0000\">"
       ."!*** Error with request, please fix</font><br><br>";
}
?>
<table align="left" border="0" cellspacing="5" cellpadding="5">
<tr><td>
<?
/**
 * Display Users Table
 */
?>
<h3>Users Table Contents:</h3>
<?
displayUsers();
?>
</td></tr>
<tr>
<td>
<br>
<?
/**
 * Update User Level
 */
?>
<h3>Update User Level</h3>
<h4>Available User Levels</h4>
<table> 
<tr><th width="80" align="left">Level</th><th 
align="left">Access</th></tr>
<tr><td>1</td><td>Normal User</td></tr>
<tr><td>2</td><td>Detail Coord</td></tr>
<tr><td>3</td><td>Account Admin</td></tr>
<tr><td>4</td><td>Firearms Coord</td></tr>
<tr><td>5</td><td>Detail Coord & Account Admin</td></tr>
<tr><td>6</td><td>Detail Coord & Firearms Admin</td></tr>
<tr><td>7</td><td>Account Admin & Firearms Admin</td></tr>
<tr><td>9</td><td>Administator</td></tr>
<tr></tr>
<? echo $form->error("upduser"); ?>
<table>
<form action="adminprocess.php" method="POST">
<tr><td>
Username:<br>
<input type="text" name="upduser" maxlength="30" value="<? echo $form->value("upduser"); ?>">
</td>
<td>
Level:<br>
<select name="updlevel">
<option value="1">1
<option value="2">2
<option value="3">3
<option value="4">4
<option value="5">5
<option value="6">6
<option value="7">7
<option value="9">9
</select>

</td>
<td>
<br>
<input type="hidden" name="subupdlevel" value="1">
<input type="submit" value="Update Level">
</td></tr>
</form>
</table>
<? 
/** 
 * Delete a User From the System
 */
 ?>
 <tr>
 	<td><br></td>
 </tr>
 <tr>
 	<td><h3>Delete User</h3></td>
 </tr>
 <form action="adminprocess.php" method="post">
 <tr>
 	<td> Username:<br> <input type="text" name="deluser" maxlength="30" value="<? echo $form->value("uname"); ?>">
    </td>
 </tr>
 <tr>
    <td><input type="hidden" name="subdeluser" value="1">
    	<input type="submit" value="Delete User">
    </td>
 </tr>
 </form>
 

</table>
</body>
</html>
<?
}
?>


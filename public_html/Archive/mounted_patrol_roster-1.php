<? 
/* Mounted Patrol Roster
 * Reads the user table, sorts it by Unit Number and displays the information 
 * in a table.
 */
include ("./include/session.php");
if(!$session->logged_in) {
	
	header("Location:main.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Jackson County Mounted Patrol - Roster</title>
	<meta charset="utf-8">
	<meta name="author" content="Jeffrey Clark">
       <META HTTP-EQUIV="REFRESH" CONTENT="5">
	<!-- internal styles -->
	<style>
	body	{
		font-family: Verdana, Geneva, sans-serif;
		background-color: #FFF;
		padding: 50px;
	}
	
	h1 {
		text-align:center;
		border-bottom:2px solid #009;
		margin-bottom: 50px;
	}
	
	ul#mainMenu, ul.sub1	{
		list-style-type:none;
		font-size:11px;
	}
	
	ul#mainMenu li  {
		width: 110px;
		text-align: center;
		position:relative;
		float: left;
		margin-right: 4px;
	}
	
	ul#mainMenu a {
		text-decoration:none;
		display:block;
		width: 110px;
		height:20px;
		color:#CCC;
		padding-top:7px;	
		background-color: #006;
		border: 1px solid #CCC;
		border-radius: 5px;
	}
	
	ul#mainMenu .sub1 a {
		margin-top: 0px;
	}
	
	ul#mainMenu li:hover > a	{
		background-color: #3366FF;
		color:#003;
	}
	
	ul#mainMenu li:hover a:hover {
		background-color: #3366FF;
	}
	
	
	ul#mainMenu ul.sub1 {
		display:block;
		position:absolute;
		left: 0px;
	}
	
	ul#mainMenu li:hover .sub1 {
		display:block;
	}

	</style> 

</head>
<body bgcolor="#FFFFFF" lang=EN-US>
<?
$q = "SELECT username FROM ".TBL_ACTIVE_USERS
    ." ORDER BY timestamp DESC,username";
$result = $database->query($q);
/* Error occurred, return given name by default */
$num_rows = mysql_numrows($result);
if(!$result || ($num_rows < 0)){
   echo "Error displaying info";
}
   if($session->isAdmin()) {
?>
<ul id="mainMenu" style="width:1170px">
	<li><a href="index.php">Home</a></li>
	<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
	<li><a href="unit_details.php">Unit Details</a></li>
	<li><a href="personal_detail_sheet.php">Account Balance</a></li>
	<li><a href="citation_report.php">Various Reports</a></li>
	<li><a href="./admin/admin.php">Admin Center</a></li>
<?  print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
	<li><a href="process.php">Logout</a></li>
	<li><a href="#">Members Online</a>
		<ul class="sub1">
                 <?
                 if($num_rows > 1){
                    for($i=0; $i<$num_rows; $i++){
                    $uname = mysql_result($result,$i,"username");
                    $n = "SELECT display_name FROM ".TBL_USERS." where username = '".$uname."'";
                    $who = $database->query($n);
                    $name = mysql_result($who, 0);
                    if ($uname !== $session->username) {
			   print ("<li><a href=\"#\">$name</a></li>");
                 	   } 
                    }                 	   
                 } else {
                    print ("<li><a href=\"#\">Just you</a></li>");
                 }
                 ?> 
		</ul>
	</li>

</ul>
<?
    }
    else if($session->username == 'visitor') {
?>
<ul id="mainMenu" style="width:1170px">
	<li><a href="index.php">Home</a></li>
	<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
	<li><a href="unit_details.php">Unit Details</a></li>
	<li><a href="citation_report.php">Various Reports</a></li>
	<li><a href="process.php">Logout</a></li>
	<li><a href="#">Members Online</a>
		<ul class="sub1">
			<li><a href="#">Jeffrey Clark</a></li>
			<li><a href="#">Becky Welch</a></li>
			<li><a href="#">Bob Nusko</a></li>
		</ul>
	</li>

</ul>
<?
    }
   else	
    {
?>
<ul id="mainMenu" style="width:1170px">
	<li><a href="index.php">Home</a></li>
	<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
	<li><a href="unit_details.php">Unit Details</a></li>
	<li><a href="personal_detail_sheet.php">Account Balance</a></li>
	<li><a href="citation_report.php">Various Reports</a></li>
	<?  print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
	<li><a href="process.php">Logout</a></li>
	<li><a href="#">Members Online</a>
		<ul class="sub1">
			<li><a href="#">Jeffrey Clark</a></li>
			<li><a href="#">Becky Welch</a></li>
			<li><a href="#">Bob Nusko</a></li>
		</ul>
	</li>
</ul>
<?
    }
?>
<div class=Section1>
	<p align=center style='text-align:center'><span
style='font-size:24.0pt;line-height:115%;font-family: Verdana, sans-serif'><br>Jackson
		County Sheriff's Mounted Patrol Division</span></p>
	<p align=center style='text-align:center'><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'>P.O.
		Box 1624 - Pascagoula, Mississippi 39568-1624</span></p>
	<p align=center style='text-align:center'><span class=GramE><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'>S.O.
		228-769-3063 - S.O. Fax 228-769-6168 - W. Sub.</span></span><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'> 228-875-0475</span></p>
	<table width=1100 border=1 align="center" cellpadding=2 
cellspacing=1>
		<tr>
			<td width=68 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;
  font: 100% Verdana, Arial, Helvetica, sans-serif;    '><b>Unit #</b></span></p></td>
			<td width=115 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;
  font: 100% Verdana, Arial, Helvetica, sans-serif;    '><b>Rank</b></span></p></td>
			<td width=214 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;  font: 100% Verdana, Arial, Helvetica, sans-serif;    
'><b>Name</b></span></p></td>
			<td width=130 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;
  font: 100% Verdana, Arial, Helvetica, sans-serif;    '><b>Home Phone</b></span></p></td>
			<td width=131 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;
  font: 100% Verdana, Arial, Helvetica, sans-serif;    '><b>Work Phone</b></span></p></td>
			<td width=130 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;
  font: 100% Verdana, Arial, Helvetica, sans-serif;    '><b>Cell Phone</b></span></b></p></td>
			<td width=296 valign=top><p style='line-height:
  normal'><span style='font-size:14.0pt;
  font: 100% Verdana, Arial, Helvetica, sans-serif;    '><b>Email</b></span></p></td>
<td width=20 valign=top><p style='line-height:normal'><span style='font-size:14.0pt; font: 100% Verdana, Arial, Helvetica, sans-serif;'><b>P*</b></span></p>
		</tr>
<?
global $database;
/* $user_info = $database->getAllUsers(); */
$q = "SELECT sort, unit_num, rank, name, phone_home, phone_work, phone_cell, 
email, probationary FROM ".TBL_USERS." where username != 'visitor' ORDER BY sort";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from User table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$unit_num = $row['unit_num'];
	if ($unit_num == 'LOA')	break;
	$rank = $row['rank'];
	$name = $row['name'];
	$phone_home = $row['phone_home'];
		if (!$phone_home){
			$phone_home=chr(0);}
	$phone_work = $row['phone_work'];
		if (!$phone_work){
			$phone_work=chr(0);}
	$phone_cell = $row['phone_cell'];
		if (!$phone_cell){
			$phone_cell=chr(0);}	
	$test = $row['email'];
	if(!$test) {
		$email=chr(0);
		}
	else
		{
		$email = "<a 
href=\"mailto:".$row['email']."\"><span='color:blue;'>".$row['email']."</span></a>";
		}
	$probationary = $row['probationary'];
	if($probationary)  {
		$probationary="X";
		}
	else
		{
		$probationary=chr(0);
		}


print("<tr><td><span style='font:100% Verdana, Arial, 
Helvetica, sans-serif;'>$unit_num</span></td><td><span style='font:100% 
Verdana, Arial, 
Helvetica, 
sans-serif;'>$rank</span></td><td width=180px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$name</span></td><td width=120px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$phone_home</span></td><td width=120px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$phone_work</span></td><td width=120px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$phone_cell</span></td><td><span 
style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
$email</span></td><td align=center><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$probationary</span></td></tr>\r");

}

mysql_free_result($result);
?>


</table>
</div>
<p align=center>* an "X" in the P column indicates the officer is still in a <b>Probationary</b> period.</p>
</body>
</html>

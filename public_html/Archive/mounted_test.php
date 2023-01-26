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
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
<style>
<!--
@import url("horzlist.css");
a:link, span.MsoHyperlink {
	color:blue;
	text-decoration:underline;
	}
a:visited, span.MsoHyperlinkFollowed {
	color:purple;
	text-decoration:underline;
	}
	
div#horzlist	{
	height: 30px;
	width: 100%;
	border-top: solid #000 1px;
	border-bottom: solid #000 1px;
	background-color: #336699;
	}
	
div#horzlist ul {
	margin: 0px;
	padding: 0px;
	font:Verdana, Arial, Helvetica, sans-serif;
	font-size:small;
	color: #FFCC00;
	line-height: 30px;
	white-space: nowrap;
	}

div#horzlist li {
	list-style-type: none;
	display: inline;
	}

div#horzlist a {
	text-decoration: none;
	padding: 7px 10px;
	color: #FFCC00
	}
	
div#horzlist a:link {
	color: #CCC
	}
	
div#horzlist a:visited {
	color: #CCC
	}
	
div#horzlist a:hover {
	font-weight: bold;
	color: #FFF;
	background-color: #3366FF
	}
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
	
-->
</style>

<title>Jackson County Mounted Patrol - Roster</title></head>
<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<div id="horzlist">
<?
   if($session->isAdmin()) {
?>
	<ul>
		<li><a href="index.php">Home</a> </li>
		<li><a href="mounted_patrol_roster.php">Current Roster </a></li>
		<li><a href="unit_details.php">Unit Details </a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail Sheet </a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
		<li><a href="./admin/admin.php">Admin Center</a></li>
		<li><a href="./messageboard/index.php">Message Board</a></li>
<?      print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	</ul>
<?
    }
    else if($session->username == 'visitor') {
?>
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
		<li><a href="unit_details.php">Unit Details</a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
		<li><a href="./messageboard/index.php">Message Board</a></li>
		<li><a href="process.php">Logout</a></li>
	</ul>
<?
    }
    else	
    {
?>
        <ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
		<li><a href="unit_details.php">Unit Details</a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail Sheet</a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
		<li><a href="./messageboard/index.php">Message Board</a></li>
<?	print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	<ul>
<?
    }
?>

</div>
<div class=Section1>
	<p align=center style='text-align:center'><span
style='font-size:24.0pt;line-height:115%;font-family: Verdana, sans-serif'>Jackson
		County Sheriff’s Mounted Patrol Division</span></p>
	<p align=center style='text-align:center'><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'>P.O.
		Box 1624 – Pascagoula, Mississippi 39568-1624</span></p>
	<p align=center style='text-align:center'><span class=GramE><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'>S.O.
		228-769-3063 – S.O. Fax 228-769-6168 – W. Sub.</span></span><span
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
		</tr>
<?
global $database;
/* $user_info = $database->getAllUsers(); */
$q = "SELECT unit_num, rank, name, phone_home, phone_work, phone_cell, 
email FROM ".TBL_USERS." where username != 'visitor' ORDER BY unit_num";
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
			$phone_home=chr(173);}
	$phone_work = $row['phone_work'];
		if (!$phone_work){
			$phone_work=chr(173);}
	$phone_cell = $row['phone_cell'];
		if (!$phone_cell){
			$phone_cell=chr(173);}	
	$test = $row['email'];
	if(!$test) {
		$email=chr(173);
		}
	else
		{
		$email = "<a 
href=\"mailto:".$row['email']."\"><span='color:blue;'>".$row['email']."</span></a>";
		}
	
print("<tr><td><span style='font:100% Verdana, Arial, 
Helvetica, sans-serif;'>$unit_num</span></td><td><span style='font:100% 
Verdana, Arial, 
Helvetica, 
sans-serif;'>$rank</span></td><td><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$name</span></td><td width=120px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$phone_home</span></td><td width=120px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$phone_work</span></td><td width=120px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$phone_cell</span></td><td><span 
style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
$email</span></td></tr>\r");

}
mysql_free_result($result);
?>
</table>
</div>
</body>
</html>

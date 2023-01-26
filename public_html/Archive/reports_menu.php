<?
/* Reports Menu
 * Displays the differnet reports that can be requested.
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
		<li><a href="citation_report.php">Monthly Citation Report</a></li>
		<li><a href="./admin/admin.php">Admin Center</a></li>
		<li><a href="reports_menu.php">Reports</a></li>
<?      print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	</ul>
<?
    }
    else if($session->username == 'visitor') {
?>
		<li><a href="index.php">Home</a></li>
		<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
		<li><a href="unit_details.php">Unit Details</a></li>
		<li><a href="./messageboard/index.php">Message Board</a></li>
		<li><a href="reports_menu.php">Reports</a></li>
		<li><a href="process.php">Logout</a></li>
<?
    }
    else	
    {
?>
        <ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
		<li><a href="unit_details.php">Unit Details</a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail 
Sheet</a></li>
		<li><a href="reports_menu.php">Reports</a></li>
		<li><a href="citation_report.php">Monthly Citation Report</a></li>
<?	print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	<ul>
<?
    }
?>

</div>
<table width=800 border=0>
<caption><h2>Select a Report Type</h2></caption>
<tr>
	<td align="center"><h3><a 
href="detail_summary_form.php">Summary of Details Worked</a></h3></td>
</tr>

</table>
</body>
</html>

<?
/* citation reports - Interface to various report types
 *
 */
include	("./include/session.php");

if(!$session->logged_in)	{

	header("Location:main.php");
	}
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
<style>
<!--
@import url("horzlist.css");
#warning {
	margin: 50px;
	width: 60%;
}
#excel	 {
	margin: 50px;
	width: 60%;
}
#version {
	width: 300px;
	margin-top: 20px;
	margin-left: 250px;
}
#weapons {
	width: 300px;
	margin-top: 20px;
	margin-left: 250px;
}

#financials {
	width: 300px;
	margin-top: 20px;
	margin-left: 250px;
}
#details	{
	width: 300px;
	margin-top: 20px;
	margin-left: 250px;
}
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
	
-->
</style>
<title>Jackson County Mounted Patrol - Citation Report</title></head>
<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<div id="horzlist">
<?
if($session->isAdmin())	{
?>
	<ul>
		<li><a href="index.php">Home</a> </li>
		<li><a href="mounted_patrol_roster.php">Current Roster </a></li>
		<li><a href="unit_details.php">Unit Details </a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail Sheet </a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
		<li><a href="./admin/admin.php">Admin Center</a></li>
<?	print("<li><a href=\"userinfo.php?user=$session->username\">My 
Account</a></li>");	?>
		<li><a href="process.php">Logout</a></li>
	</ul>
<?
} else if($seaaion-Lusername == 'visitor')	{
?>
	<ul>
		<li><a href="index.php">Home</a> </li>
		<li><a href="mounted_patrol_roster.php">Current Roster </a></li>
		<li><a href="unit_details.php">Unit Details </a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
		<li><a href="process.php">Logout</li>
	</ul>
<?
} else	{
?>
	<ul>
		<li><a href="index.php">Home</a> </li>
		<li><a href="mounted_patrol_roster.php">Current Roster </a></li>
		<li><a href="unit_details.php">Unit Details </a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail Sheet </a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
<?	print("<li><a href=\"userinfo.php?user=$session->username\">My 
Account</a></li>");	?>
		<li><a href="process.php">Logout</li>
	</ul>
<?	}	?>
</div>
<div id="warning"><span style="text-align:center">You need to have Adobe Acrobat Reader installed in order to read/save the Adobe Acrobat version of the Monthly Report. If you do not have Adobe Acrobat Reader, you can download the free version from: <a href="http://www.adobe.com/products/acrobat/readstep2_allversions.html">http://www.adobe.com</a></span></div>
<div id="excel"><span style="text-align:center">If you do not have Microsoft Excel loaded on your computer you will need 
to install Microsoft's Excel Viewer in order to display the reports in Excel format. You can download the Excel Viewer from: 
<a 
href="http://www.microsoft.com/downloads/en/details.aspx?FamilyId=1CD6ACF9-CE06-4E1C-8DCF-F33F669DBC3A&displaylang=en">http://www.microsoft.com/excel</a></span></div>

<div id="version">
<table width="320" border="0" align="left" id="Versions">
<CAPTION align="left"><EM><h2>Monthly Citation Report</h2></EM></CAPTION>
	<tr>
		<td width="214" align="left"><strong>Document Type:</strong></td>
	</tr>
	<tr>
		<td align="right"><a href="monthly_report.xls">Microsoft Excel Version</a></td>
	</tr>
	<tr>
		<td align="right"><a href="monthly_report.pdf">Adobe Acrobat Version</a></td>
	</tr>
</table></div>

<div id="weapons">
<table width="320" border="0" align="left">
<CAPTION align="left"><EM><h2>Weapon Certifications</h2></EM></CAPTION>
	<tr>
		<td align="right"><a href="./xls/Mounted Patrol Qualifications.xls">Microsoft Excel document</a></td>
	</tr>
</table>
</div>

<div id="details">
<table width="320" border="0" align:left">
<CAPTION align="left"><EM><h2>Detail Reports</h2></EM></CAPTION>
	<tr>
		<td align="right"><a href="detail_summary_form.php">Summary of Details Worked</a></td>
	</tr>
</table>
</div>
</div>

<?
$level = $session->userlevel;
if($level == '3' || $level == '5' || $level == '7' || $level == '9')
{
?>
	<div id="financials">
	<table width="320" border="0" align:left">
	<CAPTION align="left"><EM><h2>Financial Reports</h2></EM></CAPTION>
	<tr>
		<td align="right"><a href="money_owed_deputies.php">Amounts Owed to Deputies - Detailed Listing</a></td>
	</tr>
	<tr>
		<td align="right"><a href="form_1099_form.php">IRS Form 1099 Summary</a></td>
	</tr>

<?
}
?>
</table>
</div>
</body>
</html>

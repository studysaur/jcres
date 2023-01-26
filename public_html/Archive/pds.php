<?
/* 
 * Personal Detail Sheet - this web page will allow
 * a member to look at the details and other items 
 * that add money to their account. It also will show
 * all the deductions from their accounts as well as 
 * the total amount of money available. I intend on 
 * limiting the displayed data to the current and last years.
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
.style1 {
	font-family: "Verdana", "sans-serif";
	font-size: 24.0pt;
}
##excel_link {
	width: 200px;
}
	
-->
</style>
<title>Jackson County Mounted Patrol - Personal Detail Sheet</title></head>
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
<?      print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
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
		<li><a href="personal_destial_sheet.php">Personal Detail Sheet</a></li>
		<li><a href="citation_report.php">Monthly Citation Report</a></li>
<?	print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	<ul>
<?
    }
?>
</div>
<div class=Section1>

<?
global $database;
/* Query the credit database for all records for the logged in user */

$user = $session->name;
$old_credit = "0.00";
$old_expenses = "0.00";
$current_credit = "0.00";
$current_expenses = "0.00";
$today = date("d M Y");

echo "<h1>Personal Detail Account for: $user</h1>";
echo "<h1>as of: $today</h1>";

$q = "SELECT * FROM ".TBL_PLUS." WHERE name = '".$user."' ORDER BY date";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Credit table failed";
}
?>
<table width=1100 border=1 align="center" cellpadding=2 cellspacing=1>

<CAPTION><EM><h2>Credits Applied to Your Account</h2></EM></CAPTION>
<tr><th><b>Date</b></th><th><b>Location</b></th><th><b>Type of 
Function</b></th><th><b>Hrs</b></th><th><b>$ 
Earned</b></th><th><b>Remarks</b></th></tr>

<?

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$date= $row['date'];
	$location = $row['location'];
		if(!$location) {
			$location=chr(173);}
	$type = $row['type'];
		if(!$type) {
			$type=chr(173);}
	$hours_worked = $row['hours_worked'];
		if (!$hours_worked){
			$hours_worked=chr(173);}	
	$money_made = $row['money_made'];
	$remarks = $row['remarks'];
		if(!$remarks) {
			$remarks=chr(173);
		}

/* Explode the time in order to determine iwhether or not to display the record */
$todays_date = date("Y-m-d");
$full_date = explode("-", $date);
$todays_full_date = explode("-", $todays_date);

/* Test to see if the record was created in the last two years */
if ($full_date[0]  <  ($todays_full_date[0] - 1))  {
		$old_credit = $old_credit + $money_made;
		}
	else
		{
		$current_credit = $current_credit + $money_made;
		
		print("<tr><td width=110px><span style='font:100% 
Verdana, Arial, 
Helvetica, sans-serif;'>$date</span></td><td width=300px><span 
style='font:100% 
Verdana, Arial, Helvetica, 
sans-serif;'>$location</span></td><td width=300px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$type</span></td><td width=50px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$hours_worked</span></td><td width=75px 
text align=right><span 
style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
$money_made</span></td><td><span 
style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
$remarks</span></td></tr>\r");
		}
}
mysql_free_result($result);
?>
</table>

<?
/**
 * Now we begin to create the expenditures table
 */

$q = "SELECT * FROM ".TBL_MINUS." WHERE name = '".$user."' ORDER BY date";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Credit table failed";
}
?>
<table width=1100 border=1 align="center" cellpadding=2 cellspacing=1>
<p>&nbsp;</p>
<CAPTION><EM><h2>Expenditures Applied to Your Account</h2></EM></CAPTION>
<tr><th><b>Date</b></th><th><b>Description</b></th><th><b>Amount</b></th></tr>

<?

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$date= $row['date'];
	$description = $row['description'];
		if(!$description) {
			$description=chr(173);}
	$amount = $row['amount'];
		if(!$amount) {
			$amount=chr(173);}

/* Explode the time in order to determine iwhether or not to display the record */
$todays_date = date("Y-m-d");
$full_date = explode("-", $date);
$todays_full_date = explode("-", $todays_date);

/* Test to see if the record was created in the last two years */
if ($full_date[0]  <  ($todays_full_date[0] - 1))  {
		$old_expenses = $old_expenses + $amount;
		}
	else
		{
		$current_expenses = $current_expenses + $amount;
		
		print("<tr><td width=110px><span style='font:100% 
Verdana, Arial, 
Helvetica, sans-serif;'>$date</span></td><td><span 
style='font:100% 
Verdana, Arial, Helvetica, 
sans-serif;'>$description</span></td><td width=100px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$amount</span></td></tr>\r");
		}
}
mysql_free_result($result);
?>
</table>
<?
$current_balance = (($old_credit + $current_credit) - ($old_expenses + 
$current_expenses));
$previous_balance = ($old_credit - $old_expenses);

echo "<h3>Your account balance as of 2007-01-01 was 
$$previous_balance.</h3>";
echo "<h3>You made $$current_credit in the items listed above and your 
account was reduced by $$current_expenses</h3>";
echo "<h3>Your current balance is $$current_balance.</h3>";
?>
</div>
</body>
</html>

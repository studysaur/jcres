<?php 
 /*al Detail Sheet - this web page will allow
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

-->
</style>
<title>Auxiliary - Personal Detail Sheet</title></head>
<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<div id="horzlist">
<?php
   if($session->isAdmin()) {
?>
	<ul>
		<li><a href="/">Home</a> </li>
		<li><a href="aux_roster.php">Current Roster </a></li>
		<li><a href="unit_details.php">Unit Details </a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail Sheet </a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
		<li><a href="./admin/admin.php">Admin Center</a></li>
<?php      print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	</ul>
<?php
    }
    else
    {
?>
        <ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="aux_roster.php">Current Roster</a></li>
		<li><a href="unit_details.php">Unit Details</a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail 
Sheet</a></li>
		<li><a href="citation_report.php">Various Reports</a></li>
<?php	print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	<ul>
<?php
    }
?>

</div>

<?php
global $database;
/* Query the credit database for all records for the logged in user */
$status = $session->status;
$admin = $status & 0x8000; 
if($admin)	{
$q = "SELECT DISTINCT user.f_name, user.l_name, user.username, user.uid FROM user INNER JOIN credits  ON credits.uid = user.uid WHERE credits.date > '2020-12-7' ORDER BY user.l_name"; 
// $q = "SELECT l_name, f_name, username FROM ".TBL_USERS." ORDER BY l_name";
	$result = $database->query($q);
	$num_rows = mysql_num_rows($result);

	if(!$result || ($num_rows < 0))	{
		echo "<h2>Query to select all users from users table 
failed"; }

	$option = "";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
		$name = $row['l_name'] . ', '. $row['f_name'];
		$username = $row['username'];
		$option = $option."<option value=\"$username\">$name</option>";
	}
	$option = $option."</select>";
	?>
	<form action="" method="POST">
	<table align="center" border="0" cellpadding="3" cellspacing="0">
	<tr><td><h2>Select User to display:</h2></td><td><select name="username"><?php echo 
"$option"?></td></tr>
	<tr><td colspan="2" align="right"><input type="submit" value="Submit">
					   <input type="hidden" name="getDeputy" value="1"></td></tr>
	</table>
	<?php
	if (isset($_POST['username'])) {
		$user = $_POST['username'];
		$q="SELECT l_name, f_name, uid FROM ".TBL_USERS." WHERE username = '$user'";
		$result = $database->query($q);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$name = $row['l_name'] . ', ' . $row['f_name'];
		$uid = $row['uid'];
		} else {
		$user = $session->username;
		$uid = $session->usid;
		}
		
	//	echo "<h1 font_color='red'>This page is not working correctly<?h1><br>";
	echo "<h2>This reflects credits earned in 2020, but paid in 2021</h1><br>";
	if(isset($_POST['getDeputy']))	{
		echo "<A href=\"postExpense.php?user=$user&name=$name&uid=$uid\"><img src=\"./images/postExpense.jpg\"></a>";
		}
	}
else	{
	$user = $session->username;
	$uid = $session->usid;
	}

$old_credit = "0.00";
$old_expenses = "0.00";
$current_credit = "0.00";
$current_expenses = "0.00";
$current_year_credit = "0.00";
$today = date("d M Y");
/*
echo "<h2>Personal Detail Account for: $name</h2>";
echo "<h2>Forms generated: $today</h2>";
*/
$q = "SELECT * FROM credits WHERE uid = '".$uid."' ORDER BY date";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);
// if (!$result || ($num_rows < 0))  {
if (!$result) {
	echo "Query to show fields from Credit table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$date= $row['date'];
	$datePosted = $row['date_posted'];
	$detail_num = $row['detail_num'];
	$location = $row['location'];
		if(!$location) {
			$location=' ';}
	$type = $row['type'];
		if(!$type) {
			$type=' ';}
	$hours_worked = $row['hours_worked'];
		if (!$hours_worked){
			$hours_worked= 0;}	
	$money_made = $row['money_made'];
	$remarks = $row['remarks'];
		if(!$remarks) {
			$remarks=' ';
		}

/* Explode the time in order to determine whether or not to display the record */
$todays_date = date("Y-m-d");
$full_date = explode("-", $date);
$todays_full_date = explode("-", $todays_date);

/* Test to see if the record was created in the last two years */
if ($datePosted < '2019-12-02' )  {
		}
	else if($datePosted < '2020-12-02') {
	    $old_credit = $old_credit + $money_made;
	    } else  {
		$current_credit = $current_credit + $money_made;
               $current_year_credit = $current_year_credit + $money_made;
                $credits[] = "<tr><td width=110px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$date</span></td><td width=80px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$detail_num</span></td><td width=300px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$location</span></td><td width=300px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$type</span></td><td width=50px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$hours_worked</span></td><td width=75px text align=right><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'> $money_made</span></td><td><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
                $remarks</span></td></tr>\r";
        }
}
mysql_free_result($result);

/**
 * Now we begin to create the expenditures table
 */

$q = "SELECT * FROM expenses WHERE uid = '".$uid."' ORDER BY date";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Credit table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$date= $row['date'];
	$checkNum = $row['checkNum'];
	$description = $row['description'];
		if(!$description) {
			$description= ' ';}
	$amount = $row['amount'];
		if(!$amount) {
			$amount=0;}
/* Explode the time in order to determine iwhether or not to display the record */
/* Test to see if the record was created in the last two years */
if ($date  <  '2019-12-03')  {
	} elseif ($date < '2020-12-08') {
    $old_expenses = $old_expenses + $amount;
	} else {
	$current_expenses = $current_expenses + $amount;
	// $current_year_credit = $current_year_credit + $amount;
	$expenditures[] = "<tr>
	<td width=110px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$date</span></td>
	<td width=90px><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$checkNum</span></td>
	<td><spam style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$description</span></td>
	<td width=100px align=right><span style='font:100% Verdana, Arial, Helvetica, sans-serif;'>$amount</span></td></tr>\r";
		}
}
mysql_free_result($result);
$start_year = date("Y");
$start_date = "2020-12-02";

$current_balance = (($old_credit + $current_credit) - ($old_expenses + $current_expenses));
$previous_balance = ($old_credit - $old_expenses);

$previous_balance = money_format('%i', $previous_balance);
$current_credit = money_format('%i', $current_credit);
$current_expenses = money_format('%i', $current_expenses); 
$current_balance = money_format('%i', $current_balance);
$current_year_credit = money_format('%i', $current_year_credit);

?>
&nbsp;
<table  width="1100" align="center"  cellpadding="1" cellspacing="2">
<tr>
	<td style="font-size:24px">Personal Detail Account for: <?php echo "<b>$name</b>"; ?></td>
	<td style="font-size:24px" align="right">Balance as of <?php echo "$start_date"; ?> : </td>
	<td style="font-size:24px" align="right"><b>$<?php echo "$previous_balance</b>"; ?></td>
<tr>
	<td style="font-size:24px">Forms generated: <?php echo "<b>$today</b>"; ?></td>
	<td style="font-size:24px" align="right">Total Credits since <?php echo "$start_date"; ?> : </td>
	<td style="font-size:24px" align="right"><b>$<?php echo "$current_credit</b>"; ?></td>
</tr>
<tr>
	<td colspan="2" style="font-size:24px" align="right">Total Expenses since <?php echo "$start_date"; ?> : </td>
	<td style="font-size:24px" align="right"><b>$<?php echo "$current_expenses</b>"; ?></td>
</tr>
<tr>
	<td colspan="2" style="font-size:24px" align="right">Current Balance : </td>
	<td style="font-size:24px" align="right"><b>$<?php echo "$current_balance</b>"; ?></td>
</tr>
<tr>
	<td colspan="2" style="font-size:20px" align="right">Credits Earned This Year : </td>
	<td style="font-size:20px" align="right"><b>$<?php echo "$current_year_credit</b>"; ?></td>
</tr>

</table>
&nbsp;
<table width=1100 border=1 align="center" cellpadding=2 cellspacing=1>

<CAPTION><EM><h2>Credits Applied to Your Account</h2></EM></CAPTION>
<tr bgcolor="gray"><th><b>Date</b></th><th><b>Detail # <b></th><th><b>Location</b></th><th><b>Type of Function</b></th><th><b>Hrs</b></th><th><b>$ 
Earned</b></th><th><b>Remarks</b></th>
</tr>
<?php 
if($credits)	{
	foreach ($credits as $value)	{
		print($value);
		}
	}
unset ($value);
?>
</table>

<table width=1100 border=1 align="center" cellpadding=2 cellspacing=1>
<p>&nbsp;</p>
<CAPTION><EM><h2>Expenditures Applied to Your Account</h2></EM></CAPTION>
<tr bgcolor="gray"><th><b>Date</b></th><th><b>Check </b></th><th><b>Description</b></th><th><b>Amount</b></th></tr>
<?php
if($expenditures)	{
	foreach ($expenditures as $value)	{
		print($value);
		}
	}
unset ($value);	
?>

</table>
</body>
</html>
</body>
</html>

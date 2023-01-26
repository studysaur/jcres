<?
/* 
 * money_owed_deputies.php- this web page will allow
 * members to see the total amount of money ever 
 * made by a deputy as well as the total expenditures 
 * as well as the amount of money currently available 
 * in their account. This will allow an accurate  
 * listing of the total money owed to deputies.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
<title>Detailed Report of Monies Owed Deputies</title></head>
<style>
<!--
#warning {
	margin: 50px;
	width: 70%
}
--!>
</style>

<?
global $database;
/* Report Header */
?>
<a href="./citation_report.php"><img src="./images/return.jpg"></a>
<?


/* Set some variables */
$today = date("d M Y");
$total_credits == '0';
$total_deductions == '0';

/* Query the user database for all deputies */
$q = "SELECT name, username FROM ".TBL_USERS." ORDER BY name";

$result = $database->query($q);
$num_rows = mysql_numrows($result);
if(!result || ($num_rows < 0))	{
	echo "<h2>Query to select all users from users table failed"; }
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
	$name = $row['name'];
	$username = $row['username'];

/* Query the credits database for each user except 'visitor' */
	if($username!= 'visitor')	{
		$q = "SELECT SUM(money_made) FROM ".TBL_PLUS." WHERE username = '".$username."'";
		$credits = $database->query($q);

	/* Check for Errors in Reading Table */
		$credit_rows = mysql_numrows($credits);
		if (!$credits || ($credit_rows < 0))  {
			echo "Query of Credit table failed";
		}

		while ($plus = mysql_fetch_array($credits, MYSQL_ASSOC))
		{
			$current_credit = $plus['SUM(money_made)'];
			$total_credits = $total_credits + $current_credit;
		}	
		
		/**
		 * Now we begin to create the expenditures table
		 */

		$q = "SELECT SUM(amount) FROM ".TBL_MINUS." WHERE username = '".$username."'";
		$expenditures = $database->query($q);

		/* Check for Errors in Reading Table */
		$expenditures_rows = mysql_numrows($expenditures);
		if (!$expenditures || ($expenditures_rows < 0))  {
			echo "Query of Expenditure table failed";
		}

		while ($minus = mysql_fetch_array($expenditures, MYSQL_ASSOC))
		{
		$current_expenses = $minus['SUM(amount)'];
		$total_deductions = $total_deductions + $current_expenses;

		}		
		$current_balance = $current_credit - $current_expenses;
		$total_owed = $total_credits - $total_deductions;

/* Format the numbers as Currency */
		$current_expenses = number_format($current_expenses,2);
		$current_credit = number_format($current_credit,2);
		$current_balance = number_format($current_balance,2);
		$total_owed = number_format($total_owed,2);

		if(!$current_credit)	{
			if(!$current_expenses)	{
				$deputy[] = "<tr><td>$name</td><td align=\"right\">0.00</td><td 
align=\"right\">0.00</td><td align=\"right\">$current_balance</td><tr>\r";
			} else {
				$deputy[] = "<tr><td>$name</td><td 
align=\"right\">0.00</td><td align=\"right\">$current_expenses</td><td align=\"right\">$current_balance</td><tr>\r";
			}
		} else {
			if(!$current_expenses)	{
				$deputy[] = "<tr><td>$name</td><td 
align=\"right\">$current_credit</td><td align=\"right\">0.00</td><td align=\"right\">$current_balance</td><tr>\r";
			} else {
				$deputy[] = "<tr><td>$name</td><td align=\"right\"
>$current_credit</td><td align=\"right\">$current_expenses</td><td align=\"right\">$current_balance</td><tr>\r";
			}
		}
	}
}

?>
<table width=600 border=1 align="center" cellpadding=2 cellspacing=1>

<CAPTION><EM><h2>Detailed Listing of Money Owed to Deputies <br/>as of <?echo 
"$today";?></h2></EM></CAPTION>
<tr bgcolor="gray">
	<th><b>Deputy Name</b></th>
	<th><b>Total Credits</b></th>
	<th><b>Total Expenses</b></th>
	<th><b>Current Balance</b></th>
</tr>
<? 
if($deputy)	{
	foreach ($deputy as $value)	{
		print($value);
		}
	}
unset ($value);
?>
<tr>
	<td colspan="3" align="right"><b>Total Owed by Mounted Patrol to Deputies</b></td>
	<td align="right"><b><?echo "$total_owed";?></b></td>
</tr>
</table>
<div id="warning"><span style="text-align:left">This report shows the total money made and used by each Deputy since Novemeber 
2007 
when this process began as well as the total amount of money owed to the Deputies by the Mounted Patrol. The Current Balance column shows how 
much is 
currently in 
their account. 
This amount does not include any details that have been worked but have not been posted.</span></div>
</body>
</html>

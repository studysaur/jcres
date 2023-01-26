<?
/* Form 1099 Requirement 
 * Reads the user table, and uses this information to query the 
 * Credits database to determine how much money each member
 * made in a given year.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
<title>Jackson County Mounted Patrol - Detail Summary</title></head>
<body>

<?
global $database;
?>
<a href="./citation_report.php"><img src="./images/return.jpg"></a>
<?
$timeframe = $_POST['timeframe'];
if ($timeframe=="last")	{
		$year=(date(Y)-1);	}
	else if ($timeframe == "this")	{
		$year=(date(Y));	}
	else { 
		echo "<h2></br>You failed to make a selection on the 
previous screen.</h2></br>";
		echo "<h2>Click <a href=\"form_1099_form.php\">here</a> to try again.</h2></br>";
		exit; 
	}
?>
<table width=400 border=1 align="center" cellpadding=2 cellspacing=2>
<caption><h2></br>Money Earned for <?echo 
"$year"?>*</h2></n><h3>*Details worked but not posted have not been 
counted.</h3></br></caption>
<tr bgcolor="gray">
	<th><b>Officer Name</b></th>
	<th><b>Total Money Credited</b></th>
</tr>
<?

/* Build the array of all members */
$q = "SELECT username, name FROM ".TBL_USERS." ORDER BY name";
$result = $database->query($q);

/* Check for Errors in Creating the table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_row < 0))	{
	echo "Query of the USERS table failed.";	}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$username = $row['username'];
	$name = $row['name'];
	$total_money_made = "0";

	if($username!='visitor')	{
		$q = "SELECT * FROM ".TBL_PLUS." WHERE username = '$username' AND date LIKE '$year"."%'";
		$details = $database->query($q);
	while ($row2 = mysql_fetch_array($details, MYSQL_ASSOC))	
{
		$money = $row2['money_made'];
		$total_money_made = $total_money_made + $money;
	}
$total_money_made = money_format('%i', $total_money_made);
print ("<tr><td align=\"left\">$name</td><td 
align=\"center\">$total_money_made</td></tr>");

}
}


?>
<table>
</body>
</html>

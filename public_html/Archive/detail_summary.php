<?
/* Detail Summary 
 * Reads the user table, and uses this information to query the 
 * Credits database to determine how many details each individual
 * worked in a given time period.
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
		echo "<h2>Click <a href=\"detail_summary_form.php\">here</a> to try again.</h2></br>";
		exit; 
	}
?>
<table width=550 border=1 align="center" cellpadding=2 cellspacing=2>
<caption><h2></br>Detail Summary for <?echo 
"$year"?>*</h2></n><h3>*Details worked but not posted have not been 
counted.</h3></br></caption>
<tr bgcolor="gray">
	<th><b>Officer Name</b</th>
	<th><b>Total Details<br/>Worked</b></th>
	<th><b>Unpaid Details<br/>Worked</b></th>
	<th><b>Total Hours<br/>Credited</b></th>
</tr>
<?

/* Build the array of all members */
$q = "SELECT username, name FROM ".TBL_USERS." ORDER BY unit_num";
$result = $database->query($q);

/* Check for Errors in Creating the table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_row < 0))	{
	echo "Query of the USERS table failed.";	}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$username = $row['username'];
	$name = $row['name'];
	$totalhours = "0";

	if($username!='visitor')	{
		$q = "SELECT * FROM ".TBL_PLUS." WHERE username = '$username' AND date LIKE '$year"."%'";
		$details = $database->query($q);
	while ($row2 = mysql_fetch_array($details, MYSQL_ASSOC))	
{
		$hours = $row2['hours_worked'];
		$totalhours = $totalhours + $hours;
	}
	$detail_count = mysql_numrows($details);
	$q = "SELECT * FROM ".TBL_PLUS." WHERE username = '$username' AND money_made < '1' AND date LIKE 
'$year"."%'";
	$details = $database->query($q);
	$unpaid = mysql_numrows($details);
	if (!$unpaid)	{
		$unpaid = "0";
	}
print ("<tr><td align=\"left\">$name</td><td 
align=\"center\">$detail_count</td><td align=\"center\">$unpaid</td><td 
align=\"center\">$totalhours</td></tr>");

}
}


?>
<table>
</body>
</html>

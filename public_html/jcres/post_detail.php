<?php
/**
 * postDetail - this module receives input from the detail_form function from volunteer.php. 
 * It passes a row for each officer which contains the officer's name as $name, the hours 
 * worked as $hours, the amount of money made as $dollars, and a remarks section as 
 * $remarks. The detail number is passed in the hidden field as $subPostOfficers.
 */
ob_start();
 include("include/session.php");
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Post Detail</title>
</head>

<body>
<?php

global $database, $session;

date_default_timezone_set("America/Chicago");
$date = date("Y-m-d");
$detailNum = $_POST['subPostOfficers'];
$q = "SELECT * FROM ".TBL_DETAILS." WHERE detailNum = '$detailNum' ";

$result1 = $database->query($q);

    $row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
    $ddate = $row1['date'];
    $detailType = mysql_real_escape_string($row1['detailType']);
	$detailLocation = mysql_real_escape_string($row1['detailLocation']);
	$numOfficers = $row1['numOfficers'];
	$detailNum = $row1['detailNum'];

	for($i = '1'; $i <= $numOfficers; $i++)	{
	
		$name = "officer$i";
		$startTime = "startTime$i";
		$endTime = "endTime$i";
		$hours = $endTime - $startTime;
		$dollars = "dollars$i";
		$remarks = "remarks$i";
		$checkNum = "checkNum$i";
		
		$officer = mysql_real_escape_string($_POST[$name]);
		if($officer=="")  {
			break1;
		}else{
			
			$time = mysql_real_escape_string($_POST[$hours]);
			$amount = mysql_real_escape_string($_POST[$dollars]);
			$startTime = mysql_real_escape_string($_POST[$startTime]);
			$endTime = mysql_real_escape_string($_POST[$endTime]);
			$statement = mysql_real_escape_string($_POST[$remarks]);
			if(!$statement)	{
				$statement = chr(173);
			}
			$checkNum = mysql_real_escape_string($_POST[$checkNum]);
		if (isset($result['username'])) {
			unset($result['username']);
		}
		$nm = explode(',', $officer);
		$usname = trim($nm[1]) . '_' . trim($nm[0]);
		$q2= "SELECT * FROM ".TBL_USERS." WHERE username = '$usname' ";
		$result2= $database->query($q2);
		
		if(!$result2) {
			sleep(10);
		}else{
		$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
		$username = $row2['username'];
		$uid = $row2['uid'];
				  
		
				$q = "INSERT INTO ".TBL_PLUS." VALUES ('NULL', '$detailNum', '$date', '$username', '$uid', '$ddate', '$detailLocation', '$detailType', '$startTime', '$endTime', '$time', '$amount', '$statement', '$checkNum')";
				$result = $database->query($q);
				if(!$result) {
					echo "<h2>The problem query string is: $q</h2><br/>";
					echo "<p>The user string q2 is: $q2</p><br/>";
					echo "<h2>There was a problem inserting the detail record into the Credits</h2><br/>";
					echo "<h2>database for $officer. If this was the first officer posted, try again.</h2><br/>";
					echo "<h2>If not, contact the database administrator to correct the problem.</h2><br/><br/>";
					echo "<h3>Click <a href=\"unit_details.php\">here</a> to go back to the Unit Details Page.</h3>";
					ob_end_flush();
					exit;
				} else {
				    mysql_free_result($result);
				}  
			}
		}
	}
//	$q = "UPDATE ".TBL_DETAILS." SET sheetPosted='1' WHERE detailNum = '$detailNum'";
	$q = "UPDATE ".TBL_DETAILS." SET sheetPosted='$date' WHERE detailNum = '$detailNum'";

	$result = $database->query($q);
	if(!$result)	{
		echo "<h2>There was a problem closing the detail.</h2><br/>";
		echo "<h2>Could not set sheet_posted to 'true'.</h2><br/><br/>";
		echo "<h3>Click <a href=\"unit_details.php\">here</a> to go back to the Unit Details Page.</h3>";
		ob_end_flush();
	}
	else	{
		ob_end_clean();
		header("Location: unit_details.php");	
	}
?>
</body>
</html>

<?php 
/**
 * postDetail - this module receives input from the detail_form function from volunteer.php. 
 * It passes a row for each officer which contains the officer's name as $name, the hours 
 * worked as $hours, the amount of money made as $dollars, and a remarks section as 
 * $remarks. The detail number is passed in the hidden field as $subPostOfficers.
 */
require 'includes/utilities.inc.php';
// ob_start();
 // require "include/session.php";
 // require "include/database.php";

$title = 'Post Detail';


//global $database, $session;
$detail_num = $_POST['subPostOfficers'];
$q = "SELECT * FROM details WHERE detailNum = '$detail_num'";
$date = new DateTime('now');
$date->setTimezone(new DateTimeZone('America/Chicago'));
$str_now = $date->format('Y-m-d'); 
$result1 = $pdo->query($q);

while ($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))	{
	$date = $row1['date'];
	$detail_type = mysql_real_escape_string($row1['detailType']);
	$detail_location = mysql_real_escape_string($row1['detailLocation']);
	$num_officers = $row1['numOfficers'];
	}
	for($i = '1'; $i <= $num_officers; $i++)	{
	
		$name = "officer$i";
		$startTime  = "startTime$i";
		$endTime = "endTime$i";
		//if ($endTime < $startTime) {
		 //   $endTime ->add($diff1Day);
		//}
		$hours = "hours$i";
		$dollars = "dollars$i";
		$remarks = "remarks$i";
		
		$officer = mysql_real_escape_string($_POST[$name]);
		if($officer=="")  {
			break;
		}else{
			$name = explode(", ", $officer);
			$lname = $name[0];
			$fname = $name[1];
			$startTime = mysql_real_escape_string($_POST[$startTime]);
			$endTime = mysql_real_escape_string($_POST[$endTime]);
			$time = mysql_real_escape_string($_POST[$hours]);
			$amount = mysql_real_escape_string($_POST[$dollars]);
			$statement = mysql_real_escape_string($_POST[$remarks]);
			if(!$statement)	{
				$statement = chr(173);
			}
		if (isset($result['username']))	{ // clear the username
			unset($result['username']);
		}
		$q= "SELECT username, uid FROM ".TBL_USERS." WHERE l_name='$lname' and  f_name = '$fname'";
		$result = $database->query($q);
		
		if(!$result) {
			break1;
		}else{
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{ 
				$username = $row['username'];
				$uid = $row['uid'];
				}  

				$q = "INSERT INTO " . TBL_PLUS .  " VALUES (NULL, '$detail_num', '$str_now', '$username', '$uid', '$date', '$detail_location', '$detail_type', $startTime, $endTime, $time, $amount, '$statement')" ;
				$result = $database->query($q);
				if(!$result)	{
					echo "<h2>The problem query string is: $q</h2><br/>";
					echo "<h2>There was a problem inserting the detail record into the Credits</h2><br/>";
					echo "<h2>database for $officer. If this was the first officer posted, try again.</h2><br/>";
					echo "<h2>If not, contact the database administrator to correct the problem.</h2><br/><br/>";
					echo "<h3>Click <a href=\"unit_details.php\">here</a> to go back to the Unit Details Page.</h3>";
					ob_end_flush();
					exit;
				}  
			}
		}
	}
//	$q = "UPDATE ".TBL_DETAILS." SET sheetPosted='1' WHERE detailNum = '$detail_num'";
	$q = "UPDATE ".TBL_DETAILS." SET sheetPosted=$str_now WHERE detailNum = '$detail_num'";
	

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

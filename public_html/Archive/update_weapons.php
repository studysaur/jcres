<?
/**
 * update_weapons.php
 * This script accepts input from the weapons_qual.php
 * form to see which weapons need to have their 
 * qualification date updated for a particular user. 
 * The form passes the user ID as a hidden value.
 *
 */
include ("./include/session.php");

global $database;

/* Determine who the user is */
$user=($_POST['user']);

/* Capture the night qualification flag */
$night=($_POST['night']);

if($night!="1")	{
	$night="0";	}

/* Determine what the new date should be */
$change_date=($_POST['calendar1']);

/* Select All Weapons Assigned to the User */
$q = "SELECT * FROM ".TBL_GUNS." WHERE username = '".$user."'";
$result = $database->query($q);

/* Check for Error Reading Table */
$num_rows = mysql_numrows($result);
if(!$result || ($num_rows < 0))	{
	echo "Query to select records from weapons table for $user failed.";
	exit;
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$SerialNumber = $row['serial_num'];
	$update_date = ($_POST["$SerialNumber"]);
	if($update_date == 1)	{	
		if($night == 1)	{
			$weapon_type = $row['type'];
			if($weapon_type == "Duty")	{
				$r = "UPDATE ".TBL_GUNS." SET qual_date = '".$change_date."', night_qual_date = '".$change_date."' WHERE username = '".$user."' AND serial_num = '".$SerialNumber."'";
			} else {
				$r = "UPDATE ".TBL_GUNS." SET qual_date = '".$change_date."' WHERE username = '".$user."' AND serial_num = '".$SerialNumber."'";
			}
		} else {
			$r = "UPDATE ".TBL_GUNS." SET qual_date = '".$change_date."' WHERE username = '".$user."' AND serial_num = '".$SerialNumber."'";
		}
	$done = $database->query($r);
	}
}
$update_deadly_force=$_POST['deadly_force'];
if($update_deadly_force=="1")	{
	$instructor = $_POST['instructor'];
	$q = "UPDATE annual_training SET date = '".$change_date."', instructor = '".$instructor."' WHERE userid = '".$user."' AND type = 'Deadly Force'";
	$done = $database->query($q);
}
header("Location: weapons_qual.php");
?>
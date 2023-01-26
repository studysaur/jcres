<?php
/**
 * Volunteer.jpg is usedto see who volunteered for a detail 
 * and assign them to that detail
 */

include("include/session.php");
if(!$session->logged_in  || $session->l_name == "") {
	
	header("Location:main.php");
	}


$selection = $_REQUEST['type'];
$detail_num = $_REQUEST['detail'];

if($selection == 'enter')	{
	detail_form($detail_num); 
}
else if($selection == 'edit')	{
	edit_detail($detail_num); 
}
else if($selection == 'delete') {
	delete_detail($detail_num);
 }
else if($selection == 'volunteer') {
	$officer_num = "officer_".($_REQUEST['field']+1);
	volunteer_detail($detail_num, $officer_num);
}

function detail_form($detail_num)	{
	global $database, $session;

/* Retrieve the record identified by $detail_num */
$q = "SELECT * FROM ".TBL_DETAILS." WHERE detailNum = '$detail_num'";

$result = $database->query($q);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
    $startTime =$row['startTime'];
    $endTime = $row['endTime'];
	$officer[0] = $row['officer_1'];
	$officer[1] = $row['officer_2'];
	$officer[2] = $row['officer_3'];
	$officer[3] = $row['officer_4'];
	$officer[4] = $row['officer_5'];
	$officer[5] = $row['officer_6'];
	$officer[6] = $row['officer_7'];
	$officer[7] = $row['officer_8'];
    $officer[8] = $row['officer_9'];
    $officer[9] = $row['officer_10'];
?>
<!DOCTYPE html>	
<form  action="post_detail.php" method="POST">
<table border="1"  align="left" cellspacing="2" cellpadding="2">
<tr><th><h2>Officer</h2></th><th><h2>Start Time</h2></th><th><h2>End Time</h2></th><th><h2>Hours</h2></th><th><h2>Amount Made</h2></th><th width="250"><h2>Remarks</h2></th></tr>
<?php
$z = "1";
foreach ($officer as $value)	{
	if($value)	{
	print("<tr><td><input type=\"text\" name=\"officer$z\" value=\"$value\"></td><td><input type=\"text\" name=\"startTime$z\" value=\"$startTime\"></td><td><input type=\"text\" name=\"endTime$z\" value=\"$endTime\"></td><td><input type=\"text\" name=\"hours$z\"></td><td><input type=\"text\" name=\"dollars$z\"></td><td><input type=\"text\" name=\"remarks$z\"></td></tr>");
	$z++;
		}
	}
	print("<tr><td colspan=\"4\" align=\"right\"><input type=\"hidden\" name=\"subPostOfficers\" value=\"$detail_num\"><input type=\"Submit\" value=\"Post Detail\"></td></tr>");
?>
</table>
</form>
<?php
}

}

function edit_detail($detail_num)	{
	global $session, $database, $form;

echo "<br><a href=\"unit_details.php\"><img src=\"images/return.jpg\"></a>";

/* Retrive the record identified by $detail_num */
$q = "SELECT * FROM ".TBL_DETAILS." WHERE detailNum ='$detail_num'";
$result = $database->query($q);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

    $date = $row['date'];
	$detail_location = $row['detailLocation'];
	$detail_type = $row['detailType'];
	$start_time = $row['startTime'];
	$end_time = $row['endTime'];
	$contact = $row['contact'];
	$num_officers = $row['numOfficers'];
	$paid_detail = $row['paidDetail'];
	$officer1 = $row['officer_1'];
	$officer2 = $row['officer_2'];
	$officer3 = $row['officer_3'];
	$officer4 = $row['officer_4'];
	$officer5 = $row['officer_5'];
	$officer6 = $row['officer_6'];
	$officer7 = $row['officer_7'];
	$officer8 = $row['officer_8'];
    $officer9 = $row['officer_9'];
    $officer10 = $row['officer_10'];
//  $field=$row['$officer_num'];

/* Display all the fields for the detail */
?>

<h1>Edit Detail</h1>
<?php
$start_time = date ('H:i', strtotime($start_time));
$end_time = date ('H:i', strtotime($end_time));
//$start_time = substr($start_time,0,5);
//$end_time = substr($end_time,0,5);

$q = "SELECT uid, l_name, f_name, unit_num FROM ".TBL_USERS." WHERE status & 64 ORDER BY l_name"; // the where gets rid of officers marked as inactive
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);

if(!$result || ($num_rows < 0))	{
	echo "Query to select all users from users table failed";
}

/* Build the string to create the option values for the drop down */
$option = "";

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
	$name = $row['l_name'] . ', ' . $row['f_name'];
	$option = $option."<option value=\"$name\">$name</option>";
}

/* Close off the Select tag */
$option = $option."</select>";

if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr>
	<td>Date:</td>
	<td><input type="date" name="date" maxlength="12" value="<?php 
			if ($form->value("date") == "")		{
				echo "$date";	}
			else	{
				echo $form->value("date");  }?>"></td>
	<td><!-- <input type=button value="select date" onclick="displayDatePicker('date', this,'ymd', '-');"--></td >
</tr>
<tr>
	<td>Detail Type:</td>
	<td><input type="text" name="detail_type" maxlength="80" value="<?php 
			if ($form->value("detail_type") == ""){
				echo "$detail_type";	}
			else	{
				echo $form->value("detail_type");  }?>"></td>
	<td><?php echo $form->error("detail_type"); ?></td>
</tr>
<tr>
	<td>Detail Location:</td>
	<td><input type="text" name="detail_location" maxlength="50" value="<?php 
			if ($form->value("detail_location") == ""){
				echo "$detail_location";	}
			else	{
				echo $form->value("detail_location");  }?>"></td>
	<td><?php echo $form->error("detail_location");?></td>
</tr>
<tr>
	<td>Start Time:</td>
<?php
	echo "<td><select name=\"start_time\" >";
			if($start_time=="")	{
				echo "<option value=\"\" SELECTED> </option>";	}
			else	{
				echo "<option value=\"\"> </option>";	}
			if($start_time=="00:00")		{
				echo "<option value=\"00:00\" 
SELECTED>Midnight</option>";	}
			else	{
				echo "<option 
value=\"00:00\">Midnight</option>";		}
			if($start_time=="00:30")		{
				echo "<option value=\"00:30\" SELECTED>0:30 AM</option>";	}
			else	{
				echo "<option value=\"00:30\">0:30 AM</option>";		}
			if($start_time=="01:00")		{
				echo "<option value=\"01:00\" SELECTED>1:00 AM</option>";	}
			else	{
				echo "<option value=\"01:00\">1:00 AM</option>";		}
			if($start_time=="01:30")		{
				echo "<option value=\"01:30\" SELECTED>1:30 AM</option>";	}
			else	{
				echo "<option value=\"01:30\">1:30 AM</option>";		}
			if($start_time=="02:00")		{
				echo "<option value=\"02:00\" SELECTED>2:00 AM</option>";	}
			else	{
				echo "<option value=\"02:00\">2:00 AM</option>";		}
			if($start_time=="02:30")		{
				echo "<option value=\"02:30\" SELECTED>2:30 AM</option>";	}
			else	{
				echo "<option value=\"02:30\">2:30 AM</option>";		}
			if($start_time=="03:00")		{
				echo "<option value=\"03:00\" SELECTED>3:00 AM</option>";	}
			else	{
				echo "<option value=\"03:00\">3:00 AM</option>";		}
			if($start_time=="03:30")		{
				echo "<option value=\"03:30\" SELECTED>3:30 AM</option>";	}
			else	{
				echo "<option value=\"03:30\">3:30 AM</option>";		}
			if($start_time=="04:00")		{
				echo "<option value=\"04:00\" SELECTED>4:00 AM</option>";	}
			else	{
				echo "<option value=\"04:00\">4:00 AM</option>";		}
			if($start_time=="04:30")		{
				echo "<option value=\"04:30\" SELECTED>4:30 AM</option>";	}
			else	{
				echo "<option value=\"04:30\">4:30 AM</option>";		}
			if($start_time=="05:00")		{
				echo "<option value=\"05:00\" SELECTED>5:00 AM</option>";	}
			else	{
				echo "<option value=\"05:00\">5:00 AM</option>";		}
			if($start_time=="05:30")		{
				echo "<option value=\"05:30\" SELECTED>5:30 AM</option>";	}
			else	{
				echo "<option value=\"05:30\">5:30 AM</option>";		}
			if($start_time=="06:00")		{
				echo "<option value=\"06:00\" SELECTED>6:00 AM</option>";	}
			else	{
				echo "<option value=\"06:00\">6:00 AM</option>";		}
			if($start_time=="06:30")		{
				echo "<option value=\"06:30\" SELECTED>6:30 AM</option>";	}
			else	{
				echo "<option value=\"06:30\">6:30 AM</option>";		}
			if($start_time=="07:00")		{
				echo "<option value=\"07:00\" SELECTED>7:00 AM</option>";	}
			else	{
				echo "<option value=\"07:00\">7:00 AM</option>";	}
			if($start_time=="07:30")		{
				echo "<option value=\"07:30\" SELECTED>7:30 AM</option>";	}
			else	{
				echo "<option value=\"07:30\">7:30 AM</option>";	}
			if($start_time=="08:00")		{
				echo "<option value=\"08:00\" SELECTED>8:00 AM</option>";	}
			else	{
				echo "<option value=\"08:00\">8:00 AM</option>";	}
			if($start_time=="08:30")		{
				echo "<option value=\"08:30\" SELECTED>8:30 AM</option>";	}
			else	{
				echo "<option value=\"08:30\">8:30 AM</option>";		}
			if($start_time=="09:00")		{
				echo "<option value=\"09:00\" SELECTED>9:00 AM</option>";	}
			else	{
				echo "<option value=\"09:00\">9:00 AM</option>";	}
			if($start_time=="09:30")		{
				echo "<option value=\"09:30\" SELECTED>9:30 AM</option>";	}
			else	{
				echo "<option value=\"09:30\">9:30 AM</option>";	}
			if($start_time=="10:00")	{
				echo "<option value=\"10:00\" SELECTED>10:00 AM</option>";	}
			else	{
				echo "<option value=\"10:00\">10:00 AM</option>";	}
			if($start_time=="10:30")	{
				echo "<option value=\"10:30\" SELECTED>10:30 AM</option>";	}
			else	{
				echo "<option value=\"10:30\">10:30 AM</option>";	}
			if($start_time=="11:00")	{
				echo "<option value=\"11:00\" SELECTED>11:00 AM</option>";	}
			else	{
				echo "<option value=\"11:00\">11:00 AM</option>";	}
			if($start_time=="11:30")	{
				echo "<option value=\"11:30\" SELECTED>11:30 AM</option>";	}
			else	{
				echo "<option value=\"11:30\">11:30 AM</option>";	}
			if($start_time=="12:00")	{
				echo "<option value=\"12:00\" SELECTED>12:00 Noon</option>";	}
			else	{
				echo "<option value=\"12:00\">12:00 Noon</option>";	}
			if($start_time=="12:30")	{
				echo "<option value=\"12:30\" SELECTED>12:30 PM</option>";	}
			else	{
				echo "<option value=\"12:30\">12:30 AM</option>";	}
			if($start_time=="13:00")	{
				echo "<option value=\"13:00\" SELECTED>1:00 PM</option>";	}
			else	{
				echo "<option value=\"13:00\">1:00 PM</option>";	}
			if($start_time=="13:30")	{
				echo "<option value=\"13:30\" SELECTED>1:30 PM</option>";	}
			else	{
				echo "<option value=\"13:30\">1:30 PM</option>";	}
			if($start_time=="14:00")	{
				echo "<option value=\"14:00\" SELECTED>2:00 PM</option>";	}
			else	{
				echo "<option value=\"14:00\">2:00 PM</option>";	}
			if($start_time=="14:30")	{
				echo "<option value=\"14:30\" SELECTED>2:30 PM</option>";	}
			else	{
				echo "<option value=\"14:30\">2:30 PM</option>";	}
			if($start_time=="15:00")	{
				echo "<option value=\"15:00\" SELECTED>3:00 PM</option>";	}
			else	{
				echo "<option value=\"15:00\">3:00 PM</option>";	}
			if($start_time=="15:30")	{
				echo "<option value=\"15:30\" SELECTED>3:30 PM</option>";	}
			else	{
				echo "<option value=\"15:30\">3:30 PM</option>";	}
			if($start_time=="16:00")	{
				echo "<option value=\"16:00\" SELECTED>4:00 PM</option>";	}
			else	{
				echo "<option value=\"16:00\">4:00 PM</option>";	}
			if($start_time=="16:30")	{
				echo "<option value=\"16:30\" SELECTED>4:30 PM</option>";	}
			else	{
				echo "<option value=\"16:30\">4:30 PM</option>";	}
			if($start_time=="17:00")	{
				echo "<option value=\"17:00\" SELECTED>5:00 PM</option>";	}
			else	{
				echo "<option value=\"17:00\">5:00 PM</option>";	}
			if($start_time=="17:30")	{
				echo "<option value=\"17:30\" SELECTED>5:30 PM</option>";	}
			else	{
				echo "<option value=\"17:30\">5:30 PM</option>";	}
			if($start_time=="18:00")	{
				echo "<option value=\"18:00\" SELECTED>6:00 PM</option>";	}
			else	{
				echo "<option value=\"18:00\">6:00 PM</option>";	}
			if($start_time=="18:30")	{
				echo "<option value=\"18:30\" SELECTED>6:30 PM</option>";	}
			else	{
				echo "<option value=\"18:30\">6:30 PM</option>";	}
			if($start_time=="19:00")	{
				echo "<option value=\"19:00\" SELECTED>7:00 PM</option>";	}
			else	{
				echo "<option value=\"19:00\">7:00 PM</option>";	}
			if($start_time=="19:30")	{
				echo "<option value=\"19:30\" SELECTED>7:30 PM</option>";	}
			else	{
				echo "<option value=\"19:30\">7:30 PM</option>";	}
			if($start_time=="20:00")	{
				echo "<option value=\"20:00\" SELECTED>8:00 PM</option>";	}
			else	{
				echo "<option value=\"20:00\">8:00 PM</option>";	}
			if($start_time=="20:30")	{
				echo "<option value=\"20:30\" SELECTED>8:30 PM</option>";	}
			else	{
				echo "<option value=\"20:30\">8:30 PM</option>";	}
			if($start_time=="21:00")	{
				echo "<option value=\"21:00\" SELECTED>9:00 PM</option>";	}
			else	{
				echo "<option value=\"21:00\">9:00 PM</option>";	}
			if($start_time=="21:30")	{
				echo "<option value=\"21:30\" SELECTED>9:30 PM</option>";	}
			else	{
				echo "<option value=\"21:30\">9:30 PM</option>";	}
			if($start_time=="22:00")	{
				echo "<option value=\"22:00\" SELECTED>10:00 PM</option>";	}
			else	{
				echo "<option value=\"22:00\">10:00 PM</option>";	}
			if($start_time=="21:30")	{
				echo "<option value=\"22:30\" SELECTED>10:30 PM</option>";	}
			else	{
				echo "<option value=\"22:30\">10:30 PM</option>";	}
			if($start_time=="23:00")	{
				echo "<option value=\"23:00\" SELECTED>11:00 PM</option>";	}
			else	{
				echo "<option value=\"23:00\">11:00 PM</option>";	}
			if($start_time=="21:30")	{
				echo "<option value=\"23:30\" SELECTED>11:30 PM</option>";	}
			else	{
				echo "<option value=\"23:30\">11:30 PM</option>";	}


?>
</tr>
<tr>
	<td>End Time:</td>
<?php
	echo "<td><select name=\"end_time\" >";
			if($end_time=="")	{
				echo "<option value=\"\" SELECTED> </option>";	}
			else	{
				echo "<option value=\"\"> </option>";	}
			if($end_time=="24:00")		{
				echo "<option value=\"24:00\" SELECTED>Midnight</option>";	}
			else	{
				echo "<option value=\"24:00\">Midnight</option>";		}
			if($end_time=="00:30")		{
				echo "<option value=\"00:30\" SELECTED>0:30 AM</option>";	}
			else	{
				echo "<option value=\"00:30\">0:30 AM</option>";		}
			if($end_time=="01:00")		{
				echo "<option value=\"01:00\" SELECTED>1:00 AM</option>";	}
			else	{
				echo "<option value=\"01:00\">1:00 AM</option>";		}
			if($end_time=="01:30")		{
				echo "<option value=\"01:30\" SELECTED>1:30 AM</option>";	}
			else	{
				echo "<option value=\"01:30\">1:30 AM</option>";		}
			if($end_time=="02:00")		{
				echo "<option value=\"02:00\" SELECTED>2:00 AM</option>";	}
			else	{
				echo "<option value=\"02:00\">2:00 AM</option>";		}
			if($end_time=="02:30")		{
				echo "<option value=\"02:30\" SELECTED>2:30 AM</option>";	}
			else	{
				echo "<option value=\"02:30\">2:30 AM</option>";		}
			if($end_time=="03:00")		{
				echo "<option value=\"03:00\" SELECTED>3:00 AM</option>";	}
			else	{
				echo "<option value=\"03:00\">3:00 AM</option>";		}
			if($end_time=="03:30")		{
				echo "<option value=\"03:30\" SELECTED>3:30 AM</option>";	}
			else	{
				echo "<option value=\"03:30\">3:30 AM</option>";		}
			if($end_time=="04:00")		{
				echo "<option value=\"04:00\" SELECTED>4:00 AM</option>";	}
			else	{
				echo "<option value=\"04:00\">4:00 AM</option>";		}
			if($end_time=="04:30")		{
				echo "<option value=\"04:30\" SELECTED>4:30 AM</option>";	}
			else	{
				echo "<option value=\"04:30\">4:30 AM</option>";		}
			if($end_time=="05:00")		{
				echo "<option value=\"05:00\" SELECTED>5:00 AM</option>";	}
			else	{
				echo "<option value=\"05:00\">5:00 AM</option>";		}
			if($end_time=="05:30")		{
				echo "<option value=\"05:30\" SELECTED>5:30 AM</option>";	}
			else	{
				echo "<option value=\"05:30\">5:30 AM</option>";		}
			if($end_time=="06:00")		{
				echo "<option value=\"06:00\" SELECTED>6:00 AM</option>";	}
			else	{
				echo "<option value=\"06:00\">6:00 AM</option>";		}
			if($end_time=="06:30")		{
				echo "<option value=\"06:30\" SELECTED>6:30 AM</option>";	}
			else	{
				echo "<option value=\"06:30\">6:30 AM</option>";		}
			if($end_time=="07:00")		{
				echo "<option value=\"07:00\" SELECTED>7:00 AM</option>";	}
			else	{
				echo "<option value=\"07:00\">7:00 AM</option>";	}
			if($end_time=="07:30")		{
				echo "<option value=\"07:30\" SELECTED>7:30 AM</option>";	}
			else	{
				echo "<option value=\"07:30\">7:30 AM</option>";	}
			if($end_time=="08:00")		{
				echo "<option value=\"08:00\" SELECTED>8:00 AM</option>";	}
			else	{
				echo "<option value=\"08:00\">8:00 AM</option>";	}
			if($end_time=="08:30")		{
				echo "<option value=\"08:30\" SELECTED>8:30 AM</option>";	}
			else	{
				echo "<option value=\"08:30\">8:30 AM</option>";		}
			if($end_time=="09:00")		{
				echo "<option value=\"09:00\" SELECTED>9:00 AM</option>";	}
			else	{
				echo "<option value=\"09:00\">9:00 AM</option>";	}
			if($end_time=="09:30")		{
				echo "<option value=\"09:30\" SELECTED>9:30 AM</option>";	}
			else	{
				echo "<option value=\"09:30\">9:30 AM</option>";	}
			if($end_time=="10:00")	{
				echo "<option value=\"10:00\" SELECTED>10:00 AM</option>";	}
			else	{
				echo "<option value=\"10:00\">10:00 AM</option>";	}
			if($end_time=="10:30")	{
				echo "<option value=\"10:30\" SELECTED>10:30 AM</option>";	}
			else	{
				echo "<option value=\"10:30\">10:30 AM</option>";	}
			if($end_time=="11:00")	{
				echo "<option value=\"11:00\" SELECTED>11:00 AM</option>";	}
			else	{
				echo "<option value=\"11:00\">11:00 AM</option>";	}
			if($end_time=="11:30")	{
				echo "<option value=\"11:30\" SELECTED>11:30 AM</option>";	}
			else	{
				echo "<option value=\"11:30\">11:30 AM</option>";	}
			if($end_time=="12:00")	{
				echo "<option value=\"12:00\" SELECTED>12:00 Noon</option>";	}
			else	{
				echo "<option value=\"12:00\">12:00 Noon</option>";	}
			if($end_time=="12:30")	{
				echo "<option value=\"12:30\" SELECTED>12:30 AM</option>";	}
			else	{
				echo "<option value=\"12:30\">12:30 AM</option>";	}
			if($end_time=="13:00")	{
				echo "<option value=\"13:00\" SELECTED>1:00 PM</option>";	}
			else	{
				echo "<option value=\"13:00\">1:00 PM</option>";	}
			if($end_time=="13:30")	{
				echo "<option value=\"13:30\" SELECTED>1:30 PM</option>";	}
			else	{
				echo "<option value=\"13:30\">1:30 PM</option>";	}
			if($end_time=="14:00")	{
				echo "<option value=\"14:00\" SELECTED>2:00 PM</option>";	}
			else	{
				echo "<option value=\"14:00\">2:00 PM</option>";	}
			if($end_time=="14:30")	{
				echo "<option value=\"14:30\" SELECTED>2:30 PM</option>";	}
			else	{
				echo "<option value=\"14:30\">2:30 PM</option>";	}
			if($end_time=="15:00")	{
				echo "<option value=\"15:00\" SELECTED>3:00 PM</option>";	}
			else	{
				echo "<option value=\"15:00\">3:00 PM</option>";	}
			if($end_time=="15:30")	{
				echo "<option value=\"15:30\" SELECTED>3:30 PM</option>";	}
			else	{
				echo "<option value=\"15:30\">3:30 PM</option>";	}
			if($end_time=="16:00")	{
				echo "<option value=\"16:00\" SELECTED>4:00 PM</option>";	}
			else	{
				echo "<option value=\"16:00\">4:00 PM</option>";	}
			if($end_time=="16:30")	{
				echo "<option value=\"16:30\" SELECTED>4:30 PM</option>";	}
			else	{
				echo "<option value=\"16:30\">4:30 PM</option>";	}
			if($end_time=="17:00")	{
				echo "<option value=\"17:00\" SELECTED>5:00 PM</option>";	}
			else	{
				echo "<option value=\"17:00\">5:00 PM</option>";	}
			if($end_time=="17:30")	{
				echo "<option value=\"17:30\" SELECTED>5:30 PM</option>";	}
			else	{
				echo "<option value=\"17:30\">5:30 PM</option>";	}
			if($end_time=="18:00")	{
				echo "<option value=\"18:00\" SELECTED>6:00 PM</option>";	}
			else	{
				echo "<option value=\"18:00\">6:00 PM</option>";	}
			if($end_time=="18:30")	{
				echo "<option value=\"18:30\" SELECTED>6:30 PM</option>";	}
			else	{
				echo "<option value=\"18:30\">6:30 PM</option>";	}
			if($end_time=="19:00")	{
				echo "<option value=\"19:00\" SELECTED>7:00 PM</option>";	}
			else	{
				echo "<option value=\"19:00\">7:00 PM</option>";	}
			if($end_time=="19:30")	{
				echo "<option value=\"19:30\" SELECTED>7:30 PM</option>";	}
			else	{
				echo "<option value=\"19:30\">7:30 PM</option>";	}
			if($end_time=="20:00")	{
				echo "<option value=\"20:00\" SELECTED>8:00 PM</option>";	}
			else	{
				echo "<option value=\"20:00\">8:00 PM</option>";	}
			if($end_time=="20:30")	{
				echo "<option value=\"20:30\" SELECTED>8:30 PM</option>";	}
			else	{
				echo "<option value=\"20:30\">8:30 PM</option>";	}
			if($end_time=="21:00")	{
				echo "<option value=\"21:00\" SELECTED>9:00 PM</option>";	}
			else	{
				echo "<option value=\"21:00\">9:00 PM</option>";	}
			if($end_time=="21:30")	{
				echo "<option value=\"21:30\" SELECTED>9:30 PM</option>";	}
			else	{
				echo "<option value=\"21:30\">9:30 PM</option>";	}
			if($end_time=="22:00")	{
				echo "<option value=\"22:00\" SELECTED>10:00 PM</option>";	}
			else	{
				echo "<option value=\"22:00\">10:00 PM</option>";	}
			if($end_time=="21:30")	{
				echo "<option value=\"22:30\" SELECTED>10:30 PM</option>";	}
			else	{
				echo "<option value=\"22:30\">10:30 PM</option>";	}
			if($end_time=="23:00")	{
				echo "<option value=\"23:00\" SELECTED>11:00 PM</option>";	}
			else	{
				echo "<option value=\"23:00\">11:00 PM</option>";	}
			if($end_time=="21:30")	{
				echo "<option value=\"23:30\" SELECTED>11:30 PM</option>";	}
			else	{
				echo "<option value=\"23:30\">11:30 PM</option>";	}

?>
</tr>
<tr>
	<td>Contact Person:</td>
	<td><input type="text" name="contact" maxlength="40" value="<?php 
			if ($form->value("contact") == ""){
				echo "$contact";	}
			else	{
				echo $form->value("contact"); }?>"></td>
	<td> <?php echo $form->error("contact");?></td>
</tr>
<tr>
	<td>Number Officers Needed:</td>
	<td><input type="text" name="num_officers" maxlength="4" value="<?php 
			if ($form->value("num_officers") == ""){
				echo "$num_officers";	}
			else	{
				echo $form->value("num_officers");  }?>"></td>
	<td><?php echo $form->error("num_officers");?></td>
</tr>
<tr>
	<td>Officer 1:</td>
	<td><select name="officer_1">
			<?php 
			if ($officer1 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer1\">$officer1</option>";
				$new_text="<option value=\"$officer1\" SELECTED>$officer1</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 2:</td>
<td><select name="officer_2">
			<?php 
			if ($officer2 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer2\">$officer2</option>";
				$new_text="<option value=\"$officer2\" SELECTED>$officer2</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 3:</td>
<td><select name="officer_3">
			<?php 
			if ($officer3 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer3\">$officer3</option>";
				$new_text="<option value=\"$officer3\" SELECTED>$officer3</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 4:</td>
<td><select name="officer_4">
			<?php 
			if ($officer4 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer4\">$officer4</option>";
				$new_text="<option value=\"$officer4\" SELECTED>$officer4</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 5:</td>
<td><select name="officer_5">
			<?php 
			if ($officer5 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer5\">$officer5</option>";
				$new_text="<option value=\"$officer5\" SELECTED>$officer5</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 6:</td>
<td><select name="officer_6">
			<?php 
			if ($officer6 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer6\">$officer6</option>";
				$new_text="<option value=\"$officer6\" SELECTED>$officer6</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 7:</td>
<td><select name="officer_7">
			<?php 
			if ($officer7 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer7\">$officer7</option>";
				$new_text="<option value=\"$officer7\" SELECTED>$officer7</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 8:</td>
<td><select name="officer_8">
			<?php
			if ($officer8 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer8\">$officer8</option>";
				$new_text="<option value=\"$officer8\" SELECTED>$officer8</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 9:</td>
<td><select name="officer_9">
			<?php 
			if ($officer9 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer9\">$officer9</option>";
				$new_text="<option value=\"$officer9\" SELECTED>$officer9</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 10:</td>
<td><select name="officer_10">
			<?php 
			if ($officer10 == ""){
				echo "<option value=\"\"></option>$option";		}
			else	{
				$old_text="<option value=\"$officer10\">$officer10</option>";
				$new_text="<option value=\"$officer10\" SELECTED>$officer10</option>";
				$selected_option = str_replace($old_text , $new_text , $option);
				echo "<option value=\"\"></option>$selected_option";		}?></td>
	<td></td>
</tr>

<tr>
	<td>Paid:</td>
	<td>$15 <input type="radio" name="paid" value = "15" <?= ($paid_detail == "15" ? "checked" : ''); ?>></td>
	<td>$20 <input type="radio" name="paid" value = "20" <?= ($paid_detail == "20" ? "checked": ''); ?>></td>
	<td>$25 <input type="radio" name="paid" value = "25" <?= ($paid_detail == "25" ? "checked" : ''); ?>></td>
	<td>$30 <input type="radio" name="paid" value = "30" <?= ($paid_detail == "30" ? "checked" : ''); ?>></td>
	<td>$35<input type="radio" name="paid" value = "35" <?= ($paid_detail == "35" ? "checked" : ''); ?>></td>
	<td>no <input type="radio" name="paid" value = "0" <?= ($paid_detail == "0" ? 'checked' : ''); ?>></td>
<?php
/*	if ($paid_detail == 1)	
		echo "<td>Yes <input type=\"radio\" name=\"paid\" value=\"1\" checked> No <input type=\"radio\" name=\"paid\" value=\"0\"</td>";
	else
		echo "<td> Yes <input type=\"radio\" name=\"paid\" value=\"1\" false> No <input type=\"radio\" name=\"paid\" value=\"0\" 
checked></td>"; */
?>      
	<td></td>
</tr>
<tr>
	<td colspan="2" align="right">
			<input type="hidden" name="subeditdetail" value="<?php echo "$detail_num"?>">
			<input type="submit" value="Submit Changes"></td>
</tr>
</table>
</form>

<?php
	}
}


function delete_detail($detail)	{
	global $session, $database;

$q = "SELECT date, detailLocation FROM ".TBL_DETAILS." WHERE detailNum = 
'$detail'";
 $result = $database->query($q);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
	$date=$row['date'];
	$location=$row['detailLocation'];	}
?>
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" celpadding="3">
<tr><td><h3>You are about to delete the detail at</h3></td></tr>
<tr><td><h3><?php echo "$location";?> on <?php echo "$date.";?></h3></td></tr>
<tr><td>Do you want to continue?</td></tr>
<tr><td>Yes<input type="radio" name="answer" value="1"> No <input type="radio" 
name="answer" value="0" checked></td></tr>
<tr><td><input type="hidden" name="subdeletedetail" value="<?php echo "$detail"?>">
	<input type="submit" value="Submit Response"></td></tr>
</table>
</form>

<?php
}

function volunteer_detail($detail, $officer_num)	{
	global $session, $database;

/* Determine the User Name of the user */
if ($_SESSION['username']){
//echo $_SESSION['usename'];
//sleep(10)
$user=$session->l_name .', ' . $session->f_name;
} else {
 exit();
}
//$user=$session->l_name .', ' . $session->f_name;

/*
 *  Make sure someone hasn't taken the last spot yet 
 * and that the Officer has not alreadty volunteered
 * for this detail.
 */

$q = "SELECT * FROM ".TBL_DETAILS." WHERE detailNum ='$detail'";
$result = $database->query($q);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

	$officer1 = $row['officer_1'];
	$officer2 = $row['officer_2'];
	$officer3 = $row['officer_3'];
	$officer4 = $row['officer_4'];
	$officer5 = $row['officer_5'];
	$officer6 = $row['officer_6'];
	$officer7 = $row['officer_7'];
	$officer8 = $row['officer_8'];
	$officer9 = $row['officer_9'];
	$officer10 = $row['officer_10'];
	$field=$row['$officer_num'];

	if($officer1 == $user || $officer2 == $user || $officer3 == 
$user || $officer4 == $user || $officer5 == $user || $officer6 == $user 
|| $officer7 == $user || $officer8 == $user || $officer9 == $user || $officer10 == $user )	{
		echo "<a href=\"unit_details.php\"><img src=\"images/return.jpg\"></a><br/><br/>";
		?><img src="images/fool1.jpg" width="480px" hspace="200"><?php
	}

	else	if($field == "")	{
			$q = "UPDATE ".TBL_DETAILS." SET $officer_num = '$user' WHERE detailNum = '$detail'";
			mysql_query($q, $database->connection);
			header("Location: unit_details.php");
	}	else	{
			echo "There was a problem submitting your name for the detail.<br?>";
			echo "You can try again or contact the administrator to report this problem.<br/>";
			echo "<br/>Click <a href=\"unit_details.php\">here</a> to go back to the Unit Details Page.";
	}
}
}  ?>
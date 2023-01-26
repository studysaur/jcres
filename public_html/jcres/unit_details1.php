<?php
include 'includes/utilities.inc.php';
//include ("include/session.php");
//require_once "class/user.php";



ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
// Check for a user in the session:

/*if(!$session->logged_in) {
	
	header("Location:main.php");
	}*/
$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : null;
if ($user == null){echo "user is null";} else {echo $user->getUsername() . 'user';}
include 'includes/menu1.inc.php';

/*if ($session->username == ''){
	echo 'no username';
} else {
	$username = $session->username;
}*/
?>
<!DOCTYPE HTML>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
	<!-- internal styles -->
<link rel="stylesheet" type="text/css" href="menu.css">
<link rel="stylesheet" type="text/css" href="css/new_main.css">
<noscript>
 For the chat function of this site to work correctly it is necessary to 
 enable JavaScript.
 Here are the <a href="http://www.enable-javascript.com/" target="_blank">
 instructions how to enable JavaScript in your web browser</a>.
</noscript>
<title>Jackson County Sheriff Auxiliary Division - Unit Details</title></head>
<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<ul id="mainMenu" style="width:930px">
	<li><a href="#">Members Online</a>
		<ul class="sub1">
                 <li class="chat"><a href="#">Just You</a></li>
              </ul>
	</li>
	<li><a href="process.php">Logout</a></li>
        <?  if ($session->username != 'visitor') { 
              print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>"); } 
         if  ($session->isAdmin()) { ?>
       	<li><a href="./class/admin.php">Admin Center</a></li>
     <?  } ?>
	<li><a href="citation_report.php">Various Reports</a></li>
       <? if($session->username != 'visitor') { ?>
       	<li><a href="personal_detail_sheet.php">Account Balance</a></li>
     <?  } ?>
	<li><a href="unit_details.php">Unit Details</a></li>
	<li><a href="aux_roster.php">Current Roster</a></li>
	<li><a href="index.php">Home</a></li>
</ul>
<div class=Section1>

<?
global $database;
/* Query the credit database for all records for the logged in user */
$lastname = $session->l_name;
$user = $session->username;
$st = $session->statu;
$today = date("d M Y");
$todays_date = date("Y-m-d");
$blank = " ";
$level = $session->userlevel;
$st=$session->statu;
if (($st&1024)==1024){
	$edet=1;
	}else{
	$edet=0;}
if (($st&2097152)==2097152){
	$pdet=1;
	}else{
	$pdet=0;
	}

/* Display the link to add a detail if the user level is correct */
if($edet || $pdet) {
	echo "<br/><br/><a href=\"adddetail.php\"><img src=\"images/add_detail.jpg\"></a><br/><br/>"; 
//	$q = "SELECT * FROM ".TBL_DETAILS." WHERE sheet_posted='0' ORDER BY date, start_time"; 
}

echo "<h1>Jackson County Sheriffs Auxiliary Details as of $today.</h1>";
echo "<h2>Click on the checkmark to volunteer for a particular 
detail</h2>"; 
echo "<h2>Once you volunteer, you do not have the ability to 
unvolunteer. You must contact the detail coordinator (Tommy Miller) or the Reserve Captain (Tim Dutton) to have your name removed.</h2>";
//echo "<h2>All Chevron details are managed by Hema Bhakta!</h2>";
//echo "<h2>All Chevron Units use ATAC D Once on post.</h2>";
//echo "<h2>Hub Shift Captain Phone number (228) 217-1381</h2>";


// $last name=$us->getLname();
// echo "<h1>$lastname</h1>";

$q = "SELECT * FROM ".TBL_DETAILS." WHERE sheet_posted='0' ORDER BY 
date, start_time";
$result = $database->query($q);
	
/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Details table failed";
}

?>
<table width=1400 border=1 align="left" cellpadding=2 
cellspacing=1>

<CAPTION><EM><h2>Active Details</h2></EM></CAPTION>
<tr><th width="20"></th><th width="20"></th><th width="20"></th><th width="20"></th>
<th width="30"><b>Invoice</b></th>
<th width="65"><b>Date</b></th>
<th width="110"><b>Location</b></th>
<th width="125"><b>Type of Function</b></th>
<th width="50"><b>Start Time</b></th>
<th width="50"><b>End Time</b></th>
<th width="150"><b>Contact Person</b></th>
<th width="50"><b>Numb Offs</b></th>
<th width="125"><b>Officer Assigned</b></th>
<th width="40"><b>Pay</b></th></tr>

<?
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$num_officers=$row['num_officers'];
	$detail=$row['detail_num'];
	$date= $row['date'];
	$location = $row['detail_location'];
		if(!$location) {
			$location=chr(173);}
	$type = $row['detail_type'];
		if(!$type) {
			$type=" ";}
	$time = $row['start_time'];
		$start_time = substr($time,0,5);
		if (!$start_time){
			$start_time=chr(173);}	
	$time = $row['end_time'];
		$end_time = substr($time,0,5);
		if(!$end_time) {
			$end_time=chr(173);}
	$contact = $row['contact'];
		if(!$contact) {
			$contact=" ";}
	$pay=$row['paid_detail'];
		if($pay) {
			$pay="Yes";	}
		else {
			$pay="No";	}
	$num_assigned="0";

	$officer[0]=$row['officer_1'];
	$officer[1]=$row['officer_2'];
	$officer[2]=$row['officer_3'];
	$officer[3]=$row['officer_4'];
	$officer[4]=$row['officer_5'];
	$officer[5]=$row['officer_6'];
	$officer[6]=$row['officer_7'];
	$officer[7]=$row['officer_8'];
	$officer[8]=$row['officer_9'];
	$officer[9]=$row['officer_10'];
	
	for($i=0; $i<10; $i++)	{
		if($officer[$i]) {
			$num_assigned = $num_assigned + 1;	}
	}

	if($num_assigned == 0) {
		$officer[0]=" ";	
	 	}

    $today_number = strtotime($todays_date);
    $detail_date = strtotime($date);
    
    if($pdet == 1){
    	$post="<td><a href=\"volunteer.php?type=enter&detail=$detail\"><img src=\"images/post.jpg\"/></a></td>";
    	}else{
    	$post="<td></td>";
    }
    if($edet == 1){
    	$edit="<td><a href=\"volunteer.php?type=edit&detail=$detail\"><img src=\"images/edit.jpg\"/></a></td>";
    	}else{
    	$edit="<td></td>";
    }	
    if($edet == 1 && $todays_date<$date){
    	$dele="<td><a href=\"volunteer.php?type=delete&detail=$detail\"><img src=\"images/delete.jpg\" /></a></td>";
    	}else{
    	$dele="<td></td>";
    }
    if($num_assigned<$num_officers && $todays_date<=$date){
    	$volu="<td><a href=\"volunteer.php?type=volunteer&detail=$detail&field=$num_assigned\"><img src=\"images/checkmark.jpg\" /></a></td>";
    	}else{
    	$volu="<td></td>";
    }	
    
	if($todays_date > $date) {
 	 	$cl="past";
 	 } elseif ($num_assigned<$num_officers){
 	 	$cl="help";
 	 } else {
 	 	$cl="good";
 	 }
	if($edet==1 || $pdet==1) {
		$weeks = 176*3600*24; // 25 weeks
		} else {
		$weeks = 43*3600*24; // six weeks
	} 	 


 	if($type =="Chevron Traffic"){// look for Chevron Traffic detail to set up posts
	$contact = "Hwy 90 and Chevron";// make this the post assignment on the first line
	}
	$loc="<td></td>";	
		
		print("<tr class=\"$cl\">$post $edit $dele $volu <td>$detail</td><td>$date</td><td>$location</td><td>$type</td><td>$start_time</td><td>$end_time</td><td>$contact</td><td align=\"center\">$num_officers</td><td>$officer[0]</td><td>$pay</td></tr>\r");
		
		if($num_assigned > 1)	{
			for ($z=1; $z<$num_assigned; $z++)	{
			if($type =="Chevron Traffic"){
				if($z==1){
					$loc = "<td></td>";
				}
				if($z==2){
					$loc="<td></td>";
				}
				if($z==3){
					$loc="<td></td>";
				}
				if($z==4){
					$loc="<td></td>";
				}
				if($z==5){
					$loc="<td></td>";
				}
			}
			
				
print("<tr class=\"$cl\"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td> $loc <td></td><td>$officer[$z]</td><td></td></tr>\r");
			}
		}
	}

mysql_free_result($result);
?>
</table>
</div>
</body>
</html>
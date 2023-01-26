<?php 
/* Unit Details
 *Reads the Detail table sorts it by date and displays the information
 *in a table it highlights row based on status of in the past, filled or unfilled
 */
include ("include/session.php");
include "class/User.php";
/*if(!$session->logged_in) {
	
	header("Location:main.php");
	}*/
if ($session->username == ''){
	echo 'no username';
} else {
	$username = $session->username;
}
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
       	<li><a href="./admin/admin.php">Admin Center</a></li>
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
echo "<h3>Once you volunteer, you do not have the ability to 
unvolunteer. You must contact the detail coordinator (Tommy Miller) or one of the Reserve Captains to have your name 
removed.</h3>";
// $lastname=$us->getLname();
echo "<h1>$lastname</h1>";

$q = "SELECT * FROM ".TBL_DETAILS." WHERE sheet_posted='0' ORDER BY 
date, start_time";
$result = $database->query($q);
	
/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Details table failed";
}

?>
<table width=1110 border=1 align="left" cellpadding=2 
cellspacing=1>

<CAPTION><EM><h2>Active Details</h2></EM></CAPTION>
<tr ><?php /*if($pdet==1){echo'<th width=50px></th>';} if($edet==1){echo '<th width=25px></th><th width=25px></th>';}*/?><th width=25px></th><th width=25px></th><th width=25px></th><th></th>
<th width=60px><b>Invoice</b></th>
<th width=80px><b>Date</b></th>
<th width=170px><b>Location</b></th>
<th width=145px><b>Type of Function</b></th>
<th width="50"><b>Start Time</b></th>
<th width="50"><b>End Time</b></th>
<th width="160px"><b>Contact Person</b></th>
<th width="50px"><b>Number Officers</b></th>
<th width="150px"><b>Officer Assigned</b></th>
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
    if($num_assigned<$num_officers){
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
					$loc = "<td>Hwy 90 and Chevron</td>";
				}
				if($z==2){
					$loc ="<td>Orange Grove and Chevron</td>";
				}
				if($z==3){
					$loc="<td>Main Parking Lot South Entrance</td>";
				}
				if($z==4){
					$loc="<td>Orchard and Hwy 611</td>";
				}
				if($z==5){
					$loc="<td>Orange Grove and Chevron</td>";
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
<!--script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var cv = '<? echo $username; ?>';
    setInterval(function() {
       $.post( "menu.php", {userName: cv})
         .done(function(data) {
         $(".sub1").html(data);
  });
  }, 5000);
  $('.sub1').on("click","li", function(e) {
        var who = $(this).text();
        var whoID = $(this).attr('id');
        var file = cv + "-" + whoID + ".txt"
        var chatFile = "chat/room/index.php?name=" + file + "&file=" + who; 
        var windowName = "popUp";//$(this).attr("name");

        $.post( "chat/room/startChat.php", {file: file, username: cv, requestee: who, ID: whoID});
                window.open(chatFile, windowName, 'width=420,height=500');
    });
   setInterval (function() {
      $.post( "chat/room/checkChat.php", {userName: cv})
         .done(function(data) {
         var chat = data.split(";");
         var chatRequested = chat[0];
         var chatBy = chat[1];
         var file = chat[2];
         var chatFile = "chat/room/index.php?name=" + file + "&file=" + chatBy; 
         if (chatRequested == "true") {
            	var answer = confirm(chatBy + " has requested to start a private chat with you. Do you wish to accept?\n\nNOTE: You must allow popups for this site to use chat!!")
         	   if (answer){

                    $.post( "chat/room/chatResponse.php", {response: "true", who: cv, file: file})
                          window.open(chatFile, "popup", "width=420,height=500");
	          }
	          else{

		          $.post( "chat/room/chatResponse.php", {response: "false", who: cv, file: file});
	          }
         }
       });
   }, 10000); 

});
</script-->
</body>
</html>
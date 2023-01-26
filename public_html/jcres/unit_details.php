<?php
include ("./include/session.php");
include "../../classes/Aux/Entity/User.php";
if(!$session->logged_in) {
	
	header("Location:index.php");
	}
/*if($_SESSION['username']=="") {
	header("Location: index.php");
	exit();
	} */
/*	if (!isset($username)){
	header("Location:../index.php");
	exit();
	} */
$username = $session->username;

?>
<!DOCTYPE HTML>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
	<!-- internal styles -->
<link rel="stylesheet" type="text/css" href="css/menu.css">
<link rel="stylesheet" type="text/css" href="css/new_main.css">
<title>JCSO Unit Details</title></head>

<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<div class="body">
<div class="nav">
<ul id="mainMenu" style="width:90%">
	<li><a href="#">Members Online</a>
		<ul class="sub1">
                 <li class="chat"><a href="#">Just You</a></li>
              </ul>
	</li>
	<li><a href="/logout">Logout</a></li>
        <?php  if ($session->username != 'visitor') { 
              print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>"); } 
         if  ($session->isAdmin()) { ?>
       	<li><a href="register.php">Admin Center</a></li>
     <?php  } ?>
	<li><a href="citation_report.php">Various Reports</a></li>
       <?php if($session->username != 'visitor') { ?>
       	<li><a href="personal_detail_sheet.php">Account Balance</a></li>
     <?php  } ?>
	<li><a href="unit_details.php">Unit Details</a></li>
	<li><a href="aux_roster.php">Current Roster</a></li>
	<li><a href="/">Home</a></li>
</ul></div>
<div class=Section1>

<?php
global $database;
/* Query the credit database for all records for the logged in user */
$lastname = $session->l_name;
$user = $session->username;
$st = $session->status;
$today = date("d M Y");
$todays_date = date("Y-m-d");
$blank = " ";
//$level = $session->userlevel;
$st=$session->status;
if (($st&1024)==1024){
	$edet=1;
	}else{
	$edet=0;}
if (($st&2048)==2048){
	$pdet=1;
	}else{
	$pdet=0;
	} 
echo "<br/><br/>";
/* Display the link to add a detail if the user level is correct */
if( $edet || $pdet) {
	echo '<a href="adddetail.php"><img src="images/add_detail.jpg"></a><br/><br/>'; 
//	$q = "SELECT * FROM ".TBL_DETAILS." WHERE sheet_posted='0' ORDER BY date, start_time"; 
}
 echo '<h1 class="warning">The Volunteer button now takes you to an instruction page.  There is a button at the bottom you must "Accept Detail" at the bottom of that page to take the Detail</h1>';
echo "<h1>Jackson County Sheriffs Reserve Details as of $today.</h1>";
echo "<h2>Click on the checkmark to volunteer for a particular 
detail</h2>"; 
echo "<h2>Once you volunteer, you do not have the ability to 
unvolunteer. You must contact the detail coordinator (Tommy Miller) or the Reserve Deputy Chief (Jeff Mattison) to have your name removed.</h2>";
//echo "<h2>All Chevron details are managed by Hema Bhakta!</h2>";
//echo"<h2>All Chevron Units use ATAC D Once on post.</h2><br>";
//echo"<h2>Hub Shift Captain Phone number (228) 217-1381</h2><br>";


// $last name=$us->getLname();
// echo "<h1>$lastname</h1>";
if ($edet || $pdet) {
    $q = "SELECT * FROM ".TBL_DETAILS." WHERE sheetPosted='0000-00-00' ORDER BY date, startTime";
    } else {
    $q = "SELECT * FROM ".TBL_DETAILS . " WHERE sheetPosted = '0000-00-00' and contact != 'reuse' ORDER BY date, startTime";
    }
$result = $database->query($q);
	
/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Details table failed";
}

?>

<EM><h2>Active Details</h2></EM>
<table width=1400 border=1 align="left" cellpadding=2 
cellspacing=1>

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

<?php
$today_number = strtotime($todays_date);
$j=0;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$num_officers=$row['numOfficers'];
	$detail=$row['detailNum'];
	$date= $row['date'];
	$location = $row['detailLocation'];
		if(!$location) {
			$location="";}
	$type = $row['detailType'];
		if(!$type) {
			$type="";}
	$time = $row['startTime'];
		$start_time = substr($time,0,5);
		if (!$start_time){
			$start_time=chr(173);}	
	$time = $row['endTime'];
		$end_time = substr($time,0,5);
		if(!$end_time) {
			$endTime=chr(173);}
	$contact = $row['contact'];
		if(!$contact) {
			$contact="";}
	$pay=$row['paidDetail'];
		if($pay == 0) {
		$pay="No";	
		} else {
		$pay="Yes";
		}
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
			$num_assigned = $num_assigned +1;	}
	}

	if($num_assigned == 0) {
		$officer[0]=" ";	
	 	}

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
    if($num_assigned<$num_officers && $todays_date<=$date && ($st&2)==2){

//  	$volu="<td><a href=\"volunteer.php?type=volunteer&detail=$detail&field=$num_assigned&location=$location\"><img src=\"images/checkmark.jpg\" /></a></td>";
     $volu="<td><a href=\"sop.php?detail=$detail&field=$num_assigned&location=$location\"><img src=\"images/checkmark.jpg\" /></a></td>";
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

    if($type == "Tournament") {//look for school tournaments to set up locations
        $location = "Vancleave High School Gym";
    }

 	if($type =="Chevron Traffic"){// look for Chevron Traffic detail to set up posts
		if ($start_time == '04:00' && $date > "2022-2-24") { // array for morning shift
		 	$location = "Hwy 90 at Chevron dr";
		} else { // array for evening shift
			$location =  "Gate 16 access Rd";
		}
	}
	print("<tr class=\"$cl\">$post $edit $dele $volu <td>$detail</td><td>$date</td><td>$location</td><td>$type</td><td>$start_time</td><td>$end_time</td><td>$contact</td><td align=\"center\">$num_officers</td><td>$officer[0]</td><td>$pay</td></tr>\r");
	if($num_assigned > 1)	{
		for ($z=1; $z<$num_assigned ; $z++)	{
			$location = "";
			if($type =="Chevron Traffic" && $start_time == "04:00") {
				if($z==1){
					$location = "Hwy 611 at Heavy Haul Rd.  Monitor stop sign";
				}
				if($z==2){
					$location="Gate 16 Access Rd";
				}
				if($z==3){
					$location="Bayou Cumbest and Chevon";
				}
			}
			if ($type == "Chevron Traffic" && $start_time == "16:00") {
					if($z==1){
						$location="Hwy 611 at Heavy Haul Rd. Monitor stop sign";
					}
					if($z==2){
						$location="Hwy90 at Chevron Dr";
					}
					if($z==3){
						$location="Bayou Cumbest and Chevron Dr";
					}
			        
			}
			
		
		
		print("<tr class=\"$cl\"><td></td><td></td><td></td><td></td><td></td><td></td><td>$location</td><td></td><td></td><td></td><td></td><td></td><td>$officer[$z]</td><td></td></tr>\r");



		}
		//echo $num_assigned .  ' is numberasigned<br>';
	}
}
	
mysql_free_result($result);
?>
</table>
</div>
<!--script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var cv = '<?php echo $username; ?>';
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
</div>
</body>
</html>
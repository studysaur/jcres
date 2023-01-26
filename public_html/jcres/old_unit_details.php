<?
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
$username = $session->username;
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
	<!-- internal styles -->
<link rel="stylesheet" type="text/css" href="menu.css">
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
$today = date("d M Y");
$todays_date = date("Y-m-d");
$blank = " ";
$level = $session->userlevel;

/* Display the link to add a detail if the user level is correct */
if($level== '2' || $level == '5' || $level == '6' || $level == '9') {
	echo "<br/><br/><a href=\"adddetail.php\"><img src=\"images/add_detail.jpg\"></a><br/><br/>"; 
//	$q = "SELECT * FROM ".TBL_DETAILS." WHERE sheet_posted='0' ORDER BY date, start_time"; 
}

echo "<h1>Jackson County Sheriffs Auxiliary Details as of $today.</h1>";
echo "<h3>Click on the checkmark to volunteer for a particular 
detail. 
Once you volunteer, you do not have the ability to 
unvolunteer. You must contact the detail coordinator (Tommy Miller) or one of the Reserve Captains to have your name 
removed.</h3>";

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
<tr><th width="25"></th><th width="25"></th><th width=25px></th><th width=25px></th>
<th bgcolor="gray" width=60px><b>Invoice</b></th>
<th bgcolor="gray" width=80px><b>Date</b></th>
<th bgcolor="gray" width=170px><b>Location</b></th>
<th bgcolor="gray" width=145px><b>Type of Function</b></th>
<th bgcolor="gray" width="50"><b>Start Time</b></th>
<th bgcolor="gray" width="50"><b>End Time</b></th>
<th bgcolor="gray" width="160px"><b>Contact Person</b></th>
<th bgcolor="gray" width="50px"<b>Number Officers</b></th>
<th bgcolor="gray" width="150px"><b>Officer Assigned</b></th>
<th bgcolor="gray" width="40"><b>Pay</b></th></tr>

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

	if(!$officer[0]) {
		$officer[0]=$blank;	}

        $today_number = strtotime($todays_date);
        $detail_date = strtotime($date);


/*  Account Admin needs the button to post completed detail sheets  */
if($level=="3" || $level=="5" || $level=="7" || $level=="9")	{
	$post="<td><a href=\"volunteer.php?type=enter& 
detail=$detail\"><img src=\"images/post.jpg\" 
/></a></td>";
	$edit="<td><a href=\"volunteer.php?type=edit&detail=$detail\"><img 
src=\"images/edit.jpg\" /></a></td><td></td>";}
	else	{
	$post="<td></td>";	

/*  Detail Coordinators do not need the buttons to edit and delete details since detail has passed  */
	$edit="<td></td><td></td>"; }

/* Is the detail less than six weeks away */
if($level=="3" || $level=="5" || $level=="7" || $level=="9") {
	$weeks = 176*3600*24; // 25 weeks
	} else {
	$weeks = 43*3600*24; // six weeks
	}

if(($detail_date - $today_number) < $weeks) {  

/** Time to determine the background color of the table row  **/

/*  The detail is in the past and we have not processed the detail sheet  */
	 if($todays_date > $date) {
 	 	$color="crimson";
		
		print("<tr>$post $edit<td></td><td bgcolor=$color>$detail</td><td bgcolor=$color>$date</td><td bgcolor=$color>$location</td><td bgcolor=$color>$type</td><td bgcolor=$color>$start_time</td><td 
bgcolor=$color>$end_time</td><td 
bgcolor=$color>$contact</td><td bgcolor=$color 
align=\"center\">$num_officers</td><td 
bgcolor=$color>$officer[0]</td><td bgcolor=$color>$pay</td></tr>\r");
		
		if($num_assigned > 1)	{
			for ($z=1; $z<$num_assigned; $z++)	{
				
print("<tr><td></td><td></td><td></td><td></td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$blank</td>
<td bgcolor=$color>$officer[$z]</td>
<td bgcolor=$color>$blank</td></tr>\r");
					}
			}

/*  The detail is not filled and we need to show the volunteer checkmark  */
 	} else if($num_assigned < $num_officers && $level <> "0") {
		$color="gold";

	/*  Account Administor needs button to post completed detail sheets  */
	if($level=="3" || $level=="5" || $level=="7" || $level=="9")	{
			$post="<td><a href=\"volunteer.php?type=enter&detail=$detail\"><img src=\"images/post.jpg\" /></a></td>";}
		else	{
			$post="<td></td>";	}		

	/*  Detail Coordinators need the buttons to edit and delete details  */
	if($level=="2" || $level=="5" || $level=="6" || $level=="9")	{
			$edit="<td><a href=\"volunteer.php?type=edit&detail=$detail\"><img src=\"images/edit.jpg\" /></a></td>
			<td><a href=\"volunteer.php?type=delete&detail=$detail\"><img src=\"images/delete.jpg\" /></a></td>";	}
		else 	{
			$edit="<td></td><td></td>";	}

	/* Remove the Volunteer checkmark if the user is a visitor  */
	if ($session->username=='visitor')	{
	print("<tr>$post $edit <td></td><td bgcolor=$color>$date</td><td bgcolor=$color>$location</td><td bgcolor=$color>$type</td><td 
bgcolor=$color>$start_time</td><td bgcolor=$color>$end_time</td><td bgcolor=$color>$contact</td><td bgcolor=$color align=\"center\">$num_officers</td><td 
bgcolor=$color>$officer[0]</td><td bgcolor=$color>$pay</td></tr>\r");	}
	else	{

	print("<tr>$post $edit <td><a href=\"volunteer.php?type=volunteer&detail=$detail&field=$num_assigned\"><img src=\"images/checkmark.jpg\" 
/></a></td><td bgcolor=$color>$detail</td><td bgcolor=$color>$date</td><td bgcolor=$color>$location</td><td bgcolor=$color>$type</td><td 
bgcolor=$color>$start_time</td><td bgcolor=$color>$end_time</td><td bgcolor=$color>$contact</td><td bgcolor=$color align=\"center\">$num_officers</td><td 
bgcolor=$color>$officer[0]</td><td bgcolor=$color>$pay</td></tr>\r");
		}


		
		if($num_assigned > 1)	{
			for ($z=1; $z<$num_assigned; $z++)	{
				print("<tr><td></td><td></td><td></td><td></td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$officer[$z]</td>
				<td bgcolor=$color>$blank</td></tr>\r");
					}
		}

/* The detail is fine  */
	} else {
 		$color="#66CC33";

/*  Account Administor needs button to post completed detail sheets  */
if($level=="3" || $level=="5" || $level=="7" || $level=="9")	{
		$post="<td><a href=\"volunteer.php?type=enter& 
detail=$detail\"><img src=\"images/post.jpg\" 
/></a></td>";}
	else	{
		$post="<td></td>";	}		

/*  Detail Coordinators need the buttons to edit and delete details  */
if($level=="2" || $level=="5" || $level=="6" || $level=="9")	{
		$edit="<td><a 
href=\"volunteer.php?type=edit&detail=$detail\"><img src=\"images/edit.jpg\" /></a></td>
			<td><a 
href=\"volunteer.php?type=delete&detail=$detail\"><img src=\"images/delete.jpg\" /></a></td>";	}
	else	{
		$edit="<td></td><td></td>";	}

		print("<tr>$post $edit<td></td>
		<td bgcolor=$color>$detail</td>
		<td bgcolor=$color>$date</td>
		<td bgcolor=$color>$location</td>
		<td bgcolor=$color>$type</td>
		<td bgcolor=$color>$start_time</td>
		<td bgcolor=$color>$end_time</td>
		<td bgcolor=$color>$contact</td>
		<td bgcolor=$color align=\"center\">$num_officers</td>
		<td bgcolor=$color>$officer[0]</td>
		<td bgcolor=$color>$pay</td></tr>\r");
		
		if($num_assigned > 1)	{
			for ($z=1; $z<$num_assigned; $z++)	{
				print("<tr><td></td><td></td><td></td><td></td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$blank</td>
				<td bgcolor=$color>$officer[$z]</td>
				<td bgcolor=$color>$blank</td></tr>\r");
					}
			}
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

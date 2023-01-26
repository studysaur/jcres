<?php
/* Mounted Patrol Roster
 * Reads the user table, sorts it by Unit Number and displays the information 
 * in a table.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
$username = $session->username;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Jackson County Sheriff Auxiliary - Roster</title>
	<meta charset="utf-8">
	<meta name="author" content="Dean Sellars">
	<!-- internal styles -->
<link rel="stylesheet" type="text/css" href="menu.css">
<noscript>
 For the chat function of this site to work correctly it is necessary to 
 enable JavaScript.
 Here are the <a href="http://www.enable-javascript.com/" target="_blank">
 instructions how to enable JavaScript in your web browser</a>.
</noscript>
<style>
 .table_header {
     font-family:Verdana, Geneva, sans-serif;
     font-size:14px;
     color:#cccccc;
     background:#333399;
}
.table_cell {
     font-family:Verdana, Geneva, sans-serif;
     font-size:14px;
     background: white;
}


</style>
</head>
<body bgcolor="#FFFFFF" lang=EN-US>
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
<br><br>

	<p align=left style="margin-left:100px;"><span
style='font-size:24.0pt;line-height:115%;font-family: Verdana, sans-serif'><br>Jackson
		County Sheriffs Auxiliary Division</span></p>
	<p align=left style="margin-left:200px;"><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'>P.O.
		Box 2189 - Pascagoula, Mississippi 39569-2189</span></p>
	<p align=left style="margin-left:120px;"><span class=GramE><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'>S.O.
		228-769-3063 - 228-217-4330 </span></span><span
style='font-size:16.0pt;line-height:115%;font-family:"Verdana","sans-serif"'></span></p>
	<table width=950 border=1 align="left" cellpadding=2 
cellspacing=1 style="margin-left:30px;">
		<tr>
			<td class="table_header" width=60><b>Unit #</b></td>
			<td class="table_header" width=90><b>Rank</b></td>
			<td class="table_header" width=160><b>Name</b></td>
			<td class="table_header" width=115><b>Home Phone</b></td>
			<td class="table_header" width=115><b>Work Phone</b></td>
			<td class="table_header" width=115><b>Cell Phone</b></td>
            <td class="table_header" width=20><b>P*</b></p>
		</tr>
<?
global $database;
/* $user_info = $database->getAllUsers(); */
$q = "SELECT sort, unit_num, rank, name, phone_home, phone_work, phone_cell, 
email, probationary FROM ".TBL_USERS." where username != 'visitor' ORDER BY sort";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysqli_num_rows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from User table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$unit_num = $row['unit_num'];
	$sort	= $row['sort'];
	if ($sort == '999')	break;
	$rank = $row['rank'];
	$name = $row['name'];
	$phone_home = $row['phone_home'];
		if (!$phone_home){
			$phone_home=chr(0);}
	$phone_work = $row['phone_work'];
		if (!$phone_work){
			$phone_work=chr(0);}
	$phone_cell = $row['phone_cell'];
		if (!$phone_cell){
			$phone_cell=chr(0);}	
	$test = $row['email'];
	if(!$test) {
		$email=chr(0);
		} else {
		$email = "<a 
href=\"mailto:".$row['email']."\"><span='color:blue;'>".$row['email']."</span></a>";
		}
	$probationary = $row['probationary'];
	if($probationary)  {
		$probationary="X";
		}
	else
		{
		$probationary=chr(0);
		}


print("<tr><td class=\"table_cell\">$unit_num</td><td class=\"table_cell\">$rank</td><td class=\"table_cell\">$name</td><td class=\"table_cell\">$phone_home</td><td class=\"table_cell\">$phone_work</td><td class=\"table_cell\">$phone_cell</td><td class=\"table_cell\" align=center>$probationary</td></tr>\r");

}

mysql_free_result($result);
?>
<tr><td colspan="8" align="center">* an "X" in the P column indicates the officer is still in a <b>Probationary</b> period.</td></tr>

</table>
</div>

<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
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
</script>
</body>
</html>

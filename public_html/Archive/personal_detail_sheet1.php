<?
/* 
 * Personal Detail Sheet - this web page will allow
 * a member to look at the details and other items 
 * that add money to their account. It also will show
 * all the deductions from their accounts as well as 
 * the total amount of money available. I intend on 
 * limiting the displayed data to the current and last years.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
$username = $session->username;
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="menu.css">
<noscript>
 For the chat function of this site to work correctly it is necessary to 
 enable JavaScript.
 Here are the <a href="http://www.enable-javascript.com/" target="_blank">
 instructions how to enable JavaScript in your web browser</a>.
</noscript>
/* <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
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
</script> */

<style>
##excel_link {
	width: 200px;
}
	
-->
</style>
<title>Jackson County Mounted Patrol - Personal Detail Sheet</title></head>
<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<ul id="mainMenu" style="width:980px">
/*	<li><a href="#">Members Online</a>
		<ul class="sub1">
                 <li class="chat"><a href="#">Just You</a></li>
              </ul>
	</li> */
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
	<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
	<li><a href="index.php">Home</a></li>
</ul>
<?
global $database;
/* Query the credit database for all records for the logged in user */
$level = $session->userlevel;
if($level == '3' || $level == '5' || $level == '7' || $level == '9')	
{
	$q = "SELECT name,username FROM ".TBL_USERS." ORDER BY name";
	$result = $database->query($q);
	$num_rows = mysql_numrows($result);

	if(!result || ($num_rows < 0))	{
		echo "<h2>Query to select all users from users table 
failed"; }

	$option = "";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
		$name = $row['name'];
		$username = $row['username'];
		$option = $option."<option value=\"$username\">$name</option>";
	}
	$option = $option."</select>";
	?>
	<form action="" method="POST">
	<table align="center" border="0" cellpadding="3" cellspacing="0">
	<tr><td><h2>Select User to display:</h2></td><td><select name="username"><?echo 
"$option"?></td></tr>
	<tr><td colspan="2" align="right"><input type="submit" value="Submit">
					   <input type="hidden" name="getDeputy" value="1"></td></tr>
	</table>
	<?
	$user = $_POST['username'];
	$q="SELECT name FROM ".TBL_USERS." WHERE username = '$user'";
	$result = $database->query($q);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$name = $row['name'];
	if(isset($_POST[getDeputy]))	{
		echo "<A href=\"postExpense.php?user=$user&name=$name\"><img src=\"./images/postExpense.jpg\"></a>";
		}
	}
else	{
	$name = $session->name;
	$user = $session->username;
	}

$old_credit = "0.00";
$old_expenses = "0.00";
$current_credit = "0.00";
$current_expenses = "0.00";
$current_year_credit = "0.00";
$today = date("d M Y");
/*
echo "<h2>Personal Detail Account for: $name</h2>";
echo "<h2>Forms generated: $today</h2>";
*/
$q = "SELECT * FROM ".TBL_PLUS." WHERE username = '".$user."' ORDER BY date";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Credit table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$date= $row['date'];
	$location = $row['location'];
		if(!$location) {
			$location=chr(173);}
	$type = $row['type'];
		if(!$type) {
			$type=chr(173);}
	$hours_worked = $row['hours_worked'];
		if (!$hours_worked){
			$hours_worked=chr(173);}	
	$money_made = $row['money_made'];
	$remarks = $row['remarks'];
		if(!$remarks) {
			$remarks=chr(173);
		}

/* Explode the time in order to determine whether or not to display the record */
$todays_date = date("Y-m-d");
$full_date = explode("-", $date);
$todays_full_date = explode("-", $todays_date);

/* Test to see if the record was created in the last two years */
if ($full_date[0]  <  ($todays_full_date[0] - 1))  {
		$old_credit = $old_credit + $money_made;
		}
	else
		{
		$current_credit = $current_credit + $money_made;
              if ($full_date[0] == $todays_full_date[0] ) {
                     $current_year_credit = $current_year_credit + $money_made;
              }
		
		$credits[] = "<tr><td width=110px><span style='font:100% 
Verdana, Arial, 
Helvetica, sans-serif;'>$date</span></td><td width=300px><span 
style='font:100% 
Verdana, Arial, Helvetica, 
sans-serif;'>$location</span></td><td width=300px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$type</span></td><td width=50px><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$hours_worked</span></td><td width=75px 
text align=right><span 
style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
$money_made</span></td><td><span 
style='font:100% Verdana, Arial, Helvetica, sans-serif;'> 
$remarks</span></td></tr>\r";
		}
}
mysql_free_result($result);

/**
 * Now we begin to create the expenditures table
 */

$q = "SELECT * FROM ".TBL_MINUS." WHERE username = '".$user."' ORDER BY date";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Credit table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$date= $row['date'];
	$description = $row['description'];
		if(!$description) {
			$description=chr(173);}
	$amount = $row['amount'];
		if(!$amount) {
			$amount=chr(173);}

/* Explode the time in order to determine iwhether or not to display the record */
$todays_date = date("Y-m-d");
$full_date = explode("-", $date);
$todays_full_date = explode("-", $todays_date);

/* Test to see if the record was created in the last two years */
if ($full_date[0]  <  ($todays_full_date[0] - 1))  {
		$old_expenses = $old_expenses + $amount;
		}
	else
		{
		$current_expenses = $current_expenses + $amount;
		
		$expenditures[] = "<tr><td width=110px><span style='font:100% 
Verdana, Arial, 
Helvetica, sans-serif;'>$date</span></td><td><span 
style='font:100% 
Verdana, Arial, Helvetica, 
sans-serif;'>$description</span></td><td width=100px align=right><span 
style='font:100% Verdana, Arial, Helvetica, 
sans-serif;'>$amount</span></td></tr>\r";
		}
}
mysql_free_result($result);
$start_year = date(Y)-1;
$start_date = "$start_year-01-01";

$current_balance = (($old_credit + $current_credit) - ($old_expenses + $current_expenses));
$previous_balance = ($old_credit - $old_expenses);

$previous_balance = money_format('%i', $previous_balance);
$current_credit = money_format('%i', $current_credit);
$current_expenses = money_format('%i', $current_expenses); 
$current_balance = money_format('%i', $current_balance);
$current_year_credit = money_format('%i', $current_year_credit);

?>
&nbsp;
<table  width="1100" align="center"  cellpadding="1" cellspacing="2">
<tr>
	<td style="font-size:24px">Personal Detail Account for: <? echo "<b>$name</b>"; ?></td>
	<td style="font-size:24px" align="right">Balance as of <? echo "$start_date"; ?> : </td>
	<td style="font-size:24px" align="right"><b>$<? echo "$previous_balance</b>"; ?></td>
<tr>
	<td style="font-size:24px">Forms generated: <? echo "<b>$today</b>"; ?></td>
	<td style="font-size:24px" align="right">Total Credits since <? echo "$start_date"; ?> : </td>
	<td style="font-size:24px" align="right"><b>$<? echo "$current_credit</b>"; ?></td>
</tr>
<tr>
	<td colspan="2" style="font-size:24px" align="right">Total Expenses since <? echo "$start_date"; ?> : </td>
	<td style="font-size:24px" align="right"><b>$<? echo "$current_expenses</b>"; ?></td>
</tr>
<tr>
	<td colspan="2" style="font-size:24px" align="right">Current Balance : </td>
	<td style="font-size:24px" align="right"><b>$<? echo "$current_balance</b>"; ?></td>
</tr>
<tr>
	<td colspan="2" style="font-size:20px" align="right">Credits Earned This Year : </td>
	<td style="font-size:20px" align="right"><b>$<? echo "$current_year_credit</b>"; ?></td>
</tr>

</table>
&nbsp;
<table width=1100 border=1 align="center" cellpadding=2 cellspacing=1>

<CAPTION><EM><h2>Credits Applied to Your Account</h2></EM></CAPTION>
<tr bgcolor="gray"><th><b>Date</b></th><th><b>Location</b></th><th><b>Type of Function</b></th><th><b>Hrs</b></th><th><b>$ 
Earned</b></th><th><b>Remarks</b></th>
</tr>
<? 
if($credits)	{
	foreach ($credits as $value)	{
		print($value);
		}
	}
unset ($value);
?>
</table>

<table width=1100 border=1 align="center" cellpadding=2 cellspacing=1>
<p>&nbsp;</p>
<CAPTION><EM><h2>Expenditures Applied to Your Account</h2></EM></CAPTION>
<tr bgcolor="gray"><th><b>Date</b></th><th><b>Description</b></th><th><b>Amount</b></th></tr>
<?
if($expenditures)	{
	foreach ($expenditures as $value)	{
		print($value);
		}
	}
unset ($value);	
?>

</table>
</body>
</html>

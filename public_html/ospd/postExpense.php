<?php
/**
 * postExpense.php is used to deduct money from a users detail account
 */

include("include/session.php");
?>
<html>
<title>Post Expense</title>
<head>
</head>
<?

global $database, $session;

$user = $_REQUEST['user'];
$name = $_REQUEST['name'];
$uid = $_REQUEST['uid'];

?>
<a href="personal_detail_sheet.php"><img src="./images/return.jpg"></a>	
<form  action="" method="POST">
<table border="1"  align="left" cellspacing="2" cellpadding="2">
<CAPTION><EM><h2>Deduct Money From <?php echo "$name";?></h2></EM></CAPTION>

<tr>
	<td><h2>Date:</h2></td>
	<td><input type="text" id="calendar" name="calendar" />
    	<button id="trigger"><img src="images/cal.gif"></button>
    	</td>
</tr>
<tr>
	<td><h2>Amount:</h2></td>
	<td><input type="text" name="amount"></td>
</tr>
<tr>
	<td><h2>Check Num:</h2></td>
	<td colspan="3" align="left"><input type="text" name="check"></td>
</tr>
<tr>
	<td><h2>Description:</h2></td>
	<td colspan="3" align="left"><input type="text" name="description"></td>
</tr>
<tr>
    <td colspan="4" align="right"><input type="hidden" name="subtractAmount">
     <input type="submit" name="Post Expense"></td>
</tr>
<?php
if(isset($_POST['subtractAmount']))	{
	$expenseDate = $_POST['calendar'];
	$amount = $_POST['amount'];
	$description = $_POST['description'];
	$checkNum = $_POST['check'];

	$q = "INSERT INTO ".TBL_MINUS." VALUES ('NULL', '$user', '$uid', '$expenseDate', '$description', '$amount', '$checkNum')";
	$result = $database->query($q);
	if (!$result)  {
		echo "Insert of Record into Expense table failed";
	} 
}
?>
</table>
</form>
</html>

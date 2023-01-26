<?
/* Mounted Patrol Roster
 * Reads the user table, sorts it by Unit Number and displays the information 
 * in a table.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />

<title>Jackson County Mounted Patrol - Detail Summary</title></head>
<body>
<a href="./citation_report.php"><img src="./images/return.jpg"></a>
<div class=Section1>

<form action="detail_summary.php" method="POST">
<table width=175 border=1 align="center" cellpadding=2 cellspacing=1>
<caption><h3><i>Select Time Frame for Report</i></h3></caption>
	<tr>
		<td><input type="radio" name="timeframe" value="last" 
/>Last Year</br>
		    <input type="radio" name="timeframe" value="this" />Current Year to Date
		</td>
	</tr>
	<tr>	<td align="center"><input type="submit" value="Submit" 
/>
	</tr>
</table>
</form>
</div>
</body>
</html>

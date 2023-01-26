<?php
/* Auxiliary Roster
 * Reads the user table, sorts it by Unit Number and displays the information 
 * in a table.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
$username = $session->username;
$pageTitle = "Auxiliary Roster";
include "includes/header.inc.html";
include 'includes/menu1.php';
?>
<article>
<div class="container-fluid" style="margin-top: 10px">
    <div class="table-row header">
        <div class="column index">SO#</div>
        <div class="wrapper attributes">
            <div class="wrapper rank-code">
                <div class="column rank">Rank</div>
                <div class="column code">Code</div>
            </div>
            <div class="wrapper first-last">
                <div class="column first">First Name</div>
                <div class="column last">Last</div>
            </div>
            <div class="wrapper phone">
                    <div class="column cell">Cell Phone</div>
	            <div class="wrapper work-home"> 
                	<div class="column work">Work Phone</div>
            	    <div class="column home">Home Phone</div>
            	</div>
            </div>
        </div>
    </div>
<?
global $database;
/* $user_info = $database->getAllUsers(); */
$q = "SELECT unit_num, code, rank, f_name, l_name, phone_home, phone_work, phone_cell, squad, probationary FROM ".TBL_USERS." where squad is not NULL AND squad <> '' ORDER BY sort";
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from User table failed";
}
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$unit = $row['unit_num'];
	$code = $row['code'];
	$rank = $row['rank'];
	$fname = $row['f_name'];
	$lname = $row['l_name'];
	$phome = $row['phone_home'];
	if (!$phome){$phome=chr(0);}
	$pwork = $row['phone_work'];
	if (!$pwork){$pwork=chr(0);}
	$pcell = $row['phone_cell'];
	if (!$pcell){$cell=chr(0);}	
	$probationary = $row['probationary'];
	if($probationary)  {$probationary="X";}
		else {$probationary=chr(0);}
print<<<EOT
    <div class="table-row">
        <div class="column index">$unit</div>
        <div class="wrapper attributes">
            <div class="wrapper rank-code">
                <div class="column rank">$rank</div>
                <div class="column code">$code</div>
            </div>
            <div class="wrapper first-last">
                <div class="column first">$fname</div>
                <div class="column last">$lname</div>
            </div>
            <div class="wrapper phone">
                <div class="column cell">$pcell</div>
                <div class="wrapper work-home">     
                    <div class="column home">$phome</div>
    	            <div class="column work">$pwork</div>
        	    </div>
        	</div>
        </div>
    </div>
EOT;
}    
// print("<tr><td class=\"table_cell\">$unit</td><td class=\"table_cell\">$rank</td><td class=\"table_cell\">$name</td><td class=\"table_cell\">$phone_home</td><td class=\"table_cell\">$phone_work</td><td class=\"table_cell\">$phone_cell</td><td class=\"table_cell\" align=center>$probationary</td></tr>\r");
mysql_free_result($result);
?>
</div>
</article>
<!--tr><td colspan="8" align="center">* an "X" in the P column indicates the officer is still in a <b>Probationary</b> period.</td></tr>
</table-->
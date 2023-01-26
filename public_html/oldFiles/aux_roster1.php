<?php
/* Auxiliary Roster
 * Reads the user table, sorts it by Unit Number and displays the information 
 * in a table.
 */
require_once('includes/utilities.inc.php');
if(!$user) {
	
	header("Location:index1.php");
	}
$pageTitle = "Auxiliary Roster1";
include "includes/header.inc.html";
include "includes/menu1.inc.php";
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
                	<div class="column home">Home Phone</div>
 <!--             	<#-- div class="column work">Work Phone</div -->
            	</div>
            </div>
        </div>
    </div>
<?
// try {
/* $user_info = $database->getAllUsers(); */
	$q = "SELECT * FROM users JOIN squad ON users.squad = squad.squad ORDER BY sid, rankNo, unit_num";
	$r = $pdo->query($q);
	$lsquad='';
	/* Check that rows were returned */
	if ($r && $r->rowCount() > 0)  {

	// Set the fetch mode
	
	$r->setFetchMode(PDO::FETCH_CLASS, 'user');
}
while ($row = $r->fetch())
{
	$unit = $row->getBadgeNo();
	$code = $row->getCode();
	$rank = $row->showRank($row->getRankNo());
	$fname = $row->getFname();
	$lname = $row->getLname();
	$phome = $row->getPhHome();
	$pcell = $row->getPhCell();	
	$fsquad = $row->getSquad();
	if (!$phome){$phome=chr(0);}
	if (!$pcell){$cell=chr(0);}	
	if ($lsquad <> $fsquad) {
		print<<<EOT
		<div class="squadrow">$fsquad</div>
		
EOT;
		$lsquad = $fsquad;
		}
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
                <div class="column cell"><a href="tel:+1$pcell">$pcell</a></div>
                <div class="wrapper work-home">     
                    <div class="column home"><a href="tel:$phome">$phome</a></div>
        	    </div>
        	</div>
        </div>
    </div>
EOT;
}    

//mysql_free_result($result);
?>
</div>
</article>
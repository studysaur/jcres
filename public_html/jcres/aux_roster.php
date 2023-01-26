<?php
/* Auxiliary Roster
 * Reads the user table, sorts it by Unit Number and displays the information 
 * in a table.
 */
 
 
 require_once 'includes/utilities1.inc.php';

if (!isset($username)){
	header("Location:../index.php");
	exit();
	} 

$pageTitle = "Reserve Roster";
include 'includes/header.inc.php';
include 'includes/menu.inc.php';
$prob = (\Aux\Entity\User::PROBATION);
// echo $prob . ' is prob';
?>
<article>
<!-- <div class="container-fluid" style="margin-top: 10px"> -->
    <div class="table-row header">
    	<div class="wrapper attributes">
        		<div class="column index">SO#</div>
        	<div class="wrapper rank-code">
            	<div class="column rank">Rank</div>
            	<div class="column code">Code</div>
        	</div>
        </div>
            <div class="wrapper first-last">
                <div class="column first">First Name</div>
                <div class="column last">Last</div>
            </div>
            <div class="wrapper phone">
                    <div class="column cell">Cell Phone</div>
	         <!-- <div class="wrapper work-home"> -->
                	<div class="column home">Home Phone</div>
            <!--    <div class="column work">Work Phone</div> -->
            </div>
    </div>
<!--</div>-->
<?php

$q = "SELECT * FROM user INNER JOIN squads ON user.squad = squads.squad WHERE NOT squads.squad = '' ORDER BY sid, FIELD(user.rank, 'Sheriff', 'Chief', 'Deputy Chief', 'Major', 'Captain', 'Chaplin', 'Lieutenant', 'Sergeant', 'Deputy'), unit_num";
$r = $pdo->query($q);

/* Check for Errors in Reading Table */
if ($r && $r->rowCount() > 0)  {
// echo 'in rowcount';
$lsquad='';
$r->setFetchMode(PDO::FETCH_CLASS, '\stdClass');

while ($user = $r->fetch())
// echo 'fetching';
{
	$squad = $user->squad;
	$unit = $user->unit_num;
	$code = $user->code;
	$rank = $user->rank;
	$fname = $user->f_name;
	$lname = $user->l_name;
	$phone = $user->phone_home;
//	$fsquad = $user->squad;
//	if (!$pwork){$pwork=chr(0);}
	$pcell = $user->phone_cell;
	if (!$pcell){$cell=chr(0);}	
//    $probationary = $user->status & $prob;
//    echo 'probationary is ' . $probationary;
/*	if($probationary)  {$probationary="P";}
		else {$probationary=chr(0);} */
	if ($lsquad <> $squad) {
		print<<<EOT
		<div class="squadrow">$squad</div>
		
EOT;
		$lsquad = $squad;
		}
print<<<EOT
    <div class="table-row">
        <div class="wrapper attributes">
        	<div class="column index">$unit</div>
    	<div class="wrapper rank-code">
                <div class="column rank">$rank</div>
               	<div class="column code">$code</div>
           </div>
        </div>
            <div class="wrapper first-last">
                <div class="column first">$fname</div>
                <div class="column last">$lname</div>
            </div>
            <div class="wrapper phone">
                <div class="column cell"><a href="tel:+1$pcell">$pcell</a></div>
                <div class="column home"><a href="tel:$phone">$phone</a></div>
        	</div>
        </div>

EOT;
}
} else {
	echo 'Query to show fields failed';
}    
?>
</article>
<?php
include 'includes/footer.inc.php';
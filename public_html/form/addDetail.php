<?php // form/addDetail.php
$pageTitle="Add Detail Form";
require_once('../includes/utilities.inc.php');
include '../includes/header.inc.html';
include '../includes/menu1.inc.php';
date_default_timezone_set('America/Chicago');
$dt=date("Y-m-d");
$d = explode("-", $dt);
$year = $d[0];
$month = $d[1];
$day = $d[2];

if (intval($month) < 6 ) {
	$month = $month + 6;
} else {
	$month = $month - 6;
	$len = strlen(strval($month));
	if ($len <2){
	$month = "0".$month;
	}
	$year = $year + 1;
	$endDate = $year . "-" . $month . "-" . $day;
} //end else

?>
<div class="form-row">
	<div class="label"><label for="datetime">Date</label></div>
	<div class="input"><input type="date"  min=<?php echo '"' . $dt. '" max= "' . $endDate.'"'; ?> name="detailDate"  id="detailDate"></div>
</div>
<div class="form-row">
	<div class="label"><label for="detailTtype">Detail Type</label></div> 
	<div class="input"><input type="text" id="detailType" list="dType" name="detailType" placeholder="Detail Type">
	<datalist id="dType">
<?php 
$q= "SELECT typ FROM detailType WHERE 1";
$stm = $pdo->prepare($q);
$stm->execute();
$stm->bindColumn('typ', $typ);
while ($stm->fetch(PDO::FETCH_BOUND)){
$data='<option value="' . $typ . '">';
print $data;
}
?>
	</datalist></div></div>
<div class="form-row">
	<div class="label"><label for ="detailLoc">Detail Location</label></div>
	<div class ="input"><input list="detailLoc" name="detailLoc" placeholder="Detail Location">
	<datalist id="detailLoc">
<?php 
$stm = $pdo->prepare("SELECT location FROM detailLoc WHERE 1");
$stm->execute();
$stm->bindColumn('location', $location);
while($stm->fetch(PDO::FETCH_BOUND)){
	$data='<option value="' . $location .'">';
	print $data;
}
?>
	</datalist>
</div></div>
<div class="form-row">
	<div class="label"><label for="start">Start Time</label></div>
	<div class="input"><input  list="startTime" name="startTime" size="10" placeholder="Start Time??">
	<datalist id="startTime">
	<?PHP
		printHours(16,23);
		printHours(0,15);
	?></datalist></div></div>
<div class="form-row">
	<div class="label"><label for="endTime">End Time</label></div>
	<div class="input"><input list="endTime" size="10" placeholder="End Time ??">
	<datalist id="endTime">
	<?php 
		printHours(20,23);
		printHours(0,19);
	?></datalist></div></div>
<div class="form-row">
	<div class="label"><label for="contact">Contact Person</label></div>
	<div class="input"><input type="text" name="contact" placeholder="Contact Person" size="20"></div>
</div>
<div class="form-row">
	<div class="label"><label for="contactPhone">Contact Phone</label></div>
	<div class="input"><input type="tel" pattern='\d{3}[\-]\d{3}[\-]\d{4}' name="contactPhone" placeholder="###-###-####"></div>
</div>
<div class="form-row">
	<div class="label"><label for="pay">Pay Collect/Pays</label></div>
	<div class="input"><select name="pay" placeholder="pay">
<?php 
$pid=null;
$collect=null;
$pays=null;
$stm = $pdo->prepare("SELECT * FROM pay WHERE 1");
$stm->execute();
$stm->bindColumn('pid', $pid);
$stm->bindColumn('collect', $collect );
$stm->bindColumn('pays', $pays);
while($stm->fetch(PDO::FETCH_BOUND)) {
print <<<EOT
<option value="$pid">$collect/$pays </option>;
EOT;
}
?>
</select></div></div>
	
<div class="form-row">
	<div class="label"><label for="comment">Comments</label></div>
	<div class="input">
        <textarea id="comment" name="comment" placeholder="Write something.." ></textarea>
      </div>
</form>
<?php
function printHours($st, $end) {
while($st <= $end) {
	if ($st < 10) {$st = '0'.$st;}
	print <<<EOT
		<option value="$st:00 hrs">
		<option value="$st:30 hrs">
EOT;
$st++;

    }//end while
}// end function pringHours

function retrieveTable($col, $table){
	$q="SELECT " . $col . " FROM " . $table  . " WHERE 1";
	print $q;
/*	$stm=$pdo->prepare($q);
	$stm->execute();
	$stm->bindColumn($col, $col);
	while($stm->fetch(PDO::FETCH_BOUND)) {
		$data='<option value="' . $col . '">';
		print $data;
	} // end while*/
} // end function retrieveTable()
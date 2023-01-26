<!-- # detail.html -->

<?php
$today = date("Y-m-d");
// echo $_SESSION['username'] . ' is username <br>';
// echo $deputy . ' is the deputy name. <br>'
//<p> found the Details page</p>?>
<table>
    <thead>
        <div class="table-row header">
	        <div class="wrapper date-start-end">
	        	<div class="wrapper date">
	        	    <div class="column date">Date</div>
	        	</div>
	        	<div class="wrapper start-end">
	        		<div class="column start">Start</div>
	        		<div class="column end">End</div>
	        	</div>
	        </div>
	        <div class="wrapper location-type">
	        	<div class="column location">Location</div>
	        	<div class="column type">Type</div>
	        </div>
	        <div class="wrapper pay">Pay</div>
        </div>
    </thead>  
	<tbody> <?php foreach ($details as $detail):?>
        <tr>
            <td><?=$detail->date;?></td>
        	<td><?=$detail->startTime;?></td>
        	<td><?=$detail->endTime;?></td>
        	<td><?=$detail->detailLocation;?></td>
        	<td><?=$detail->detailType;?></td>
        </tr>
    </tbody>
<?php endforeach; ?>
</table>
<?php
/*$signedUp = $detail->getSignedUp();
$numOfficer = $detail->getNumOfficers();
$numSignedUp = 0;
if (array_filter($signedUp)){
	$numSignedUp = count($signedUp);

if ($detail->Date() < $today) {
	$status = "past";
	}/* elseif ($numOfficer == $numSignedUp ) {
	$status = "good";
	}  else {
	$status = "help";
	}
	echo '<div class="tab '.$status .'">
	<input id="' . $detailNum . '" type="checkbox" name="details">
	<label for="' . $detailNum . '">
		<div class="wrapper detail-date-start-end">
			<div class="wrapper date">
				<div class="column date">' . $detail->date . '</div>
			</div>
			<div class="wrapper start-end">
				<div class="column start">' . substr($detail->StartTime, 0 , 5) . '</div>
				<div class="column end">' . substr($detail->getEndTime(), 0, 5) . '</div>
			</div>
		</div>
		<div class="wrapper location-type">
			<div class="column location">' . $detail->detailLocation() . '</div>
			<div class="column type">' . $detail->detailType() . '</div>
		</div>
		<div class="wrapper pay"> ' . $pay . '</div>
	</label>
	<div class="tab-content">' ;
		if($status == "help"){
	 	echo '<div class="vol"><a href="volunteer.php?type=volunteer&detail=' . $detailNum . '&field=0"><img src="images/checkmark.jpg"/></a></div>';
	}
	echo '<div class="wrapper numOfficers">Num Off  ' . $detail->numOfficer . '</div>';
	if ($detail->getContact() !=''){
		echo '<div class="contact">Contact ' . $detail->Contact .' ' .$detail->ContactPh .'</div>';
		}
	if ($numSignedUp > 0) {
		($numSignedUp == 1 ? $dep = "Deputy" : $dep = "Deputies");
		echo '<div class="signedUp">' . $dep .'  ' ;
		for ($i = 0;$i < $numSignedUp;$i++ ){
			echo '<officer>' . $signedUp[$i] . '</officer>   ';
		}
	echo '</div>';
	}

echo '</div></div>';*/
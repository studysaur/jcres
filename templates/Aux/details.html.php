<!-- # detail.html -->

<?php
$today = date("m-d-Y");
$dayname=array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
if(($_SESSION['status'] & \Aux\Entity\User::POST_DETAILS) == \Aux\Entity\User::POST_DETAILS) {
	$post = 1;
} else {
	$post = 0;
}
if(($_SESSION['status'] & \Aux\Entity\User::ADMIN) == \Aux\Entity\User::ADMIN){
	$admin = 1;
} else {
	$admin = 0;
}
//echo \Aux\Entity\User::ADMIN . ' is the admin<br>';
//echo $_SESSION['status'] . ' is the status<br>';
//echo $post . ' is post <br>';
//echo $admin . ' is admin <br>';
//print_r($details);

// echo $_SESSION['username'] . ' is username <br>';
// echo $deputy . ' is the deputy name. <br>'
//<p> found the Details page</p> 
 ?>
<article>
	<ol class="collection collection-container">
		<!-- The first list is the header -->

    	<li class="detail sticky detail-container">
			<div class="attribute" data-name="inv">Inv</div>
			<div class="attribute" data-name="pay">Pay</div>
			<!-- inv-pay -->
				<div class="attribute-container vol-num">
					<div class="attribute" data-name="vol">Vol</div>
					<div class="attribute" data-name="num">Num</div>
				</div> <!-- vol-num -->
			</div>
			<div class="attribute-container time">			
	        	<div class="attribute-container date-day">
	        	    <div class="attribute" data-name="date">Date</div>
					<div class="attribute" data-name="day">Day</div>
	        	</div> <!--day-date -->
	        	<div class="attribute-container start-end">
	        		<div class="attribute" data-name="start">Start</div>
	        		<div class="attribute" data-name="end">End</div>
	        	</div> <!-- start-end -->
	        </div> <!-- time -->
			<div class="attribute-container other-info">
	        	<div class="attribute-container loc-type">
	        		<div class="attribute" data-name="loc">Location</div>
	        		<div class="attribute" data-name="type">Type</div>
	        	</div> <!-- loc-type -->
				<div class="attribute-container cont-phn">
	        		<div class="attribute" data-name="cont">Contact</div>
					<div class="attribute" data-name="phn">phone</div>
				</div> <!-- cont-phn -->
			</div> <!-- other-info -->
			<div class="attribute-container off"> 
				<div class="attribute" data-name="officers">Officers</div>
			</div>	
			<?php if ($admin || $post):?>
			<div class="attribute-container adm-butt">
				<div class="attribute-container edit-post">
					<div class="attribute" data-name="edit">ch</div>
					<div class="attribute" data-name="post">po</div>
				</div> <!-- edit-post -->
			</div> <!-- adm-butt -->
			<?php endif; ?>
		</li><!-- li -->

<?php 
foreach ($details as $detail): 
$daynum = date('w', strtotime($detail->date));
$date = date('j', strtotime($detail->date));
$day = date('D', strtotime($detail->date));
$month = date('M', strtotime($detail->date));
//$day = $dayname[$daynum];
$off = array();
$officer = array($detail->officer_1, 
				 $detail->officer_2,
				 $detail->officer_3,
				 $detail->officer_4, 
				 $detail->officer_5, 
				 $detail->officer_6,
				 $detail->officer_7,
				 $detail->officer_8,
				 $detail->officer_9,
				 $detail->officer_10
				); 
for ($i=0; $i<10; $i++):
if(!empty($officer[$i])):
				$off[] = $officer[$i];
endif;
endfor;
//$vols=$detail->numVols();
$vols = count($off);
$detNum = $detail->detailNum;
if($detail->date<$today):
	$class='past';
elseif($vols < $detail->numOfficers):
	$class='help';
else:
	$class='good';
endif;
//echo $vol . ' is how many signed up';
		//unset($officers);
		//$officers = $detail->aofficers();
?>
	<li class="<?=$class?> detail detail-container">
		<div class="attribute" data-name="Invoice"><?=$detNum;?></div>
		<div class="attribute" data-name="Pay"><?=$detail->paidDetail ? 'Yes' : 'No';?></div>
				<div class="attribute-container vol-num">
					<div class="attribute" data-name="Volunteer"><?= ($class == 'help') ? "<a href=\"volunteer.php?type=volunteer&detail=$detNum&field=$vols\"><img src=\"/images/checkmark.jpg\"/></a>" : '' ?></div>
					<div class="attribute" data-name="# Officers"><?=$vols;?></div>
			</div>
			<div class="attribute-container time">
				<div class="attribute-container date-day">
					<div class="attribute" data-name="Date"><?=$month . ' '.$date;?></div>
					<div class="attribute" data-name="Day"><?=$day;?></div>
				</div>
				<div class="attribute-container start-end">
					<div class="attribute" data-name="Start"><?=substr($detail->startTime, 0, 5);?></div>
					<div class="attribute" data-name="End"><?=substr($detail->endTime, 0, 5);?></div>
				</div>
			</div> <!-- end of time -->
			<div class="attribute-container other-info">
				<div class="attribute-container loc-type">
					<div class="attribute" data-name="Location"><?=$detail->detailLocation;?></div>
					<div class="attribute" data-name="Type"><?=$detail->detailType;?></div>
				</div>
				<div class="attribute-container cont-phn">
					<div class="attribute contact" data-name="Contact"><?=$detail->contact;?></div>
					<div class="attribute contactPh" data-name="Phone #"><?=$detail->contactPh;?></div>
				</div>
			</div>
			<div class="attribute-container off">
				<div class="attribute off" data-name="Officers">
				<?php for($j=0;$j<$vols;$j++):
					echo $off[$j] . '<br>';
				endfor;?></div>
			</div>
			<?php if ($admin || $post):?>
			<div class="attribute-container adm-butt">
				<div class="attribute-container edit-post">
					<div class="attribute" data-name="edit"><?= "<a href=\"volunteer.php?type=volunteer&detail=$detNum\"><img src=\"/images/edit.jpg\"/></a>" ?></div></div>
					<div class="attribute" data-name="post"><?=($class == 'past') ? "<a href=\"volunteer.php?type=enter&detail=$detNum\"><img src=\"/images/post.jpg\"/></a>" : '' ?></div>
				</div> <!-- edit-post -->
			</div> <!-- adm-butt -->
			<?php endif; ?>		
	</li>
<?php endforeach; ?>
 
	</ol>
</article>
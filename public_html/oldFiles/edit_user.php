<?php

	require_once '../jcres_connect.php';
	
	require_once 'lib/startsession.php';
	
	$page_title = 'Edit User';
	/*
	 * This function writes this pages content to the stream
	 */
	if(isLoggedIn()){
	//    echo '<p> we are logged in</p>';
	} else {
	//    echo '<p>not logged in</p>';
	    $errormessage='not logged in';
	    exit();
	}    
	    
	if (!isset($_SESSION['user_id'])){
	    echo '<p> Apparently we have no session </p>';
	    $errormessage='Session not active you must login';
	    exit();
	} else {
	$user_id = $_SESSION['user_id'];
	//    echo "<p> SESSION user_id is $user_id] </p>";
	    $edit_id = $_GET['id'];
	//    echo "<p> passed id = $edit_id </p>";
	    
	}
	function jcres_content() {
    global $_GET, $_POST;
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))){ // from list users.php
    $id= $_GET['id'];
    $_SESSION['edit_id'] = $id;
//    echo "<p> id = $id</p>";
//    echo "<p> SESSION edit_id = $_SESSION['id'] </p>";
    $q= "SELECT first_name, middle_name, last_name, division, badge_no, unit_no, rank, status, userid FROM users WHERE id=$id";
    $r= db_query($q);
    if (mysqli_num_rows($r) == 1) { //Valid user id show the form
//       echo "<p> the query ran </p>";
        $row = mysqli_fetch_row($r);
        $fname = $row[0];
        $mname = $row[1];
        $lname = $row[2];
        $division = $row[3];
        $badge_no = $row[4];
        $unit_no = $row[5];
        $rank = $row[6];
        $status = $row[7];
    } //end if num_rows*/
    } elseif ( (isset($_SESSION['edit_id'])) /*&& (is_numeric($_POST['id']))*/ ){
    $id= $_SESSION['edit_id'];
    } else { // no valid id, kill the script
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
    }// end else
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 	if(empty($_POST["fname"])){
		$fnameErr = "First name is required";
		$errors[] = 'First name missing';
	} else {
		$fname = test_input($_POST["fname"]);  // check name only has letters and whitespace
		if(!preg_match("/^[a-zA-Z]*$/",$fname)){
			$fnameErr = "Only letters and white space allowed";
			$fname="";
			$errors[] = 'Only letters and white space allowed';
			}
	} //end if(empty first
	
 	if(empty($_POST["mname"])){
		$mnameWarn = "Middle name is highly recommended";
	} else {
		$mname = test_input($_POST["mname"]);  // check name only has letters and whitespace
		if(!preg_match("/^[a-zA-Z]*$/",$mname)){
			$mnameErr = "Only letters and white space allowed";
			$mname="";
			$errors[] = 'Only letters and white space allowed in middle name';
		}
	}// end if(empty middle 	    
	 if(empty($_POST["lname"])){
		$lnameErr = "Last name is required";
		$errors[] = 'Last name required';
	} else {
		$lname = test_input($_POST["lname"]);  // check name only has letters and whitespace
		if(!preg_match("/^[a-zA-Z]*$/",$lname)){
			$lnameErr = "Only letters and white space allowed";
			$lname="";
			$errors[] = 'Only letters and white space allowed last name';
		}
	} // end if(empty($lname
	$division = $_POST["division"];
	$rank = $_POST["rank"];
	$badge_no = $_POST["badge"];
	$unit_no = $_POST["unit"];
	if($_POST["ini"]){
	    $status = $status | 1;
	}
	if($_POST["pro"]){
	    $status = $status | 2;
	}
	if($_POST["aca"]){
	    $status = $status | 4;
	}
	if($_POST["fto"]){
	    $status = $status | 8;
	}
	if($_POST["edt"]){
	    $status = $status | 16;
	}
	if($_POST["cdt"]){
	    $status = $status | 32;
	}
	if($_POST["etr"]){
	    $status = $status | 64;
	}
	if($_POST["ctr"]){
	    $status = $status | 128;
	}
	if($_POST["adu"]){
	    $status = $status | 256;
	}
	if($_POST["edu"]){
	    $status = $status | 512;
	}
	if($_POST["dtu"]){
	    $status = $status | 1024;
	}
} //end if ($server
if (empty($errors) and (!empty($_POST[fname]))) {//every thing should be good
    $q="UPDATE users SET last_name='$lname', first_name='$fname', middle_name='$mname', division='$division', badge_no='$badge_no', unit_no='$unit_no', rank='$rank' WHERE id=$id";
    $r=db_query($q);
    if($r) {//appears it ran
        echo "<p> $rank $lname record updated </p>";
    } //end if $r
}// end if empty
?>
		<div class="main-content">
<form action="edit_user.php" method="post">
    <fieldset>
        <legend>Edit Officer</legend>
            First Name: <input type="text" name="fname" size="15" maxlength="30" value="<?php echo $fname;?>"> <span class="error"> * <?php echo $fnameErr ?></span><br />

            Middle Name: <input type="text" name="mname" size="15" maxlength="30" value="<?php echo $mname;?>"> <span class="error"> * <?php echo $mnameErr . $mnameWarn?></span><br />

            Last Name: <input type="text" name="lname" size="15" maxlength="30" value="<?php echo $lname;?>"> <span class="error"> * <?php echo $lnameErr ?></span><br />

    <?php
        $query = "SELECT division_no, division_name FROM division";
        $result = db_query($query);
	?>
		<label for="division">Division</label>
		<select name="division">;

    <?php 
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            $dno=$row["division_name"];  // allows us to use the value without ""
                if ($dno == $division){
                print<<<EOT
                <option value="$dno" selected>$dno</option>

EOT;
                } else {
                print<<<EOT
                <option value="$dno"> $dno</option>
                
EOT;
                }// end if
             } //end while
        } else {
            echo "0 results";
        } // end else  next lines finish the select box and start the rank box 
             
            print<<<EOT
            </select> <br />
            <label for="rank">Rank</label>
            <select name= "rank">

EOT;
        // set up rank drop down box
        $query = "SELECT rank_no,rank FROM rank";
        $result = db_query($query);
        if(mysqli_num_rows($result) > 0) { // make sure we have results
            while($row = mysqli_fetch_assoc($result)) {
            $rnk=$row["rank"];
                if($rnk == $rank){
                print<<<EOT
                <option value="$rnk" selected> $rnk</option>

EOT;
                } else {
                print<<<EOT
                <option value="$rnk"> $rnk</option>

EOT;
                } //end if
            } // endwhile
        } //end if
   ?>
    </select><br />
            Badge Number: <input type="text" name ="badge" size="4" maxlength="4" value="<?php echo $badge_no;?>"/><br />
            Unit Number: <input type="text" name ="unit" size="4" maxlength="4" value="<?php echo $unit_no;?>"/><br />
            
        <input type="checkbox" name="ini" value="1" <?php if($status & 1){echo 'checked';}?> />Initial Training
        <input type="checkbox" name="pro" value="2" <?php if($status & 2){echo 'checked';}?> />Probation
        <input type="checkbox" name="aca" value="4" <?php if($status & 4){echo 'checked';}?> />Academy
        <input type="checkbox" name="fto" value="8" <?php if($status & 8){echo 'checked';}?> />FTO<br />
        <input type="checkbox" name="edt" value="16" <?php if($status & 16){echo 'checked';}?> />Edit Detail
        <input type="checkbox" name="cdt" value="32" <?php if($status & 32){echo 'checked';}?> />Create Detail
        <input type="checkbox" name="etr" value="64"<?php if($status & 64){echo 'checked';}?> />Edit Training
        <input type="checkbox" name="ctr" value="128"<?php if($status & 128){echo 'checked';}?> />Create Training<br />
        <input type="checkbox" name="adu" value="256"<?php if($status & 256){echo 'checked';}?> />Add user
        <input type="checkbox" name="edu" value="512"<?php if($status & 512){echo 'checked';}?> />Edit user
        <input type="checkbox" name="dtu" value="1024"<?php if($status & 1024){echo 'checked';}?> />Delete user<br />
        <input type="submit" name="submit" value="Submit" />
    </fieldset>
		</div>
<?php
}// end function	

	// Now that the function jcres_content has been defined, call the main_template.php
	// Since main_template.php calls jcres_content, the function must be defined first.
	require_once 'lib/main_template.php';

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream
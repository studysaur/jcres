<?php   // jcres.us/new_user.php


	require_once('lib/user.php');
	require_once('lib/startsession.php');
	require_once '../jcres_connect.php';
//	require_once('lib/user_form.php');
	/*
	 * This function writes this pages content to the stream
	 */
	 if (isDatabaseConnected()) {
	 $connected="yes";
	 }
$fnameErr = $mnameErr = $lnameErr = $mnameWarn = $bdnoErr = $unoErr = ""; // initialze error strings
$fname = $mname = $lname = $div =$rnk = $userid = ""; // initialze field strings
$stat = $uno = 0;
	function jcres_content() {
    global $_GET, $_POST;
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
	$dv = $_POST["division"];
	$rk = $_POST["rank"];
	$bdno = $_POST["badge"];
	$uno = $_POST["unit"];
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
} //end if ($server

if (strlen($fname) > 0 && strlen($lname) > 0){
        $userid = $fname . "_" . $lname;
    }
if (strlen($userid) >0 && strlen($mnameErr) <1) {
    $query = "SELECT userid FROM users WHERE userid = '$userid'";
    if ($result = db_query($query)){
        if ($row = mysqli_fetch_row($result)) {
            echo "<p> user already exist in database</p>";
            $errors[] = 'User already exist';
        } //end if row
    }//end if results
            
    } else {
    echo "<p> either username was 0 or there was an error</p>";
    }
$q = "INSERT INTO users (first_name, middle_name, last_name, userid, division, badge_no, unit_no, rank, status, password) VALUES ('$fname', '$mname', '$lname', '$userid', '$dv', '$bdno', '$uno', '$rk', '$status', SHA1('password'))";

if (empty($errors) and (!empty($_POST[fname]))) { // Everything should be ok
    $r = db_query($q);
//echo "<p> it appears it wants to post no errors</p>";
    if ($r) { // it ran so print a message
    echo "<p>User name $userid added</p>";
    } else { // things didn't go well we have errors
    echo "<p> it appears we have errors</p>";
    }// end if ($r)
}// end if(empty)
?>
		<div class="main-content">
<form action="new_user.php" method="post">
    <fieldset>
        <legend>New Officer</legend>
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
            $div=$row["division_name"];
            print<<<EOT
            <option value="$dno"> $dno</option>

EOT;
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
          //  echo $rnk;
            print<<<EOT
            <option value="$rnk"> $rnk</option>

EOT;
            } // endwhile
        } //end if
   ?>
    </select><br />
            Badge Number: <input type="text" name ="badge" size="4" maxlength="4" value='399'/><br />
            Unit Number: <input type="text" name ="unit" size="4" maxlength="4" value="<?php echo $uno;?>"/><br />
            
        <input type="checkbox" name="ini" value="1" />Initial Training
        <input type="checkbox" name="pro" value="2" />Probation<br />
        <input type="checkbox" name="aca" value="4" />Academy
        <input type="checkbox" name="fto" value="8" />FTO<br />
        <input type="submit" name="submit" value="Submit" />
    </fieldset>
	
		
<?php
 /*/Display variables for trouble shooting
 echo "<h2> Input </h2>";
 echo "<p>first name = $fname</p>";
 echo "<p>middle name = $mname</p>"; 
 echo "<p>last name = $lname</p>";
echo "<p>user name = $userid</p>";
echo "<p>division = $dv</p>"; 
echo "<p>rank = $rk</p>";
echo "<p>badge no = $bdno</p>";
echo "<p>unit no = $uno</p>";
echo "<p>status = $status</p>";
echo "<p>fnameerror = $fnameErr</p>";
echo "<p>lnameerror = $lnameErr</p>";


*/
	}  //end jcres_content()

	// Now that the function jcres_content has been defined, call the main_template.php
	// Since main_template.php calls jcres_content, the function must be defined first.
	require_once 'lib/main_template.php';

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream
<?php // lib/user_form.php
/*prints user form*/
function user_form() {
<form action="new_user.php" method="post">
    <fieldset>
        <legend>New Officer</legend>
            First Name: <input type="text" name="fname" size="15" maxlength="30" value="<?php echo $fname;?>"> <span class="error"> * <?php echo $fnameErr ?></span><br />

            Middle Name: <input type="text" name="mname" size="15" maxlength="30" value="<?php echo $mname;?>"> <span class="error"> * <?php echo $mnameErr ?></span><br />

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
            $dno=$row["division_no"];  // allows us to use the value without ""
            $div=$row["division_name"];
            print<<<EOT
            <option value=$dno> $div</option>

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
            $no=$row["rank_no"];
          //  echo $rnk;
            print<<<EOT
            <option value=$no> $rnk</option>

EOT;
            } // endwhile
        }
   ?>
    </select><br />
            Badge Number: <input type="text" badge="badge_no" size="4" maxlength="4" value="<?php echo $bdno;?>"/><br />
            Unit Number: <input type="text" unit="unit_no" size="4" maxlength="4" value="<?php echo $uno;?>"/><br />
            
        <input type="checkbox" name="status" value="initial" />Initial Training
        <input type="checkbox" name="status" value="prob" />Probation<br />
        <input type="checkbox" name="status" value="academy" />Academy
        <input type="checkbox" name="status" value="fto" />FTO<br />
        <input type="checkbox" name="status" value="edit_det" />Edit Detail
        <input type="checkbox" name="status" value="create_det" />Create Detail<br />
        <input type="checkbox" name="status" value="edit_trn" />Edit Training
        <input type="checkbox" name="status" value="create_trn" />Create Training
        <imput type="submit" name="submit" value="Submit">
    </fieldset>
    }
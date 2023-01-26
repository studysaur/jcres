<?php
	require_once("user.php");
	/* This function writes this pages content to the stream */
	function jcres_content() {
	    global $errorMessage, $_GET;
	    
	    $post = 1;
	    $canEdit = 1;
?>
        <div class=”main-content”>
<?php
// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = array(); // initialize and error array.
    
    // Check for a first name:
    if(empty($_POST['first_name'])) {   
        $errors[] = 'You forgot to enter a first name.';
    } else {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    }
    
        // Check for a last name:
    if(empty($_POST['last_name'])) {   
        $errors[] = 'You forgot to enter a last name.';
    } else {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    }   
    
       // Check for a division:
    if(empty($_POST['division'])) {   
        $errors[] = 'You forgot to enter a division.';
    } else {
        $dv = mysqli_real_escape_string($dbc, trim($_POST['division']));
    } 
    
       // Check for a badge number:
    if(empty($_POST['badge_no'])) {   
        $errors[] = 'You forgot to enter a badge number.';
    } else {
        $bn = mysqli_real_escape_string($dbc, trim($_POST['badge_no']));
    }  
    $pro = 
    
       // Check for a hire date:
    if(empty($_POST['hire_date'])) {   
        $errors[] = 'You forgot to enter a division.';
    } else {
        $hd = mysqli_real_escape_string($dbc, trim($_POST['hire_date']));
    }
    if(empty($errors)) { // if every thing is ok
    
        // Register the user in the database
        
        // Make the query
        $q = "INSERT INTO users (reserve_no, first_name, middel_name, last_name, password, userid, userlevel, division, badge_no, rank, probatinary, hire_date) VALUES($rn, $fn, $mn, $ln, SHA1('password'), ucwords($fn)'_'ucwords($ln), 0, $div, $bn, $pro, $hd)";
        $r = @mysqli_query ($dbc, $q); // run the query
        
        if ($r) { // if it runs ok print a message
        
        echo '<h1>Registered' $fn $ln '</h1>';
        } else { // something went wrong
        echo '<h1>System Error</h1>';
        // debugging message:
        echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';
        } // end of if($r)
        // include the footer and quit the script
        include ('include/footer.php');
        exit();
    } else { // report errors in form
    
    echo '<h1>Error!</h1><p class="error">The following error(s) occurred:<br />';
        foreach($errors as $msg) { //Print each error
            echo " - $msg<br />\n";
        }
        echo '<p>Please try again</p><p><br />';
        
    } //End of if empty($error);
} // End of the main Submit conditional

?>
<h1>Register</h1>
<form action=”new_user.php” method=”post”>
    <p>First Name: <input type=”text” name=”first_name” size=”15” maxlength=”30” value=<?php if(isset($_POST[‘first_name’])) echo $_POST[‘first_name’]; ?> /></p>
    
    <p>Middle Name: <input type=”text” name=”middle_name” size=”15” maxlength=”30” value=<?php if(isset($_POST[‘middle_name’])) echo $_POST[‘middle_name’]; ?> /></p> 
       
    <p>Last Name: <input type=”text” name=”last_name” size=”15” maxlength=”30” value= <?php if(isset($_POST[‘last_name’])) echo $_POST[‘last_name’]; ?> /></p>
    
    <p>Auxillary No: <input type=”text” name=”Auxillary” size=”15” maxlength=”15” value= <?php if(isset($_POST[‘aux_no’])) echo $_POST[‘aux_no’]; ?> /></p>
     
    <p>Division: <input type=”text” name=”division” size=”15” maxlength=”30” value= <?php if(isset($_POST[‘division’])) echo $_POST[‘division’]; ?> /></p> 
    
    <p>Badge No: <input type=”text” name=”badge_no” size=”4” maxlength=”4” value= <?php if(isset($_POST[‘badge_no’])) echo $_POST[‘badge_no’]; ?> /></p>
      
    <p>Rank: <input type=”text” name=”rank size=”10” maxlength=”15” value= <?php if(isset($_POST[‘rank’])) echo $_POST[‘rank’]; ?> /></p> 
     
    <p>Hire Date: <input type=”date” name=”hire_date” size=”8” maxlength=”8” value= <?php if(isset($_POST[‘hire_no’])) echo $_POST[‘hire_no’]; ?> /></p> 

<?php
    require_once 'lib/main_template.php';
    
    // Note: Don't ent the php tag, it will ensure no stray characters are written to the stream
    
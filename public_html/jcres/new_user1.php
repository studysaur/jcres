<?php
require_once('includes/utilities.inc.php');

if (session_status() !== SESSION_STATUS_ACTIVE  && FALSE){
	header("location:index1.php");
	exit;
} 
$pageTitle = 'New User ';
include 'includes/header.inc.php';

ini_set("include_path", '/home/studysaurs/php:' . ini_get("include_path") );
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('newuser');

// add the First name field 
$fName = $form->addElement('text', 'fName');
$fName->setLabel('First Name');
$fName->addFilter('trim');
$fName->addRule('required', 'Please Enter a First Name');

// add middle name field not required
$mName =$form->addElement('text', 'mName');
$mName->setLabel('Middle Name');
$mName->addFilter('trim');

// add Last name field 
$lName = $form->addElement('text', 'lName');
$lName->setLabel('Last Name');
$lName->addFilter('trim');
$lName->addRule('required', 'Please Enter a Last Name');

$badge = $form->addElement(); ?>

<h1>Register</h1>
<form action="new_user.php" method="post">
    <p>First Name: <input type="text" name="first_name" size="15" maxlength="30" value=<?php if(isset($_POST['first_name'])) echo htmlentities($_POST['first_name']); ?> /></p>
    
    <p>Middle Name: <input type="text" name="middle_name" size="15" maxlength="30" value=<?php if(isset($_POST['middle_name'])) echo $_POST['middle_name']; ?> /></p> 
       
    <p>Last Name: <input type="text" name="last_name" size="15" maxlength="30" value= <?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?> /></p>
    
    <p>Auxillary No: <input type="text" name="Auxillary" size="15" maxlength="15" value= <?php if(isset($_POST['aux_no'])) echo $_POST['aux_no']; ?> /></p>
     
    <p>Division: <input type="text" name="division" size="15" maxlength="30" value= <?php if(isset($_POST['division'])) echo $_POST['division']; ?> /></p> 
    
    <p>Badge No: <input type="text" name="badge_no" size="4" maxlength="4" value= <?php if(isset($_POST['badge_no'])) echo $_POST['badge_no']; ?> /></p>
      
    <p>Rank: <input type="text" name="rank size="10" maxlength="15" value= <?php if(isset($_POST['rank'])) echo $_POST['rank']; ?> /></p> 
     
    <p>Hire Date: <input type="date" name="hire_date" size="8" maxlength="8" value= <?php if(isset($_POST['hire_no'])) echo $_POST['hire_no']; ?> /></p> 

    </div>
<?php
 //this ends the jcres main_content()
    require_once 'lib/main_template.php';
    
    // Note: Don't endho the php tag, it will ensure no stray characters are written to the stream
    
<?
/**
 * Process.php
 * 
 * The Process class is meant to simplify the task of processing
 * user submitted forms, redirecting the user to the correct
 * pages if errors are found, or if form is successful, either
 * way. Also handles the logout procedure.
 *
 */
include("include/session.php");

class Process
{
   /* Class constructor */
   function Process(){
      global $session;
      /* User submitted login form */
      if(isset($_POST['sublogin'])){
         $this->procLogin();
      }
      /* User submitted registration form */
      else if(isset($_POST['subjoin'])){
         $this->procRegister();
      }

      /* Admin submitted update user form */
      else if(isset($_POST['subAdminEditUser'])){
         $this->procAdminEditUser();
      }

      /* User submitted forgot password form */
      else if(isset($_POST['subforgot'])){
         $this->procForgotPass();
      }
      /* User submitted edit account form */
      else if(isset($_POST['subedit'])){
         $this->procEditAccount();
      }
	  
      /* User submitted change password form */
      else if(isset($_POST['subpass'])){
        $this->procChangePass();
	 }
	  	  
      /* User submitted request to delete a detail */
      else if(isset($_POST['subdeletedetail'])){
	$this->procDeleteDetail();
	}

      /* User submitted Add Detail form */
      else if(isset($_POST['subdetail'])){
        $this->procAddDetail();
	}

	/* User submitted Add Weapon form */
	else if(isset($_POST['subWeapon']))	{
	$this->procAddWeapon();
	}

	/* User submitted Add Deadly Force request */
	else if(isset($_POST['addDeadlyForce']))	{
	$this->procAddDeadlyForce();
	}

	/* User submitted Edit Detail form  */
	else if(isset($_POST['subeditdetail']))	{
	$this->procEditDetail();
	}

      /**
       * The only other reason user should be directed here
       * is if he wants to logout, which means user is
       * logged in currently.
       */
      else if($session->logged_in){
         $this->procLogout();
      }
      /**
       * Should not get here, which means user is viewing this page
       * by mistake and therefore is redirected.
       */
       else{
          header("Location: index.php");
       }
   }

   /**
    * procLogin - Processes the user submitted login form, if errors
    * are found, the user is redirected to correct the information,
    * if not, the user is effectively logged in to the system.
    */
   function procLogin(){
      global $session, $form;
      /* Login attempt */
      $retval = $session->login($_POST['user'], $_POST['pass']);
      
      /* Login successful */
      if($retval == 1){
		         header("Location: ".$session->referrer);  
		}
      
      /* Password Changed */
      else if($retval == 3) {
	}
	
      /* Login failed */
      else {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
   }
   
   /**
    * procLogout - Simply attempts to log the user out of the system
    * given that there is no logout form to process.
    */
   function procLogout(){
      global $session;
      $session->logout();
      header("Location: index.php");
   }

    /**
    * procRegister - Processes the user submitted registration form,
    * if errors are found, the user is redirected to correct the
    * information, if not, the user is effectively registered with
    * the system and an email is (optionally) sent to the newly
    * created user.
    */
   function procRegister(){
      global $session, $form;
      /* Convert username to all lowercase (by option) */
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }

      /* Registration attempt */
      $retval = $session->register($_POST['username'], $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['userlevel'], $_POST['unit_num'], $_POST['rankno'], $_POST['phone_cell']);
      
      /* Registration Successful */
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         header("Location: ".$session->referrer);
      }
      /* Error found with form */
      else if($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      /* Registration attempt failed */
        else if($retval == 2){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
         header("Location: ".$session->referrer);
      } 
   }

    /**
    * procAdminEditUser - Processes the administrator submitted update
    * user request, if errors are found, the user is redirected to correct the
    * information, if not, the user account is effectively updated with
    * the system.
    */
   function procAdminEditUser(){
      global $session, $form;

      /* Update User Attempt attempt */
      $retval = $session->AdminEditUser($_POST['user'], $_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['userlevel'], $_POST['unit_num'], $_POST['rank'], $_POST['code'], $_POST['squad'], $_POST['phone_home'], $_POST['phone_work'], $_POST['phone_cell'], $_POST['probation'], $_POST['uid']);
  
      /* Update User Successful */
      if($retval == 0){
      	echo "<p>updated</>";
         $_SESSION['nameupdated'] = $_POST['user'];
         $_SESSION['updatesuccess'] = true;
         header("Location: ".$session->referrer);
      }
      /* Error found with form */
      else if($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
      /* Registration attempt failed */
      else if($retval == 2){
         $_SESSION['nameupdated'] = $_POST['user'];
         $_SESSION['updatesuccess'] = false;
         header("Location: ".$session->referrer);
      }
   }



   /**
    * procDeleteDetail - checks to see if the user 
    * really wants to delete a particular detail
    * and deletes it if so or returns to the 
    * Unit Details page if not.
    */
    function procDeleteDetail(){
	global $database;

    if(!$_POST['answer'])	{
		header("Location: unit_details.php"); }
	else {
		$selection = explode(",",$_POST['subdeletedetail']);
		$detail = $selection[0];
		$q = "DELETE FROM ".TBL_DETAILS." WHERE detailNum = 
'$detail'";
		$result = $database->query($q);
		header("Location: unit_details.php"); }
}


   /**
    * procAddDetail - Adds a detail to the 
    * detail table.
    */
    function procAddDetail(){
	global $database, $form;

    /* Determine if the detail is paid or not */
 /*   if(!$_POST['paid']) {
		$paid_detail = '0' ; 
	}
	else {
		$paid_detail = '1' ; } */

    /* Attempt to add the record */
   $retval = $database->addNewDetail($_POST['calendar'], $_POST['detail_type'], 
$_POST['detail_location'], $_POST['start_time'], $_POST['end_time'], $_POST['contact'], 
$_POST['num_officers'], $_POST['officer_1'], $_POST['officer_2'], $_POST['officer_3'], 
$_POST['officer_4'], $_POST['officer_5'], $_POST['officer_6'], $_POST['officer_7'], 
$_POST['officer_8'], $_POST['officer_9'], $_POST['officer_10'], $_POST['paid']);

   /* Detail Successfuly added */
   if($retval)	{
		header("Location: unit_details.php"); }
	else {
		echo "There was a problem inserting the record.<br?>";
		echo "Please try again later.<br/>";
		echo "Click [<a href=\"unit_details.php\">here</a>] to go back to the Unit Details 
page.";
	}
}

/**
 * procEditDetail - this function takes the current information for a 
 * particular detail and updates the database record for that detail.
 */
 
function procEditDetail(){
	global $database, $form;

    /* Determine if the detail is paid or not */
    if($_POST['paid'] == '1') {
		$paid_detail = '1' ; 
	}
	else {
		$paid_detail = '0' ; }
$detail_num = $_POST['subeditdetail'];

    /* Attempt to add the record  */
    $retval = $database->updateEditDetail($_POST['date'], $_POST['detail_type'], 
$_POST['detail_location'], $_POST['start_time'], $_POST['end_time'], $_POST['contact'], 
$_POST['num_officers'], $_POST['officer_1'], $_POST['officer_2'], $_POST['officer_3'], 
$_POST['officer_4'], $_POST['officer_5'], $_POST['officer_6'], $_POST['officer_7'], 
$_POST['officer_8'], $_POST['officer_9'], $_POST['officer_10'], $_POST['paid'],$detail_num);

   /* Detail Successfuly updated */
   if($retval)	{
		header("Location: unit_details.php"); }
	else {
		echo "There was a problem inserting the record.<br?>";
		echo "Please try again later.<br/>";
		echo "Click [<a href=\"unit_details.php\">here</a>] to go back to the Unit Details 
page.";
	}
}

   /**
    * procChangePass - Attempts to change the users password
    * when the current password is the default password.
    */
    function procChangePass(){
		global $session, $form;
		/* Call the changePass function in session.php to do error checking */
		$retval=$session->changePass($_POST['curpass'], $_POST['newpass']);
      
	    /* Change Password successful */
		if($retval){
			$_SESSION['changepass'] = true;
			$retval = $session->logout();
			header("Location: main.php");
			}
			/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: ".$session->referrer);
			}
	}
			
   /**
    * procEditAccount - Attempts to edit the user's account
    * information, including the password, which must be verified
    * before a change is made.
    */
   function procEditAccount(){
      global $session, $form;
      /* Account edit attempt */
      $retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['phone_home'], $_POST['phone_work'], $_POST['phone_cell'], $_POST['cellcarrier'], $_POST['email']);

      /* Account edit successful */
      if($retval){
         $_SESSION['useredit'] = true;
         header("Location: ".$session->referrer);
      }
      /* Error found with form */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
   }
}

/* Initialize process */
$process = new Process;

?>

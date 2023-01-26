<?
/**
 * Session.php
 * 
 * The Session class is meant to simplify the task of keeping
 * track of logged in users and also guests.
 *
 */
include("database.php");
include("mailer.php");
include("form.php");

class Session
{
   var $username;     //Username given on sign-up
   var $userid;       //Random value generated on current login
   var $userlevel;    //The level to which the user pertains
   var $time;         //Time user was last active (page loaded)
   var $logged_in;    //True if user is logged in, false otherwise
   var $userinfo = array();  //The array holding all user info
   var $url;          //The page url current being viewed
   var $referrer;     //Last recorded site page viewed
   var $status;		  //The user status 
   var $l_name;		  //set the lastname
   var $f_name;		  //set the firstnam
   var $usid;
   /**
    * Note: referrer should really only be considered the actual
    * page referrer in process.php, any other time it may be
    * inaccurate.
    */

   /* Class constructor */
   function Session(){
      $this->time = time();
      $this->startSession();
   }

   /**
    * startSession - Performs all the actions necessary to 
    * initialize this session object. Tries to determine if the
    * the user has logged in already, and sets the variables 
    * accordingly. Also takes advantage of this page load to
    * update the active visitors tables.
    */
   function startSession(){
      global $database;  //The database connection
      session_start();   //Tell PHP to start the session

      /* Determine if user is logged in */
      $this->logged_in = $this->checkLogin();

      /**
       * Set guest value to users not logged in, and update
       * active guests table accordingly.
       */
      if(!$this->logged_in){
         $this->username = $_SESSION['username'] = GUEST_NAME;
         $this->userlevel = GUEST_LEVEL;
         $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      }
      /* Update users last active timestamp */
      else{
         $database->addActiveUser($this->username, $this->time, $this->usid);
      }
      
      /* Remove inactive visitors from database */
      $database->removeInactiveUsers();
      $database->removeInactiveGuests();
      
      /* Set referrer page */
      if(isset($_SESSION['url'])){
         $this->referrer = $_SESSION['url'];
      }else{
         $this->referrer = "/";
      }

      /* Set current url */
      $this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
   }

   /**
    * checkLogin - Checks if the user has already previously
    * logged in, and a session with the user has already been
    * established. Also checks to see if user has been remembered.
    * If so, the database is queried to make sure of the user's 
    * authenticity. Returns true if the user has logged in.
    */
   function checkLogin(){
      global $database;  //The database connection

      /* Username and userid have been set and not guest */
      if(isset($_SESSION['username'])) {
         /* Confirm that username and userid are valid */
         if($database->confirmUserID($_SESSION['username'], $_SESSION['userid'])) {
            /* Variables are incorrect, user not logged in */
            unset($_SESSION['username']);
            unset($_SESSION['userid']);
            return false;
         }

         /* User is logged in, set class variables */
         $this->userinfo  	= $database->getUserInfo($_SESSION['username']);
         $this->username  	= $this->userinfo['username'];
         $this->userid    	= $this->userinfo['userid'];
         $this->userlevel 	= $this->userinfo['userlevel'];
         $this->status    = $this->userinfo['status'];
         $this->f_name 		= $this->userinfo['f_name'];
         $this->l_name		= $this->userinfo['l_name'];
         $this->usid		= $this->userinfo['uid'];
       //  $this->status		= $this->userinfo['status'];
 
         return true;
      }
      /* User not logged in */
      else{
         return false;
      }
   }

   /**
    * login - The user has submitted his username and password
    * through the login form, this function checks the authenticity
    * of that information in the database and creates the session.
    * Effectively logging in the user if all goes well.
    */
   function login($subuser, $subpass){
      global $database, $form;  //The database and form object

      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "* Username not entered");
      }
      else{
         /* Check if username is not alphanumeric */
         if(!preg_match("/^[0-9a-z_]+$/i", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }
      }

      /* Password error checking */
      $field = "pass";  //Use field name for password
      if(!$subpass){
         $form->setError($field, "* Password not entered");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }

      /* Checks that username is in database and password is correct */
      $subuser = stripslashes($subuser);
      $result = $database->confirmUserPass($subuser, md5($subpass));

      /* Check error codes */
      if($result == 1){
         $field = "user";
         $form->setError($field, "* Username not found");
      }
      else if($result == 2){
         $field = "pass";
         $form->setError($field, "* Invalid password");
      }

      /* Return if form errors exist */
      if($form->num_errors > 0){
		  $date = date ('m M Y G:i:s');
		  $user_ip = $_SERVER['REMOTE_ADDR']; 
		  $return = $database->failed_login($date, $user_ip, $subuser, $subpass);
		return 4;
      }

      /* Username and password correct, register session variables */
      $this->userinfo  = $database->getUserInfo($subuser);
      $this->usid 	   = $_SESSION['usid']      = $this->userinfo['uid'];
      $this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid    = $_SESSION['userid']   = $this->generateRandID();
      $this->usename   = $_SESSION['usename']= $this->userinfo['f_name'] .',' . $this->userinfo['l_name'];
      $this->userlevel = $this->userinfo['userlevel'];

     /* Insert userid into database and update active users table */
      $database->updateUserField($this->username, "userid", $this->userid);
      $database->addActiveUser($this->username, $this->time, $this->usid);
      $database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

	if ($result == 3) {
		echo "<h1>$this->username you must change your password before you continue!!</h1>";
		echo "<h2>To change your password, click " ."<a href=\"changepassword.php\">here</a></h2>";
		return 3;
		}

      /* Login completed successfully */
      return 1;
   }

   /**
    * logout - Gets called when the user wants to be logged out of the
    * website. It deletes any cookies that were stored on the users
    * computer as a result of him wanting to be remembered, and also
    * unsets session variables and demotes his user level to guest.
    */
   function logout(){
      global $database;  //The database connection

      /* Unset PHP session variables */
      unset($_SESSION['username']);
      unset($_SESSION['userid']);

      /* Reflect fact that user has logged out */
      $this->logged_in = false;
      
      /**
       * Remove from active users table and add to
       * active guests tables.
       */
      $database->removeActiveUser($this->username);
      $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      
      session_unset();
      session_destroy();
      /* Set user level to guest 
      $this->username  = GUEST_NAME;
      $this->userlevel = GUEST_LEVEL;*/
   }

/**
    * register - Gets called when the user has just submitted the
    * registration form. Determines if there were any errors with
    * the entry fields, if so, it records the errors and returns
    * 1. If no errors were found, it registers the new user and
    * returns 0. Returns 2 if registration failed.
    */
   function register($subuser, $subfname, $submname, $sublname, $subuserlevel, $subunit_num, $rankno, $subphone_cell) {
      global $database, $form, $mailer;  //The database, form and mailer object
		$rankname = array(" ", "Sheriff", "Chief", "Deputy Chief", "Chaplin", "Major", "Captain", "Lieutenant", "Sergeant", "Corporal", "Investigator", "Deputy");
		$rank = $rankname[$rankno];
		$rankno = intval($rankno);
		$field = "lname";  //use field name for last name
		if(!$sublname || strlen($sublname = trim($sublname)) == 0){	
			$form->setError($field, "* Last name not entered");
		} 
		
		$field = "fname";  // use field name for fisrt name
		if(!$subfname || strlen($subfname = trim($subfname)) == 0){
			$form->setError($field, "* Fist name not entered");
		}

      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "* Username not entered");
      }
      else{
         /* Spruce up username, check length */
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5){
            $form->setError($field, "* Username below 5 characters");
         }
         else if(strlen($subuser) > 30){
            $form->setError($field, "* Username above 30 characters");
         }
         /* Check if username is reserved */
         else if(strcasecmp($subuser, GUEST_NAME) == 0){
            $form->setError($field, "* Username reserved word");
         }
         /* Check if username is already in use */
         else if($database->usernameTaken($subuser)){
            $form->setError($field, "* Username already in use");
         }
        }


	  /* Cell Phone Error Checking */
	  $field - "phone_cell"; // Use field for cell phone
	  if($subphone_cell && strlen($subphone_cell = trim($subphone_cell)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_cell)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
		}


      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return 1;  //Errors with form
      }
      /* No errors, add the new account to the */
      
      
      else{
         if($database->addNewUser($subuser, $subfname, $submname, $sublname, $subuserlevel, $subunit_num, $rankno, $rank, $subphone_cell)){
            return 0;  //New user added succesfully
         }else{
            return 2;  //Registration attempt failed
         }
      }
   }

/**
    * AdminEditUser - Gets called when the administrator has tried
    * to change a users account information. Determines if there 
    * were any errors with the entry fields, if so, it records the 
    * errors and returns 1. If no errors were found, it updates the 
    * users record and returns 0. Returns 2 if update failed.
    */
   function AdminEditUser($subuser, $subfname, $submname, $sublname, $subuserlevel, $subunit_num, $subrank, $subcode, $subsquad, $subphone_home, $subphone_work, $subphone_cell, $subprobation, $subuid){
      global $database, $form, $mailer;  //The database, form and mailer object
            
      	  /* Home Phone Error Checking */
	  $field = "phone_home"; // Use field for home phone
	  if($subphone_home && strlen($subphone_home = trim($subphone_home)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_home)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
		}
	  /* Work Phone Error Checking */
	  $field = "phone_work"; // Use field for work phone
	  if($subphone_work && strlen($subphone_work = trim($subphone_work)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_work)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
		}
	  /* Cell Phone Error Checking */
	  $field = "phone_cell"; // Use field for cell phone
	  if($subphone_cell && strlen($subphone_cell = trim($subphone_cell)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_cell)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
		}


      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return 1;  //Errors with form
      }
      /* No errors, update the account  */
      else{
     	  if($database->updateUserAccountByAdmin($subuser, $subfname, $submname, $sublname, $subuserlevel, $subunit_num, $subrank, $subcode, $subsquad, $subphone_home, $subphone_work, $subphone_cell, $subprobation, $subuid)){
            return 0;  //New user added succesfully
         }else{
            return 2;  //Update User Record attempt failed
         }
      }
   }


   /**
    * changePass - this function is called by process.php when 
    * the user is required to change their password because
    * their current password is the default password. 
    */
    function changePass($subcurpass,$subnewpass) {
	 
      global $database, $form;  //The database and form object
      /* New password entered */
      if($subnewpass){
         /* Current Password error checking */
         $field = "curpass";  //Use field name for current password
         if(!$subcurpass){
            $form->setError($field, "* Current Password not entered");
         }
         else{
            /* Check if password too short or is not alphanumeric */
            $subcurpass = stripslashes($subcurpass);
            if(strlen($subcurpass) < 4 ||
               !eregi("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))){
               $form->setError($field, "* Current Password incorrect");
            }
            /* Password entered is incorrect */
            if($database->confirmUserPass($this->username,md5($subcurpass)) != 3){
               $form->setError($field, "* Current Password incorrect");
            }
         }
         
         /* New Password error checking */
         $field = "newpass";  //Use field name for new password
         /* Spruce up password and check length*/
         $subpass = stripslashes($subnewpass);
         if(strlen($subnewpass) < 6){
            $form->setError($field, "* New Password too short");
         }
         /* Check if password is not alphanumeric */
         else if(!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))){
            $form->setError($field, "* New Password not alphanumeric");
         }
      }
      /* Change password attempted */
      else if($subcurpass){
         /* New Password error reporting */
         $field = "newpass";  //Use field name for new password
         $form->setError($field, "* New Password not entered");
      }
      
      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
      
      /* Update password since there were no errors */
      if($subcurpass && $subnewpass){
         $database->updateUserField($this->username,"password",md5($subnewpass));
      }

   /* Success! */
     return true;
   }
      
   /**
    * editAccount - Attempts to edit the user's account information
    * including the password, which it first makes sure is correct
    * if entered, if so and the new password is in the right
    * format, the change is made. All other fields are changed
    * automatically.
    */
   function editAccount($subcurpass, $subnewpass, $subphone_home, $subphone_work, $subphone_cell, $subcellcarrier, $subemail){
      global $database, $form;  //The database and form object
      /* New password entered */
      if($subnewpass){
         /* Current Password error checking */
         $field = "curpass";  //Use field name for current password
         if(!$subcurpass){
            $form->setError($field, "* Current Password not entered");
         }
         else{
            /* Check if password too short or is not alphanumeric */
            $subcurpass = stripslashes($subcurpass);
            if(strlen($subcurpass) < 4 ||
               !eregi("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))){
               $form->setError($field, "* Current Password incorrect");
            }
            /* Password entered is incorrect */
            if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){
               $form->setError($field, "* Current Password incorrect");
            }
         }
         
         /* New Password error checking */
         $field = "newpass";  //Use field name for new password
         /* Spruce up password and check length*/
         $subpass = stripslashes($subnewpass);
         if(strlen($subnewpass) < 4){
            $form->setError($field, "* New Password too short");
         }
         /* Check if password is not alphanumeric */
         else if(!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))){
            $form->setError($field, "* New Password not alphanumeric");
         }
      }
      /* Change password attempted */
      else if($subcurpass){
         /* New Password error reporting */
         $field = "newpass";  //Use field name for new password
         $form->setError($field, "* New Password not entered");
      }
      
	  /* Home Phone Error Checking */
	  $field = "phone_home"; // Use field for home phone
	  if($subphone_home && strlen($subphone_home = trim($subphone_home)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_home)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
		}
	  /* Work Phone Error Checking */
	  $field = "phone_work"; // Use field for work phone
	  if($subphone_work && strlen($subphone_work = trim($subphone_work)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_work)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
		}
	  /* Cell Phone Error Checking */
	  $field = "phone_cell"; // Use field for cell phone
	  if($subphone_cell && strlen($subphone_cell = trim($subphone_cell)) > 0) {
	  		/* Check if phone number is valid format */
			if (!preg_match("/^[0-9]{3}[-]{1,1}[0-9]{3}[-]{1,1}[0-9]{4}$/", $subphone_cell)) 
				$form->setError($field, "* Phone number format: 111-222-3333"); 
			
		}
      /* Email error checking */
      $field = "email";  //Use field name for email
      if($subemail && strlen($subemail = trim($subemail)) > 0){
         /* Check if valid email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$subemail)){
            $form->setError($field, "* Email invalid");
         }
         $subemail = stripslashes($subemail);
      }
      
      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
      
      /* Update password since there were no errors */
      if($subcurpass && $subnewpass){
         $database->updateUserField($this->username,"password",md5($subnewpass));
      }
      
	  /* Change Home Phone */
	  if($subphone_home){
	  	 $database->updateUserField($this->username,"phone_home",$subphone_home);
	  }
	  
	  /* Change Work Phone */
	  if($subphone_work){
	  	 $database->updateUserField($this->username,"phone_work",$subphone_work);
	  }
	  
	  /* Change Cell Phone */
	  if($subphone_cell){
	  	 $database->updateUserField($this->username,"phone_cell",$subphone_cell);
	  }
	  
	  /* Change Cell carrier*/
	  if($subcellcarrier){
	  	 $database->updateUserField($this->username,"cellcarrier",$subcellcarrier);
	  }
	  
      /* Change Email */
      if($subemail){
         $database->updateUserField($this->username,"email",$subemail);
      }
      
      /* Success! */
      return true;
   }
   
   /**
    * isAdmin - Returns true if currently logged in user is
    * an administrator, false otherwise.
    */
   function isAdmin(){
      return ($this->userlevel == ADMIN_LEVEL ||
              $this->username  == ADMIN_NAME);
   }
   
   /**
    * generateRandID - Generates a string made up of randomized
    * letters (lower and upper case) and digits and returns
    * the md5 hash of it to be used as a userid.
    */
   function generateRandID(){
      return md5($this->generateRandStr(16));
   }
   
   /**
    * generateRandStr - Generates a string made up of randomized
    * letters (lower and upper case) and digits, the length
    * is a specified parameter.
    */
   function generateRandStr($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
            $randstr .= chr($randnum+55);
         }else{
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
   }
};


/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session;

/* Initialize form object */
$form = new Form;

?>

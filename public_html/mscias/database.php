
<?
/**
 * Database.php
 * 
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 */
include("constants.php");
//require_once '__DIR__../../class/user.php';
// include '/home/studysaurs/public_html/jcres/includes/utilities.inc.php';

      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
//   $dbname = DB_NAME;
//   echo 'dbname';
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
  /*  try {
      	$con = new PDO("mysql:host=localhost;dbname=reserves", DB_USER, DB_PASS);
      	// set the PDO error mode to exception
      	//$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      	echo "connected successfully";
      	}
    catch(PDOException $e)
      	{
      	echo "Connection failed: " . $e->getMessage();
      	}	*/
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
      
      /**
       * Only query database to find out number of members
       * when getNumMembers() is called for the first time,
       * until then, default value set.
       */
  //    $this->num_members = -1;
      
/*      if(TRACK_VISITORS){ */
         /* Calculate number of users at site */
/*         $this->calcNumActiveUsers();
*/      
         /* Calculate number of guests at site */
/*         $this->calcNumActiveGuests();
      } */
   }
   
   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT password, status FROM ".TBL_USERS." WHERE username = '$username'";{
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
//      $user = mysql_fetch_object($result, 'user');
      
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);
      $default_password = md5('password');	
	  
      /* Validate that password is correct */
      if($password == $dbarray['password']){

	  /* Check to see if the user password is the default password */
	  if($password == $default_password) {
		return 3; //Indicates user password is still the default password
	  }
       if($dbarray['status'] & 2147483648) {
       	return 1;  //indicates disabled status
       	}
       	$_SESSION['username'] = $username;
         return 0; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
      }
   }
   }
   
   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid, status FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $userid = stripslashes($dbarray['userid']);
      $status = $dbarray['status'];
//      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
      	  $_SESSION['userid'] = $userid;
      	  $_SESSION['status'] = $status;
         return 0; //Success! Username and userid confirmed
      } else{
         return 2; //Indicates userid invalid
      }
   }
   
   /**  
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_num_rows($result) > 0);
   }

   /**  NOT NEEDED for JCMP. ONLY NEEDED WHERE USERS MIGHT BE BANNED INSTEAD of REMOVED
    * usernameBanned - Returns true if the username has
    * been banned by the administrator.
    */
/*   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
  */
 
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($username, $fname, $mname, $lname, $userlevel, $unit_num, $rankno, $rank, $phone_cell){
      $time = time();
     $q = "INSERT INTO ".TBL_USERS."(username, f_name, m_name, l_name, userlevel, unit_num, rankNo, rank, phone_cell, status) VALUES ('$username', '$fname', '$mname', '$lname', '$userlevel', '$unit_num', '$rankno', '$rank', '$phone_cell', '134746432')";
      return mysql_query($q, $this->connection);
   }
   
   /** 
    * addNewDetail - Inserts the given information for a detail into 
    * the details database. Returns true on success, false otherwise.
    */
   function addNewDetail($date, $detail_type, $detail_location, 
$start_time, $end_time, $contact, $num_officers, $officer_1, $officer_2, 
$officer_3, $officer_4, $officer_5, $officer_6, $officer_7, $officer_8, $officer_9,
 $officer_10, $paid_detail)	{

   $q = "INSERT INTO ".TBL_DETAILS." VALUES ('NULL','$date', '$detail_type', '$detail_location', '$start_time', '$end_time', '$contact', '', '$num_officers', '$officer_1', '$officer_2', '$officer_3', '$officer_4', '$officer_5', '$officer_6', '$officer_7', '$officer_8', '$officer_9', '$officer_10', '0', '$paid_detail')";

   return mysql_query($q, $this->connection);
   }


/** 
 * function failed_login - this function writes a record to 
 * the Failed_login table every time a login fails. The information
 * saved is the dat/time, IP Address of the client, the user id and
 * password submitted.
 */
 
 function failed_login($date, $user_ip, $subuser, $subpass)	{
	$q = "INSERT INTO Failed_Logins VALUES ('$date', '$user_ip', '$subuser', '$subpass')";
										   
   return mysql_query($q, $this->connection);
 }
   
   /**
    *  updateEditDetail - Updates the given information for a detail
    *  into the correct record in the details database.
    */
   function updateEditDetail($date, $detail_type, $detail_location, 
$start_time, $end_time, $contact, $num_officers, $officer_1, $officer_2, 
$officer_3, $officer_4, $officer_5, $officer_6, $officer_7, $officer_8, 
$officer_9, $officer_10, $paid_detail, $detail_num)	{

/*
if ($date == "") {$date = "NULL";}
if ($detail_type == "") {$detail_type = "NULL";}
if ($detail_location == "") {$detail_location = "NULL";}
if ($start_time == "") {$start_time = "NULL"; }
if ($end_time == "") {$end_time = "NULL";}
if ($contact == "") {$contact = "NULL";}
if ($num_officers == "") {$num_officers = "NULL";}
if ($officer_1 == "") {$officer_1 = "NULL";}
if ($officer_2 == "") {$officer_2 = "NULL";}
if ($officer_3 == "") {$officer_3 = "NULL";}
if ($officer_4 == "") {$officer_4 = "NULL";}
if ($officer_5 == "") {$officer_5 = "NULL";}
if ($officer_6 == "") {$officer_6 = "NULL";}
if ($officer_7 == "") {$officer_7 = "NULL";}
if ($officer_8 == "") {$officer_8 = "NULL";}
if ($officer_9 == "") {$officer_9 = "NULL";}
if ($officer_10 == "") {$officer_10 = "NULL";}
if ($paid_detail == "") {$paid_detail = "NULL";}
*/
 
   $q = "UPDATE ".TBL_DETAILS." SET date='$date', 
detailType='$detail_type', 
detailLocation='$detail_location', 
startTime='$start_time', endTime='$end_time', contact='$contact', 
numOfficers='$num_officers', 
officer_1='$officer_1', 
officer_2='$officer_2', 
officer_3='$officer_3', officer_4='$officer_4', officer_5='$officer_5', 
officer_6='$officer_6', 
officer_7='$officer_7', 
officer_8='$officer_8',
officer_9='$officer_9',
officer_10='$officer_10', 
paidDetail='$paid_detail' WHERE detailNum = '$detail_num'";

   return mysql_query($q, $this->connection);
   }

   /**
    *  updateEditDetail - Updates the given information for a detail
    *  into the correct record in the details database.
    */
   function updateUserAccountByAdmin($subuser, $subfname, $submname, $sublname, $subuserlevel, $subunit_num, $subrank, $subcode, $subsquad, $subphone_home, $subphone_work, $subphone_cell, $subprobation, $subuid)	{

   $q = "UPDATE ".TBL_USERS." SET  
   	f_name='$subfname', 
   	m_name='$submname', 
   	l_name='$sublname',
   	userlever='$subuserlevel',
	unit_num='$subunit_num',
	rank='$subrank',
	code='$subcode',
	squad='$subsquad',
	phone_home='$subphone_home',
	phone_work='$subphone_work',
	phone_cell='$subphone_cell',
	probationary='$subprobation' WHERE username = '$subuser'";

   return mysql_query($q, $this->connection);
   }



   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateUserField($username, $field, $value){
      $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username'";
      return mysql_query($q, $this->connection);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      /* Error occurred, return given name by default */
      if(!$result || (mysql_num_rows($result) < 1)){
         return NULL;
      }
      /* set user object */
//      $us = mysql_fetch_object($result, 'User');
      /* Return result array */
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
      
   }
   
   /**
    * getAllUsers - Returns the result array from a mysql
    * query asking for all information stored regarding
    * all users in the Users Table. If query fails, NULL is returned.
    */
   function getAllUsers(){
      $q = "SELECT * FROM ".TBL_USERS." ORDER BY 'unit_num'";
      $result = mysql_query($q, $this->connection);
      /* Error occurred, return given name by default */
      if(!$result || (mysql_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   }

   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_users = mysql_num_rows($result);
   }
   
   /**
    * calcNumActiveGuests - Finds out how many active guests
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_guests = mysql_num_rows($result);
   }
   
   /**
    * addActiveUser - Updates username's last active timestamp
    * in the database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    */
   function addActiveUser($username, $time, $usid) {
  // echo $usid;
      $q = "UPDATE ".TBL_USERS." SET timestamp = '$time' WHERE username = '$username'";
      mysql_query($q, $this->connection);
      
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$usid', '$username', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   /* addActiveGuest - Adds guest to active guests table */
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /* These functions are self explanatory, no need for comments */
   
   /* removeActiveUser */
   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   /* removeActiveGuest */
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /* removeInactiveUsers */
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time() - USER_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }

   /* removeInactiveGuests */
   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return mysql_query($query, $this->connection);
   }
}

/* Create database connection */
$database = new MySQLDB;

?>

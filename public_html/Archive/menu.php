<?
include ("./include/session.php");
$member = $_POST['userName'];
$q = "SELECT username FROM ".TBL_ACTIVE_USERS
    ." ORDER BY timestamp DESC,username";
$result = $database->query($q);
/* Error occurred, return given name by default */
$num_rows = mysql_numrows($result);
if(!$result || ($num_rows < 0)){
   echo "Error displaying info";
}
if($num_rows > 1){
   for($i=0; $i<$num_rows; $i++){
       $uname = mysql_result($result,$i,"username");
       $n = "SELECT display_name FROM ".TBL_USERS." where username = '".$uname."'";
       $who = $database->query($n);
       $name = mysql_result($who, 0);
       if ($uname != $member) {
	    print ("<li id=\"$uname\"><a href=\"#\">$name</a></li>");
       } 
   }                 	   
} else {
   print ("<li id=\"$member\"><a href=\"#\">Just you</a></li>");
}
?> 

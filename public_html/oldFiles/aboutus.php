<?
include ("./include/session.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<?
// In order to simplify working with IP addresses (in binary) and their
// netmasks, it is easier to ensure that the binary strings are padded
// with zeros out to 32 characters - IP addresses are 32 bit numbers
Function decbin32 ($dec) {
  return str_pad(decbin($dec), 32, '0', STR_PAD_LEFT);
}

// ip_in_range
// This function takes 2 arguments, an IP address and a "range" in several
// different formats.
// Network ranges can be specified as:
// 1. Wildcard format:     1.2.3.*
// 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
// 3. Start-End IP format: 1.2.3.0-1.2.3.255
// The function will return true if the supplied IP is within the range.
// Note little validation is done on the range inputs - it expects you to
// use one of the above 3 formats.
Function ip_in_range($ip, $range) {
  if (strpos($range, '/') !== false) {
    // $range is in IP/NETMASK format
    list($range, $netmask) = explode('/', $range, 2);
    if (strpos($netmask, '.') !== false) {
      // $netmask is a 255.255.0.0 format
      $netmask = str_replace('*', '0', $netmask);
      $netmask_dec = ip2long($netmask);
      return ( (ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec) );
    } else {
      // $netmask is a CIDR size block
      // fix the range argument
      $x = explode('.', $range);
      while(count($x)<4) $x[] = '0';
      list($a,$b,$c,$d) = $x;
      $range = sprintf("%u.%u.%u.%u", empty($a)?'0':$a, empty($b)?'0':$b,empty($c)?'0':$c,empty($d)?'0':$d);
      $range_dec = ip2long($range);
      $ip_dec = ip2long($ip);

      # Use math to create it
      $wildcard_dec = pow(2, (32-$netmask)) - 1;
      $netmask_dec = ~ $wildcard_dec;

      return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
    }
  } else {
    // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
    if (strpos($range, '*') !==false) { // a.b.*.* format
      // Just convert to A-B format by setting * to 0 for A and 255 for B
      $lower = str_replace('*', '0', $range);
      $upper = str_replace('*', '255', $range);
      $range = "$lower-$upper";
    }

    if (strpos($range, '-')!==false) { // A-B format
      list($lower, $upper) = explode('-', $range, 2);
      $lower_dec = (float)sprintf("%u",ip2long($lower));
      $upper_dec = (float)sprintf("%u",ip2long($upper));
      $ip_dec = (float)sprintf("%u",ip2long($ip));
      return ( ($ip_dec>=$lower_dec) && ($ip_dec<=$upper_dec) );
    }

    echo 'Range argument is not in 1.2.3.4/24 or 1.2.3.4/255.255.255.0 format';
    return false;
  }

}
?>




<?
$user_ip = $_SERVER['REMOTE_ADDR']; 
	$range = "205.144.224.0-205.144.255.255";
  if (ip_in_range($user_ip, $range) == 1) 	header("Location:denied_access.php");

?>
<style type="text/css"> 
<!-- 
@import url("navlist.css");
body  {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #003;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}

/* Tips for Elastic layouts 
1. Since the elastic layouts overall sizing is based on the user's default fonts size, they are more unpredictable. Used correctly, they are also more accessible for those that need larger fonts size since the line length remains proportionate.
2. Sizing of divs in this layout are based on the 100% font size in the body element. If you decrease the text size overall by using a font-size: 80% on the body element or the #container, remember that the entire layout will downsize proportionately. You may want to increase the widths of the various divs to compensate for this.
3. If font sizing is changed in differing amounts on each div instead of on the overall design (ie: #sidebar1 is given a 70% font size and #mainContent is given an 85% font size), this will proportionately change each of the divs overall size. You may want to adjust these divs based on your final font sizing.
*/
.twoColElsLt #container {
	width: 54em;  /* this width will create a container that will fit in an 800px browser window if text is left at browser default font sizes */
	background: #FFFFCC;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
} 

.twoColElsLt #sidebar1 {
	float: left; 
	width: 12em; /* since this element is floated, a width must be given */
	padding: 15px 0; /* top and bottom padding create visual space within this div */
		background: #FFFFCC;
}
.twoColElsLt #sidebar1 h3, .twoColElsLt #sidebar1 p {
	margin-left: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
}

.twoColElsLt #mainContent {
 	margin: 0 1.5em 0 13em; /* the right margin can be given in ems or pixels. It creates the space down the right side of the page. */
} 

/* Miscellaneous classes for reuse */
.fltrt { /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain a float */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}
img
{  border-style: none;
}


--> 
</style>
<!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColElsLt #sidebar1 { padding-top: 0px; }
.twoColElsLt #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]--></head>

<body class="twoColElsLt">

<div id="container">
   <div id="sidebar1">
<table border="0" align="center" cellpadding="5" cellspacing="0" id="Buttons">
	<tr></tr>
    <tr>
   	  <td><a href="index.php" ><img src="images/Home.png" onMouseOver="this.src='images/Home-Hover.png'" onMouseOut="this.src='images/Home.png'" /></a></td>
    </tr>  
    <tr>
   	  <td><a href="aboutus.php" ><img src="images/MeetMembers.png " onMouseOver="this.src='images/MeetMembers-Hover.png'" onMouseOut="this.src='images/MeetMembers.png'" /></a></td>
    </tr>  
    <tr>
<? /*   	  <td><a href="images/album/index.html"><img src="images/PhotoGallery.png" onMouseOver="this.src='images/PhotoGallery-Hover.png'" onMouseOut="this.src='images/PhotoGallery.png'" /></a></td>
    </tr>  */ ?> 
    <tr>
   	  <td><a href="main.php" ><img src="images/MemberLogin.png" onMouseOver="this.src='images/MemberLogin-Hover.png'" onMouseOut="this.src='images/MemberLogin.png'" /></a></td>
    </tr>  
    <tr>
   	  <td><a href="application.php" ><img src="images/Apply.png" onMouseOver="this.src='images/Apply-Hover.png'" onMouseOut="this.src='images/Apply.png'" /></a></td>
    </tr>  
    <tr>
   	  <td><a href="contact.php" ><img src="images/Contact.png" onMouseOver="this.src='images/Contact-Hover.png'" onMouseOut="this.src='images/Contact.png'" /></a></td>
    </tr>  




</table>
    <h3>&nbsp;</h3>
    <!-- end #sidebar1 --></div>
 <div id="mainContent">
  	<p>The Jackson County Mounted Patrol was restablished in 1984 by 
Sheriff Wallace Gill under the command of the late Jim Bains.</p>
    <h2>Current Members of the Mounted Patrol<!-- end #mainContent 
--></h2>
  </div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats -->

<!-- Start the table to display Mounted Patrol Members -->    
<table width="650" border="0">
    

<?

global $database;
/* $user_info = $database->getAllUsers(); */
$q = "SELECT sort, unit_num, username, rank, photo, display_name FROM ".TBL_USERS." where username != 'visitor' ORDER BY sort";

$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from User table failed";
}

$cell = 0;

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$unit_num = $row['unit_num'];
	if ($unit_num == 'LOA')	break;
	$rank = $row['rank'];
	$photo = $row['photo'];
	$display_name = $row['display_name'];



		if ($cell == '0') {
			$picture_line="<tr>";
			$name_line="<tr>";
		}

		
		$picture_line = $picture_line ."<td width=\"212\"><img src=\"images/".$photo."\" alt=\"Connie\" width=\"200\" height=\"180\" /></td>";
		$name_line = $name_line ."<td align=\"center\">".$rank." ".$display_name."</td>";
		$cell++;
		

		
		if ($cell == '3')	{
			$cell = 0;
			$picture_line = $picture_line."</tr>";
			$name_line = $name_line."</tr>";
			print($picture_line);
			print($name_line);
			$picture_line="";
			$name_line="";
		}
}

	print($picture_line);
	print($name_line);


mysql_free_result($result);

?>

		<tr>
		  <td align="center">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td align="center">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
			<td align="center">&nbsp;</td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
		</tr>
</table>
</div>

</body>
</html>
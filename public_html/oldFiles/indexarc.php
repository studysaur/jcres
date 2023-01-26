<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Jackson County Mississippi Sheriff's Department - Mounted Patrol Division, Mounted Patrol, Search and rescue" />
<meta name="keywords" content="mounted patrol, sheriff, jackson county, mississippi" />
<title>Jackson County Mounted Patrol - Jackson County Mississippi - Sheriff Department</title>
<?
/*
 * ip_in_range.php - Function to determine if an IP is located in a
 *                   specific range as specified via several alternative
 *                   formats.
 *
 * Network ranges can be specified as:
 * 1. Wildcard format:     1.2.3.*
 * 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
 * 3. Start-End IP format: 1.2.3.0-1.2.3.255
 *
 * Return value BOOLEAN : ip_in_range($ip, $range);
 *
 * Copyright 2008: Paul Gregg <pgregg@pgregg.com>
 * 10 January 2008
 * Version: 1.2
 *
 * Source website: http://www.pgregg.com/projects/php/ip_in_range/
 * Version 1.2
 *
 * This software is Donationware - if you feel you have benefited from
 * the use of this tool then please consider a donation. The value of
 * which is entirely left up to your discretion.
 * http://www.pgregg.com/donate/
 *
 * Please do not remove this header, or source attibution from this file.
 */


// decbin32
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

      # Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
      #$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));

      # Strategy 2 - Use math to create it
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
$blocklist = 'iplist.txt';
$lines = file($blocklist);
	foreach ($lines as $line)	{
		if (ip_in_range($user_ip, $line) == 1) 	header("Location:denied_access.php");
	}

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
.twoColHybLtHdr #container #mainContent .captionright img {
	position: static;
	right: 0px;
}
.twoColHybLtHdr #container {
	width: 80%;  /* this will create a container 80% of the browser width */
	background: #FFFFCC;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
	} 
.twoColHybLtHdr #header { 
	background: #DDDDDD; 
	padding: 0;  /* this padding matches the left alignment of the elements in the divs that appear beneath it. If an image is used in the #header instead of text, you may want to remove the padding. */
} 
.twoColHybLtHdr #header h1 {
	margin: 0; /* zeroing the margin of the last element in the #header div will avoid margin collapse - an unexplainable space between divs. If the div has a border around it, this is not necessary as that also avoids the margin collapse */
	padding: 0; /* using padding instead of margin will allow you to keep the element away from the edges of the div */
}

.twoColHybLtHdr #sidebar1 {
	float: left; 
	width: 12em; /* since this element is floated, a width must be given */
	padding: 0px; /* top and bottom padding create visual space within this div  */
	background: #FFFFCC;
}
.twoColHybLtHdr #sidebar1 h3, .twoColHybLtHdr #sidebar1 p {
	margin-left: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
}

.twoColHybLtHdr #mainContent { 
	margin: 0 20px 0 13em; /* the right margin can be given in percentages or pixels. It creates the space down the right side of the page. */
} 
.twoColHybLtHdr #footer {
	background:#aaaaaa;
	padding-top: 0;
	padding-right: 10px;
	padding-bottom: 0;
	padding-left: 10px;
} 
.twoColHybLtHdr #footer p {
	margin: 0; /* zeroing the margins of the first element in the footer will avoid the possibility of margin collapse - a space between divs */
	padding: 10px 0; /* padding on this element will create space, just as the the margin would have, without the margin collapse issue */
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
.style2 {font-size: small}
#sheriff_link {
	width: 70%;
	font-size: xx-large;
	height: 20%;
	margin-top: 15px;
	margin-bottom: 20px;
	margin-left: 150px;
	padding-bottom: 10px;
}
img
{  border-style: none;
}


.style4 {font-size: x-large}
--> 
</style>
<!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColHybLtHdr #sidebar1 { padding-top: 0px; }
.twoColHybLtHdr #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it may need to avoid several bugs */
</style>
<![endif]--></head>

<body class="twoColHybLtHdr">

<div id="container">
  <div id="header">
    <h1><img src="images/web_header-1.jpg" alt="Mounted Patrol Header" width="100%" /></h1>
  <!-- end #header --></div>
  <div id="sidebar1">

<table border="0" align="center" cellpadding="5" cellspacing="0" id="Buttons">
	<tr></tr>
    <tr>
   	  <td><a href="index.php" ><img src="images/Home.png" onMouseOver="this.src='images/Home-Hover.png'" onMouseOut="this.src='images/Home.png'" /></a></td>
    </tr>  
    <tr>
   	  <td><a href="aboutus.php" ><img src="images/MeetMembers.png " onMouseOver="this.src='images/MeetMembers-Hover.png'" onMouseOut="this.src='images/MeetMembers.png'" /></a></td>
    </tr>  
<? /*     <tr>
   	  <td><a href="images/album/index.html"><img src="images/PhotoGallery.png" onMouseOver="this.src='images/PhotoGallery-Hover.png'" onMouseOut="this.src='images/PhotoGallery.png'" /></a></td>
    </tr> */ ?> 
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
  	<!-- end #sidebar1 -->
  </div>
  <div id="mainContent">
    <table width="245" border="0" align="right">
    	<caption align="bottom" style="font-weight:600">
			Bob Nusko - Chief <br />
		</caption>
    <tr>
		<td width="239"><img src="images/bob_nusko.jpg" alt="Bob Nusko - Chief" 
width="242" height="219" hspace="20"/></td>
    		
   	  </tr>
        <tr>
    		<td>&nbsp;</td>	
	</tr></table>

    <p>The Mounted Patrol Division of the Jackson County Sheriff's 
Department is comprised of fully commisioned deputies who volunteer 
their time to the Sheriff's Department and citizens of Jackson 
County, Mississippi.</p>
<h2>Mission</h2>
<p>Our mission is to assist the Sheriff's Department in protecting and 
serving the citizens of Jackson County. The Mounted Patrol fulfills this 
mission by providing officers and equipment for search and rescue, as 
well as crowd control, traffic control, working security detail, working 
with other regular/reserve officers, doing road patrol and any other 
duties that may be requested by the Sheriff. The Mounted Patrol provides 
a highly visible presence in the community as a crime deterrent. The 
Mounted Patrol also encourages positive community relations through 
community policing on horseback.</p>
    <p>&nbsp;</p>
  </div>
<div id="sheriff_link" align="center">
	<h1 class="style4">If you are looking for the official Jackson County Sheriff web site, you can find it <a href="http://www.co.jackson.ms.us/officials/sheriff/index.php" target="_blank">here</a>.</h1>
</div>
	<div id="footer">
<table><tr><td 
width="230"></td><td><h4 align="center">This web site was designed and hosted by a volunteer and are not 
official pages of Jackson County, MS or the Sheriff's Office</h4></td><td width="230"></td></tr></table>
		<!-- end #footer -->
	</div>
<!-- end #container --></div>
<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=6003641; 
var sc_invisible=0; 
var sc_security="bd9bb44f"; 
</script>

<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script><noscript><div
class="statcounter"><a title="tumblr stats"
href="http://www.statcounter.com/tumblr/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/6003641/0/bd9bb44f/0/"
alt="tumblr stats" ></a></div></noscript>
<!-- End of StatCounter Code --><br/><a
href="http://my.statcounter.com/project/standard/stats.php?project_id=6003641&amp;guest=1">View
My Stats</a>
</body>
</html>

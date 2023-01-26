<?
/* 
 * Weapons Qualification Sheet - this web page will allow
 * the Firearms Coordinator to look at the weapons qualifications  
 * that have been made by each officer.
 */
include ("./include/session.php");

if(!$session->logged_in) {
	
	header("Location:main.php");
	}
?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252" />
<?
/* Beginning of <head> for Date Picker  */
?>
<!-- UTF-8 is the recommended encoding for your pages -->
    <meta http-equiv="content-type" content="text/xml; charset=utf-8" />
    <title>Weapons Qual by User</title>

<!-- Loading Theme file(s) -->
    <link rel="stylesheet" href="http://www.zapatec.com/website/main/../ajax/zpcal/themes/wood.css" />
    <link rel="stylesheet" 
href="http://www.zapatec.com/website/main/../ajax/zpcal/themes/layouts/big.css" 
/>

<!-- Loading Calendar JavaScript files -->
    <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/../utils/zapatec.js"></script>
    <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/src/calendar.js"></script>
<!-- Loading language definition file -->
    <script type="text/javascript" src="http://www.zapatec.com/website/main/../ajax/zpcal/lang/calendar-en.js"></script>
<?
/* Beginning of <head> for editable drop down */
?>
<SCRIPT LANGUAGE="JavaScript"> //Common functions for all dropdowns

function fnKeyDownHandler(getdropdown, e)
  {
    fnSanityCheck(getdropdown);

    var vEventKeyCode = FindKeyCode(e);

    if(vEventKeyCode == 37)
    {
    fnLeftToRight(getdropdown);
    }
    if(vEventKeyCode == 39)
    {
    fnRightToLeft(getdropdown);
    }

    if(vEventKeyCode == 46)
    {
    fnDelete(getdropdown);
    }

    if(vEventKeyCode == 8 || vEventKeyCode==127)
    {
    if(e.which) //Netscape
    {
      //e.which = ''; //this property has only a getter.
    }
    else //Internet Explorer
    {
      //To prevent backspace from activating the -Back- button of the browser
      e.keyCode = '';
      if(window.event.keyCode)
      {
      window.event.keyCode = '';
      }
    }
    return true;
    }

    // Tab key pressed, use code below to reorient to Left-To-Right flow, if needed
    //if(vEventKeyCode == 9)
    //{
    //  fnLeftToRight(getdropdown);
    //}
  }

  function fnLeftToRight(getdropdown)
  {
    getdropdown.style.direction = "ltr";
  }

  function fnRightToLeft(getdropdown)
  {
    getdropdown.style.direction = "rtl";
  }

  function fnDelete(getdropdown)
  {
    if(getdropdown.options.length != 0)
    // if dropdown is not empty
    {
    if (getdropdown.options.selectedIndex == vEditableOptionIndex_A)
    // if option the Editable field
    {
      getdropdown.options[getdropdown.options.selectedIndex].text = '';
      getdropdown.options[getdropdown.options.selectedIndex].value = '';
    }
    }
  }



  function FindKeyCode(e)
  {
    if(e.which)
    {
    keycode=e.which;  //Netscape
    }
    else
    {
    keycode=e.keyCode; //Internet Explorer
    }

    //alert("FindKeyCode"+ keycode);
    return keycode;
  }

  function FindKeyChar(e)
  {
    keycode = FindKeyCode(e);
    if((keycode==8)||(keycode==127))
    {
    character="backspace"
    }
    else if((keycode==46))
    {
    character="delete"
    }
    else
    {
    character=String.fromCharCode(keycode);
    }
    //alert("FindKey"+ character);
    return character;
  }

  function fnSanityCheck(getdropdown)
  {
    if(vEditableOptionIndex_A>(getdropdown.options.length-1))
    {
    alert("PROGRAMMING ERROR: The value of variable vEditableOptionIndex_... cannot be greater than (length of dropdown - 1)");
    return false;
    }
  }
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript"> //Dropdown specific functions, which manipulate dropdown specific global variables

  var vEditableOptionIndex_A = 1;
  var vEditableOptionText_A = "--?--";
  var vPreviousSelectIndex_A = 0;
  var vSelectIndex_A = 0;
  var vSelectChange_A = 'MANUAL_CLICK';

  function fnChangeHandler_A(getdropdown)
  {
    fnSanityCheck(getdropdown);

    vPreviousSelectIndex_A = vSelectIndex_A;
    // Contains the Previously Selected Index

    vSelectIndex_A = getdropdown.options.selectedIndex;
    // Contains the Currently Selected Index

    if ((vPreviousSelectIndex_A == (vEditableOptionIndex_A)) && (vSelectIndex_A != (vEditableOptionIndex_A))&&(vSelectChange_A != 'MANUAL_CLICK'))
    // To Set value of Index variables - Subrata Chakrabarty
    {
      getdropdown[(vEditableOptionIndex_A)].selected=true;
      vPreviousSelectIndex_A = vSelectIndex_A;
      vSelectIndex_A = getdropdown.options.selectedIndex;
      vSelectChange_A = 'MANUAL_CLICK';
      // Indicates that the Change in dropdown selected
      // option was due to a Manual Click
    }
  }

  function fnKeyPressHandler_A(getdropdown, e)
  {
    fnSanityCheck(getdropdown);

    keycode = FindKeyCode(e);
    keychar = FindKeyChar(e);

    // Check for allowable Characters
    if ((keycode>47 && keycode<59)||(keycode>62 && keycode<127) ||(keycode==32))
    {
      var vAllowableCharacter = "yes";
    }
    else
    {
      var vAllowableCharacter = "no";
    }

    //alert(window); alert(window.event);

    if(getdropdown.options.length != 0)
    // if dropdown is not empty
      if (getdropdown.options.selectedIndex == (vEditableOptionIndex_A))
      // if selected option the Editable option of the dropdown
      {

        var vEditString = getdropdown[vEditableOptionIndex_A].value;

        // make Editable option Null if it is being edited for the first time
        if((vAllowableCharacter == "yes")||(keychar=="backspace"))
        {
          if (vEditString == vEditableOptionText_A)
            vEditString = "";
        }
        if (keychar=="backspace")
        // To handle backspace - Subrata Chakrabarty
        {
          vEditString = vEditString.substring(0,vEditString.length-1);
          // Decrease length of string by one from right

          vSelectChange_A = 'MANUAL_CLICK';
          // Indicates that the Change in dropdown selected
          // option was due to a Manual Click

        }
        //alert("EditString2:"+vEditString);

        if (vAllowableCharacter == "yes")
        // To handle addition of a character - Subrata Chakrabarty
        {
          vEditString+=String.fromCharCode(keycode);
          // Concatenate Enter character to Editable string
          var i=0;
          var vEnteredChar = String.fromCharCode(keycode);
          var vUpperCaseEnteredChar = vEnteredChar;
          var vLowerCaseEnteredChar = vEnteredChar;


          if(((keycode)>=97)&&((keycode)<=122))
          // if vEnteredChar lowercase
            vUpperCaseEnteredChar = String.fromCharCode(keycode - 32);
            // This is UpperCase


          if(((keycode)>=65)&&((keycode)<=90))
          // if vEnteredChar is UpperCase
            vLowerCaseEnteredChar = String.fromCharCode(keycode + 32);
            // This is lowercase

          if(e.which) //For Netscape
          {
            for (i=0;i<=(getdropdown.options.length-1);i++)
            {
              if(i!=vEditableOptionIndex_A)
              {
                var vReadOnlyString = getdropdown[i].value;
                var vFirstChar = vReadOnlyString.substring(0,1);
                if((vFirstChar == vUpperCaseEnteredChar)||(vFirstChar == vLowerCaseEnteredChar))
                {
                  vSelectChange_A = 'AUTO_SYSTEM';
                  break;
                }
                else
                {
                  vSelectChange_A = 'MANUAL_CLICK';
                  // Indicates that the Change in dropdown selected
                  // option was due to a Manual Click
                }
              }
            }
          }
        }

        // Set the new edited string into the Editable option
        getdropdown.options[vEditableOptionIndex_A].text = vEditString;
        getdropdown.options[vEditableOptionIndex_A].value = vEditString;

        return false;
      }
    return true;
  }

  function fnKeyUpHandler_A(getdropdown, e)
  {
    fnSanityCheck(getdropdown);

    if(e.which) // Netscape
    {
      if(vSelectChange_A == 'AUTO_SYSTEM')
      {
        getdropdown[(vEditableOptionIndex_A)].selected=true;
      }

      var vEventKeyCode = FindKeyCode(e);
      // if [ <- ] or [ -> ] arrow keys are pressed, select the editable option
      if((vEventKeyCode == 37)||(vEventKeyCode == 39))
      {
        getdropdown[vEditableOptionIndex_A].selected=true;
      }
    }
  }

</SCRIPT>  
<style>
<!--
@import url("horzlist.css");
a:link, span.MsoHyperlink {
	color:blue;
	text-decoration:underline;
	}
a:visited, span.MsoHyperlinkFollowed {
	color:purple;
	text-decoration:underline;
	}
	
div#horzlist	{
	height: 30px;
	width: 100%;
	border-top: solid #000 1px;
	border-bottom: solid #000 1px;
	background-color: #336699;
	}
	
div#horzlist ul {
	margin: 0px;
	padding: 0px;
	font:Verdana, Arial, Helvetica, sans-serif;
	font-size:small;
	color: #FFCC00;
	line-height: 30px;
	white-space: nowrap;
	}

div#horzlist li {
	list-style-type: none;
	display: inline;
	}

div#horzlist a {
	text-decoration: none;
	padding: 7px 10px;
	color: #FFCC00
	}
	
div#horzlist a:link {
	color: #CCC
	}
	
div#horzlist a:visited {
	color: #CCC
	}
	
div#horzlist a:hover {
	font-weight: bold;
	color: #FFF;
	background-color: #3366FF
	}
.style1 {
	font-family: "Verdana", "sans-serif";
	font-size: 24.0pt;
}
##excel_link {
	width: 200px;
}
	
-->
</style>
<title>Jackson County Mounted Patrol - Weapons Qualification Sheet</title>
</head>
<body bgcolor="#FFFFFF" link=blue vlink=purple lang=EN-US>
<div id="horzlist">
<?
   if($session->isAdmin()) {
?>
	<ul>
		<li><a href="index.php">Home</a> </li>
		<li><a href="mounted_patrol_roster.php">Current Roster </a></li>
		<li><a href="unit_details.php">Unit Details </a></li>
		<li><a href="personal_detail_sheet.php">Personal Detail Sheet </a></li>
		<li><a href="citation_report.php">Monthly Citation Report</a></li>
		<li><a href="./admin/admin.php">Admin Center</a></li>
<?      print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	</ul>
<?
    }
    else
    {
?>
        <ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
		<li><a href="unit_details.php">Unit Details</a></li>
		<li><a href="personal_destial_sheet.php">Personal Detail Sheet</a></li>
		<li><a href="citation_report.php">Monthly Citation Report</a></li>
<?	print ("<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>");  ?>
		<li><a href="process.php">Logout</a></li>
	<ul>
<?
    }
?>

</div>

<?
global $database;
/* Query the User database for all users */
$level = $session->userlevel;
if($level == '4' || $level == '6' || $level == '7' || $level == '9')	
{
	$q = "SELECT name,username FROM ".TBL_USERS." ORDER BY name";
	$result = $database->query($q);
	$num_rows = mysql_numrows($result);

	if(!result || ($num_rows < 0))	{
		echo "<h2>Query to select all users from users table failed"; }

	$option = "";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
		$name = $row['name'];
		$username = $row['username'];
		$option = $option."<option value=\"$username\">$name</option>";
	}
	$option = $option."</select>";
	?>
	<form action="" method="POST">
	<table align="center" border="0" cellpadding="3" cellspacing="0">
	<tr><td><h2>Select User to display:</h2></td><td><select name="username"><?echo 
"$option"?></td></tr>
	<tr><td colspan="2" align="right"><input type="hidden" name="submitted" value="true">
					  <input type="submit" value="Submit"></td></tr>
	</table>
	</form>
	<?
	$user = $_POST['username'];
	$q="SELECT name FROM ".TBL_USERS." WHERE username = '$user'";
	$result = $database->query($q);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$name = $row['name'];
	}
else	{
	$name = $session->name;
	$user = $session->username;
	}

?>
<table border="0">
<tr>
	<td><a href="addWeapon.php?type=weapon"><img src="images/add_weapon.jpg"></a></td>
	<td><a href="addWeapon.php?type=force"><img src="images/add_deadly_force.jpg"></a></td>
</tr>

<form action="update_weapons.php" method="POST">


<table border="1" cellpadding="2" cellspacing="2" style="font-size:18px">
<CAPTION><EM><h2>Weapons Qualified with by <? echo "$name" ?></h2></EM></CAPTION>
<tr>
	<td>New Qual Date:</td>
	<td> <input type="text" id="calendar1" name="calendar1" />
    	<button id="trigger"><img src="images/cal.gif"></button>
    	<script type="text/javascript">//<![CDATA[
      		Zapatec.Calendar.setup({
        		weekNumbers       : false,
        		step              : 1,
        		range             : [2008.01, 2020.12],
        		electric          : false,
        		inputField        : "calendar1",
        		button            : "trigger",
        		ifFormat          : "%Y-%m-%d",
        		daFormat          : "%Y/%m/%d"
      	});
    //]]></script></td>
	<td colspan="1" align="right">Night Qual:</td>
	<td colspan="5" align="left"><input type="checkbox" name="night"></td>
</tr>
<tr>
	<td><b>Date</b></td>
	<td><b>Type</b></td>
	<td><b>Make</b></td>
	<td><b>Model</b></td>
	<td><b>Serial Number</b></td>
	<td><b>Caliber</b></td>
	<td><b>Night Qual</b></td>
	<td><b>Update</b></td>
</tr>


<?	
$space=chr(173);

$q = "SELECT * FROM ".TBL_GUNS." WHERE username = '".$user."' ORDER BY qual_date"; 
$result = $database->query($q);

/* Check for Errors in Reading Table */
$num_rows = mysql_numrows($result);
if (!$result || ($num_rows < 0))  {
	echo "Query to show fields from Credit table failed";
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$date= $row['qual_date'];
	$type=$row['type'];
	$make = $row['make'];
		if(!$make) {
			$make=chr(173);}
	$model = $row['model'];
		if(!$model) {
			$model=chr(173);}
	$serial_num = $row['serial_num'];
		if (!serial_num){
			$serial_num=chr(173);}	
	$caliber = $row['caliber'];
	if($type=="Duty")	{
			$night_qual_date = $row['night_qual_date'];		}
		else	{
			$night_qual_date="N/A";
		}

?>
<tr>
	<td><? echo"$date"?></td>
	<td><? echo"$type"?></td>
	<td><? echo"$make"?></td>
	<td><? echo"$model"?></td>
	<td><? echo"$serial_num"?></td>
	<td><? echo"$caliber"?></td>
	<td><? echo"$night_qual_date"?></td>
	<td align="center"><input type="checkbox" value="1" name="<?echo "$serial_num"?>"></td>
</tr>	

<?
}
$q = "SELECT * FROM annual_training WHERE userid = '".$user."' AND type = 'Deadly Force'";
$result = $database->query($q);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
	$deadly_date = $row['date'];
}
?>
<tr>
	<td colspan="8"><? echo "$space"?></td>
</tr>
<tr>
	<td align="right"><b>Deadly Force Date: </b></td>
	<td><? echo "$deadly_date"?></td>
	<td align="right"><b>Update Deadly Force Date: </b></td>
	<td align="left"><input type="checkbox" value="1" name="deadly_force"></td>
	<td><b>Instructor: </b></td>
	<td><input type="text" name="instructor"></td>
	
</tr>
<tr>
	<td colspan="8" align="right">	<input type="hidden" name="user" value=<?echo "$user"?>>
					<input type="submit" value="Update Records"></td>
</tr>

</table>
</form>
</body>
</html>

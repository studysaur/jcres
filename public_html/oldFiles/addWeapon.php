<?
/**
 * addDetail.php
 * 
 * Displays the detail form.
 * 
 */
include("include/session.php");
?>

<html>
<title>Add Weapon</title>
  <head>
<?
/* Beginning of <head> for Date Picker  */
?>
<!-- UTF-8 is the recommended encoding for your pages -->
    <meta http-equiv="content-type" content="text/xml; charset=utf-8" />
    <title>Add Detail</title>

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

  </head>
<body>

<?
/**
 * Test to make sure the person has the right userlevel to be here
 */

$level = $session->userlevel;
if($level == '4'|| $level == '6' || $level == '7' || $level == 9)	{

echo "<br/><a href=\"weapons_qual.php\"><img 
src=\"images/return.jpg\"></a>";

$selection = $_REQUEST['type'];
if($selection == 'weapon')	{
	addWeapon();
} else	{
	addDeadlyForce();
}
}	else	{
	echo "You do not have the proper user level to access this form.<br/>";
	echo "Contact the administrator if you feel that this is incorrect.<br/>";
	echo "<br/>Click [<a href=\"main.php\">here</a>] to continue.";
}



function addWeapon()	{
	global $database, $form;
?>
<h1>Add Weapon</h1>
<?
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
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
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" 
cellpadding="3">
<tr>
	<td>Select User:</td>
	<td><select name="username"><?echo "$option"?>
	</td>
</tr>
<tr>
	<td>Date: (yyyy-mm-dd)</td>
	<td> <input type="text" id="calendar" name="calendar" />
    	<button id="trigger"><img src="images/cal.gif"></button>
    	<script type="text/javascript">//<![CDATA[
      		Zapatec.Calendar.setup({
        		weekNumbers       : false,
        		step              : 1,
        		range             : [2008.01, 2020.12],
        		electric          : false,
        		inputField        : "calendar",
        		button            : "trigger",
        		ifFormat          : "%Y-%m-%d",
        		daFormat          : "%Y/%m/%d"
      	});
    //]]></script></td>
	<td></td>
</tr>
<tr>
	<td>Type:</td>
	<td><select name="weapon_type">
		<option value="Backup">Backup Weapon</option>
		<option value="Duty">Duty Weapon</option>
		<option value="Off-Duty">Off Duty Weapon</option>
		<option value="Rifle">Rifle</option>
		<option value="Shot Gun">Shot Gun</option>
		</select>
	</td>

	<td></td>
</tr>
<tr>
	<td>Make:</td>
	<td><input type="text" name="weapon_make"></td>
	<td></td>
</tr>
<tr>
	<td>Model:</td>
	<td><input type="text" name="weapon_model"></td>
	<td></td>									
</tr>
<tr>
	<td>Serial Number:</td>
	<td><input type="text" name="weapon_serial"></td>
	<td></td>
</tr>
<tr>
	<td>Caliber:</td>
	<td><select name="weapon_caliber" id="weapon_caliber" style="" 
onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);">
		<option value="" ></option>
		<option value="" >------?------</option>
		<option value=".380 ACP">.380 ACP</option>
		<option value="9 mm">9 mm</option>
		<option value=".38 Special">.38 Special</option>
		<option value=".357 Magnum">.357 Magnum</option>
		<option value="10 mm">10 mm</option>
		<option value=".40 S&W">.40 S&W</option>
		<option value=".44 Magnum">.44 Magnum</option>
		<option value=".45 ACP">.45 ACP</option>
		</select>
	<td></td>
</tr>
<tr>
	<td>Night Qual:</td>
	<td><input type="checkbox" name="night"></td>
	<td></td>
</tr>
<tr>
	<td colspan="2" align="right">
		<input type="hidden" name="subWeapon" value="1">
		<input type="submit" value="Add Weapon"></td>
	<td></td>		
</tr>
</table>
</form>

<?
}


function addDeadlyForce()	{
	global $database, $form;
?>
<h1>Add Deadly Force</h1>
<?
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
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
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" 
cellpadding="3">
<tr>
	<td>Select User:</td>
	<td><select name="username"><?echo "$option"?>
	</td>
</tr>
<tr>
	<td>Date: (yyyy-mm-dd)</td>
	<td> <input type="text" id="calendar" name="calendar" />
    	<button id="trigger"><img src="images/cal.gif"></button>
    	<script type="text/javascript">//<![CDATA[
      		Zapatec.Calendar.setup({
        		weekNumbers       : false,
        		step              : 1,
        		range             : [2008.01, 2020.12],
        		electric          : false,
        		inputField        : "calendar",
        		button            : "trigger",
        		ifFormat          : "%Y-%m-%d",
        		daFormat          : "%Y/%m/%d"
      	});
    //]]></script></td>
	<td></td>
</tr>
<tr>
	<td>Instructor's Name: </td>
	<td><input type="text" name="instructor"></td>
</tr>
<tr>	
	<td colspan="2" align="right"><input type="hidden" name="addDeadlyForce">
						<input type="submit" name="Add Record"></td>
</tr>
</table>
</form>
<?
}
?>

</body>
</html>

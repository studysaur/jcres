<?php
/**
 * addDetail.php
 * 
 * Displays the detail form.
 * 
 */
include("include/session.php");
?>

<html>
<title>Add Detail</title>
  <head>
<?php
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

<?php
/* The beginning of the Script for the Popup Menu */
?>
<script language=JavaScript>


var datePickerDivID = "datepicker";
var iFrameDivID = "datepickeriframe";

var dayArrayShort = new Array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');
var dayArrayMed = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
var dayArrayLong = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
var monthArrayShort = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
var monthArrayMed = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
var monthArrayLong = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
 
// these variables define the date formatting we're expecting and outputting.
// If you want to use a different format by default, change the defaultDateSeparator
// and defaultDateFormat variables either here or on your HTML page.
var defaultDateSeparator = "/";        // common values would be "/" or "."
var defaultDateFormat = "mdy"    // valid values are "mdy", "dmy", and "ymd"
var dateSeparator = defaultDateSeparator;
var dateFormat = defaultDateFormat;

/**
This is the main function you'll call from the onClick event of a button.
Normally, you'll have something like this on your HTML page:

Start Date: <input name="StartDate">
<input type=button value="select" onclick="displayDatePicker('StartDate');">

That will cause the datepicker to be displayed beneath the StartDate field and
any date that is chosen will update the value of that field. If you'd rather have the
datepicker display beneath the button that was clicked, you can code the button
like this:

<input type=button value="select" onclick="displayDatePicker('StartDate', this);">

So, pretty much, the first argument (dateFieldName) is a string representing the
name of the field that will be modified if the user picks a date, and the second
argument (displayBelowThisObject) is optional and represents an actual node
on the HTML document that the datepicker should be displayed below.

In version 1.1 of this code, the dtFormat and dtSep variables were added, allowing
you to use a specific date format or date separator for a given call to this function.
Normally, you'll just want to set these defaults globally with the defaultDateSeparator
and defaultDateFormat variables, but it doesn't hurt anything to add them as optional
parameters here. An example of use is:

<input type=button value="select" onclick="displayDatePicker('StartDate', false, 'dmy', '.');">

This would display the datepicker beneath the StartDate field (because the
displayBelowThisObject parameter was false), and update the StartDate field with
the chosen value of the datepicker using a date format of dd.mm.yyyy
*/
function displayDatePicker(dateFieldName, displayBelowThisObject, dtFormat, dtSep)
{
  var targetDateField = document.getElementsByName (dateFieldName).item(0);
 
  // if we weren't told what node to display the datepicker beneath, just display it
  // beneath the date field we're updating
  if (!displayBelowThisObject)
    displayBelowThisObject = targetDateField;
 
  // if a date separator character was given, update the dateSeparator variable
  if (dtSep)
    dateSeparator = dtSep;
  else
    dateSeparator = defaultDateSeparator;
 
  // if a date format was given, update the dateFormat variable
  if (dtFormat)
    dateFormat = dtFormat;
  else
    dateFormat = defaultDateFormat;
 
  var x = displayBelowThisObject.offsetLeft;
  var y = displayBelowThisObject.offsetTop + displayBelowThisObject.offsetHeight ;
 
  // deal with elements inside tables and such
  var parent = displayBelowThisObject;
  while (parent.offsetParent) {
    parent = parent.offsetParent;
    x += parent.offsetLeft;
    y += parent.offsetTop ;
  }
 
  drawDatePicker(targetDateField, x, y);
}


/**
Draw the datepicker object (which is just a table with calendar elements) at the
specified x and y coordinates, using the targetDateField object as the input tag
that will ultimately be populated with a date.

This function will normally be called by the displayDatePicker function.
*/
function drawDatePicker(targetDateField, x, y)
{
  var dt = getFieldDate(targetDateField.value );
 
  // the datepicker table will be drawn inside of a <div> with an ID defined by the
  // global datePickerDivID variable. If such a div doesn't yet exist on the HTML
  // document we're working with, add one.
  if (!document.getElementById(datePickerDivID)) {
    // don't use innerHTML to update the body, because it can cause global variables
    // that are currently pointing to objects on the page to have bad references
    //document.body.innerHTML += "<div id='" + datePickerDivID + "' class='dpDiv'></div>";
    var newNode = document.createElement("div");
    newNode.setAttribute("id", datePickerDivID);
    newNode.setAttribute("class", "dpDiv");
    newNode.setAttribute("style", "visibility: hidden;");
    document.body.appendChild(newNode);
  }
 
  // move the datepicker div to the proper x,y coordinate and toggle the visiblity
  var pickerDiv = document.getElementById(datePickerDivID);
  pickerDiv.style.position = "absolute";
  pickerDiv.style.left = x + "px";
  pickerDiv.style.top = y + "px";
  pickerDiv.style.visibility = (pickerDiv.style.visibility == "visible" ? "hidden" : "visible");
  pickerDiv.style.display = (pickerDiv.style.display == "block" ? "none" : "block");
  pickerDiv.style.zIndex = 10000;
 
  // draw the datepicker table
  refreshDatePicker(targetDateField.name, dt.getFullYear(), dt.getMonth(), dt.getDate());
}


/**
This is the function that actually draws the datepicker calendar.
*/
function refreshDatePicker(dateFieldName, year, month, day)
{
  // if no arguments are passed, use today's date; otherwise, month and year
  // are required (if a day is passed, it will be highlighted later)
  var thisDay = new Date();
 
  if ((month >= 0) && (year > 0)) {
    thisDay = new Date(year, month, 1);
  } else {
    day = thisDay.getDate();
    thisDay.setDate(1);
  }
 
  // the calendar will be drawn as a table
  // you can customize the table elements with a global CSS style sheet,
  // or by hardcoding style and formatting elements below
  var crlf = "\r\n";
  var TABLE = "<table cols=7 class='dpTable'>" + crlf;
  var xTABLE = "</table>" + crlf;
  var TR = "<tr class='dpTR'>";
  var TR_title = "<tr class='dpTitleTR'>";
  var TR_days = "<tr class='dpDayTR'>";
  var TR_todaybutton = "<tr class='dpTodayButtonTR'>";
  var xTR = "</tr>" + crlf;
  var TD = "<td class='dpTD' onMouseOut='this.className=\"dpTD\";' onMouseOver=' this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
  var TD_title = "<td colspan=5 class='dpTitleTD'>";
  var TD_buttons = "<td class='dpButtonTD'>";
  var TD_todaybutton = "<td colspan=7 class='dpTodayButtonTD'>";
  var TD_days = "<td class='dpDayTD'>";
  var TD_selected = "<td class='dpDayHighlightTD' onMouseOut='this.className=\"dpDayHighlightTD\";' onMouseOver='this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
  var xTD = "</td>" + crlf;
  var DIV_title = "<div class='dpTitleText'>";
  var DIV_selected = "<div class='dpDayHighlight'>";
  var xDIV = "</div>";
 
  // start generating the code for the calendar table
  var html = TABLE;
 
  // this is the title bar, which displays the month and the buttons to
  // go back to a previous month or forward to the next month
  html += TR_title;
  html += TD_buttons + getButtonCode(dateFieldName, thisDay, -1, "&lt;") + xTD;
  html += TD_title + DIV_title + monthArrayLong[ thisDay.getMonth()] + " " + thisDay.getFullYear() + xDIV + xTD;
  html += TD_buttons + getButtonCode(dateFieldName, thisDay, 1, "&gt;") + xTD;
  html += xTR;
 
  // this is the row that indicates which day of the week we're on
  html += TR_days;
  for(i = 0; i < dayArrayShort.length; i++)
    html += TD_days + dayArrayShort[i] + xTD;
  html += xTR;
 
  // now we'll start populating the table with days of the month
  html += TR;
 
  // first, the leading blanks
  for (i = 0; i < thisDay.getDay(); i++)
    html += TD + "&nbsp;" + xTD;
 
  // now, the days of the month
  do {
    dayNum = thisDay.getDate();
    TD_onclick = " onclick=\"updateDateField('" + dateFieldName + "', '" + getDateString(thisDay) + "');\">";
    
    if (dayNum == day)
      html += TD_selected + TD_onclick + DIV_selected + dayNum + xDIV + xTD;
    else
      html += TD + TD_onclick + dayNum + xTD;
    
    // if this is a Saturday, start a new row
    if (thisDay.getDay() == 6)
      html += xTR + TR;
    
    // increment the day
    thisDay.setDate(thisDay.getDate() + 1);
  } while (thisDay.getDate() > 1)
 
  // fill in any trailing blanks
  if (thisDay.getDay() > 0) {
    for (i = 6; i > thisDay.getDay(); i--)
      html += TD + "&nbsp;" + xTD;
  }
  html += xTR;
 
  // add a button to allow the user to easily return to today, or close the calendar
  var today = new Date();
  var todayString = "Today is " + dayArrayMed[today.getDay()] + ", " + monthArrayMed[ today.getMonth()] + " " + today.getDate();
  html += TR_todaybutton + TD_todaybutton;
  html += "<button class='dpTodayButton' onClick='refreshDatePicker(\"" + dateFieldName + "\");'>this month</button> ";
  html += "<button class='dpTodayButton' onClick='updateDateField(\"" + dateFieldName + "\");'>close</button>";
  html += xTD + xTR;
 
  // and finally, close the table
  html += xTABLE;
 
  document.getElementById(datePickerDivID).innerHTML = html;
  // add an "iFrame shim" to allow the datepicker to display above selection lists
  adjustiFrame();
}


/**
Convenience function for writing the code for the buttons that bring us back or forward
a month.
*/
function getButtonCode(dateFieldName, dateVal, adjust, label)
{
  var newMonth = (dateVal.getMonth () + adjust) % 12;
  var newYear = dateVal.getFullYear() + parseInt((dateVal.getMonth() + adjust) / 12);
  if (newMonth < 0) {
    newMonth += 12;
    newYear += -1;
  }
 
  return "<button class='dpButton' onClick='refreshDatePicker(\"" + dateFieldName + "\", " + newYear + ", " + newMonth + ");'>" + label + "</button>";
}


/**
Convert a JavaScript Date object to a string, based on the dateFormat and dateSeparator
variables at the beginning of this script library.
*/
function getDateString(dateVal)
{
  var dayString = "00" + dateVal.getDate();
  var monthString = "00" + (dateVal.getMonth()+1);
  dayString = dayString.substring(dayString.length - 2);
  monthString = monthString.substring(monthString.length - 2);
 
  switch (dateFormat) {
    case "dmy" :
      return dayString + dateSeparator + monthString + dateSeparator + dateVal.getFullYear();
    case "ymd" :
      return dateVal.getFullYear() + dateSeparator + monthString + dateSeparator + dayString;
    case "mdy" :
    default :
      return monthString + dateSeparator + dayString + dateSeparator + dateVal.getFullYear();
  }
}


/**
Convert a string to a JavaScript Date object.
*/
function getFieldDate(dateString)
{
  var dateVal;
  var dArray;
  var d, m, y;
 
  try {
    dArray = splitDateString(dateString);
    if (dArray) {
      switch (dateFormat) {
        case "dmy" :
          d = parseInt(dArray[0], 10);
          m = parseInt(dArray[1], 10) - 1;
          y = parseInt(dArray[2], 10);
          break;
        case "ymd" :
          d = parseInt(dArray[2], 10);
          m = parseInt(dArray[1], 10) - 1;
          y = parseInt(dArray[0], 10);
          break;
        case "mdy" :
        default :
          d = parseInt(dArray[1], 10);
          m = parseInt(dArray[0], 10) - 1;
          y = parseInt(dArray[2], 10);
          break;
      }
      dateVal = new Date(y, m, d);
    } else if (dateString) {
      dateVal = new Date(dateString);
    } else {
      dateVal = new Date();
    }
  } catch(e) {
    dateVal = new Date();
  }
 
  return dateVal;
}


/**
Try to split a date string into an array of elements, using common date separators.
If the date is split, an array is returned; otherwise, we just return false.
*/
function splitDateString(dateString)
{
  var dArray;
  if (dateString.indexOf("/") >= 0)
    dArray = dateString.split("/");
  else if (dateString.indexOf(".") >= 0)
    dArray = dateString.split(".");
  else if (dateString.indexOf("-") >= 0)
    dArray = dateString.split("-");
  else if (dateString.indexOf("\\") >= 0)
    dArray = dateString.split("\\");
  else
    dArray = false;
 
  return dArray;
}

/**
Update the field with the given dateFieldName with the dateString that has been passed,
and hide the datepicker. If no dateString is passed, just close the datepicker without
changing the field value.

Also, if the page developer has defined a function called datePickerClosed anywhere on
the page or in an imported library, we will attempt to run that function with the updated
field as a parameter. This can be used for such things as date validation, setting default
values for related fields, etc. For example, you might have a function like this to validate
a start date field:

function datePickerClosed(dateField)
{
  var dateObj = getFieldDate(dateField.value);
  var today = new Date();
  today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
 
  if (dateField.name == "StartDate") {
    if (dateObj < today) {
      // if the date is before today, alert the user and display the datepicker again
      alert("Please enter a date that is today or later");
      dateField.value = "";
      document.getElementById(datePickerDivID).style.visibility = "visible";
      adjustiFrame();
    } else {
      // if the date is okay, set the EndDate field to 7 days after the StartDate
      dateObj.setTime(dateObj.getTime() + (7 * 24 * 60 * 60 * 1000));
      var endDateField = document.getElementsByName ("EndDate").item(0);
      endDateField.value = getDateString(dateObj);
    }
  }
}

*/
function updateDateField(dateFieldName, dateString)
{
  var targetDateField = document.getElementsByName (dateFieldName).item(0);
  if (dateString)
    targetDateField.value = dateString;
 
  var pickerDiv = document.getElementById(datePickerDivID);
  pickerDiv.style.visibility = "hidden";
  pickerDiv.style.display = "none";
 
  adjustiFrame();
  targetDateField.focus();
 
  // after the datepicker has closed, optionally run a user-defined function called
  // datePickerClosed, passing the field that was just updated as a parameter
  // (note that this will only run if the user actually selected a date from the datepicker)
  if ((dateString) && (typeof(datePickerClosed) == "function"))
    datePickerClosed(targetDateField);
}


/**
Use an "iFrame shim" to deal with problems where the datepicker shows up behind
selection list elements, if they're below the datepicker. The problem and solution are
described at:

http://dotnetjunkies.com/WebLog/jking/archive/2003/07/21/488.aspx
http://dotnetjunkies.com/WebLog/jking/archive/2003/10/30/2975.aspx
*/
function adjustiFrame(pickerDiv, iFrameDiv)
{
  // we know that Opera doesn't like something about this, so if we
  // think we're using Opera, don't even try
  var is_opera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);
  if (is_opera)
    return;
  
  // put a try/catch block around the whole thing, just in case
  try {
    if (!document.getElementById(iFrameDivID)) {
      // don't use innerHTML to update the body, because it can cause global variables
      // that are currently pointing to objects on the page to have bad references
      //document.body.innerHTML += "<iframe id='" + iFrameDivID + "' src='javascript:false;' scrolling='no' frameborder='0'>";
      var newNode = document.createElement("iFrame");
      newNode.setAttribute("id", iFrameDivID);
      newNode.setAttribute("src", "javascript:false;");
      newNode.setAttribute("scrolling", "no");
      newNode.setAttribute ("frameborder", "0");
      document.body.appendChild(newNode);
    }
    
    if (!pickerDiv)
      pickerDiv = document.getElementById(datePickerDivID);
    if (!iFrameDiv)
      iFrameDiv = document.getElementById(iFrameDivID);
    
    try {
      iFrameDiv.style.position = "absolute";
      iFrameDiv.style.width = pickerDiv.offsetWidth;
      iFrameDiv.style.height = pickerDiv.offsetHeight ;
      iFrameDiv.style.top = pickerDiv.style.top;
      iFrameDiv.style.left = pickerDiv.style.left;
      iFrameDiv.style.zIndex = pickerDiv.style.zIndex - 1;
      iFrameDiv.style.visibility = pickerDiv.style.visibility ;
      iFrameDiv.style.display = pickerDiv.style.display;
    } catch(e) {
    }
 
  } catch (ee) {
  }
 
}


</script>

  </head>
<style>
body {
	font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
	font-size: .8em;
	}

/* the div that holds the date picker calendar */
.dpDiv {
	}


/* the table (within the div) that holds the date picker calendar */
.dpTable {
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: center;
	color: #505050;
	background-color: #ece9d8;
	border: 1px solid #AAAAAA;
	}


/* a table row that holds date numbers (either blank or 1-31) */
.dpTR {
	}


/* the top table row that holds the month, year, and forward/backward buttons */
.dpTitleTR {
	}


/* the second table row, that holds the names of days of the week (Mo, Tu, We, etc.) */
.dpDayTR {
	}


/* the bottom table row, that has the "This Month" and "Close" buttons */
.dpTodayButtonTR {
	}


/* a table cell that holds a date number (either blank or 1-31) */
.dpTD {
	border: 1px solid #ece9d8;
	}


/* a table cell that holds a highlighted day (usually either today's date or the current date field value) */
.dpDayHighlightTD {
	background-color: #CCCCCC;
	border: 1px solid #AAAAAA;
	}


/* the date number table cell that the mouse pointer is currently over (you can use contrasting colors to make it apparent which cell is being hovered over) */
.dpTDHover {
	background-color: #aca998;
	border: 1px solid #888888;
	cursor: pointer;
	color: red;
	}


/* the table cell that holds the name of the month and the year */
.dpTitleTD {
	}


/* a table cell that holds one of the forward/backward buttons */
.dpButtonTD {
	}


/* the table cell that holds the "This Month" or "Close" button at the bottom */
.dpTodayButtonTD {
	}


/* a table cell that holds the names of days of the week (Mo, Tu, We, etc.) */
.dpDayTD {
	background-color: #CCCCCC;
	border: 1px solid #AAAAAA;
	color: white;
	}


/* additional style information for the text that indicates the month and year */
.dpTitleText {
	font-size: 12px;
	color: gray;
	font-weight: bold;
	}


/* additional style information for the cell that holds a highlighted day (usually either today's date or the current date field value) */ 
.dpDayHighlight {
	color: 4060ff;
	font-weight: bold;
	}


/* the forward/backward buttons at the top */
.dpButton {
	font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: gray;
	background: #d8e8ff;
	font-weight: bold;
	padding: 0px;
	}


/* the "This Month" and "Close" buttons at the bottom */
.dpTodayButton {
	font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: gray;
	background: #d8e8ff;
	font-weight: bold;
	}
</style>
<body>

<?php
/**
 * Test to make sure the person has the right userlevel to be here
 */

$status = $session->status;
$stat = ($status & 0x400 || $status & 0x8000);

if($stat)	{

echo "<br/><a href=\"unit_details.php\"><img 
src=\"images/return.jpg\"></a>";
?>
<h1>Add Detail</h1>
<?php
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
} 
$q = "SELECT f_name, l_name FROM ".TBL_USERS." WHERE status & 2 ORDER BY l_name";
$result = $database->query($q);



/* Check for Errors in Reading Table */
$num_rows = mysql_num_rows($result);

if(!$result || ($num_rows < 0))	{
	echo "Query to select all users from users table failed";
}

/* Build the string to create the option values for the drop down */
$option = "";
$option = $option."<option value=\"\" ></option>";
$option = $option."<option value=\"\" >------?------</OPTION>";

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))	{
	$name = $row['l_name'] . ', ' . $row['f_name'];
	$option = $option."<option value=\"$name\">$name</option>";
}

/* Close off the Select tag */
$option = $option."</select>";

?>
<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" 
cellpadding="3">
<tr>
	<td>Date: (yyyy-mm-dd)</td>
	<td> <input type="text" id="calendar" name="calendar" /></td>
	<td><input type=button value="select date" onClick="displayDatePicker('calendar', this,'ymd', '-');"></td>
</tr>
<tr>
	<td>Detail Type:</td>
	<td><select name="detail_type" id="detail_type" style="" 
onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);">
		<option value="" ></option>
		<option value="" >------?------</option>
		<option value="Baseball">Baseball</option>
		<option value="Basketball">Basketball</option>
		<option value="Beauty Pageant">Beauty Pageant</option>
		<option value="Birthday Party">Birthday Party</option>
		<option value="Chevron Security">Chevron Security</option>
		<option value="Chevron Traffic">Chevron Traffic</option>
		<option value="Christmas Party">Christmas Party</option>
		<option value="Dinner">Dinner</option>
		<option value="Family Reunion">Family Reunion</option>
		<option value="Football">Football</option>
		<option value="Mardi Gras Party">Mardi Gras Party</option>
		<option value="New Years Eve Party">New Years Eve Party</option>
		<option value="Soccer">Soccer</option>
		<option value="Softball">Softball</option>
		<option value="Shelter Security">Shelter Security</option>
		<option value="Shower">Shower</option>
		<option value="Traffic Control">Traffic Control</option>
		
		<option value="Volleyball">Volleyball</option>
		<option value="Wedding">Wedding</option>
		<option value="Wedding Anniversary">Wedding Anniversary</option>
		<option value="Wedding Reception">Wedding Reception</option>
		
	<td></td>
</tr>
<tr>
	<td>Detail Location:</td>
	<td><select name="detail_location" id="detail_location" style="" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);">
		<option value="" ></option>
		<option value="" >------?------</OPTION>
		<option value="Cedar Grove Community Center">Cedar Grove Community Center</option>
		<option value="Chevron Refinery - $30 per hour">Chevron Refinery</option>
		<option value="East Central Community Center">East Central Community Center</option>
		<option value="East Central High School">East Central High School</option>
		<option value="East Central Middle School"> East Central Middle School</option>
		<option value="East Central Safe Room">East Central Safe Room
		<option value="Eastside Community Center">Eastside Community Center</option>
		<option value="Escatawpa Community Center">Escatawpa Community Center</option>
		<option value="Fountainbleau Community Center">Fountainbleau Community Center</option>
		<option value="Latimer Community Center">Latimer Community Center</option>
		<option value="MDOT Traffic - $30 per hour">MDOT Traffic</option>
		<option value="Orange Grove Community Center">Orange Grove Community Center</option>
		<option value="Pelican Landing Center">Pelican Landing</option>
		<option value="St Martin Community Center">St Martin Community Center</option>
		<option value="St Martin High School">St Martin High School</option>
		<option value="St Martin Middle School">St Martin Middle School</option>
		<option value="St Martin Safe Room">St Martin Safe Room</option>
		<option value="Vancleave Arena">Vancleave Arena</option>
		<option value="Vancleave High School">Vancleave High School</option>
		<option value="Vancleave Community Center">Vancleave Community Center</option>
		<option value="Vancleave Middle School">Vancleave Middle School</option>
		<option value="Vancleave Safe Room">Vancleave Safe Room</option>
    <option value="Warren Paving">Warren Paving</option>
		</select></td>
	<td></td>
</tr>
<tr>
	<td>Start Time:</td><td><select name="start_time" >
		<option value=" "> </option>
		<option value="00:00">Midnight</option>
		<option value="00:30">0:30 AM</option>
		<option value="01:00">1:00 AM</option>
		<option value="01:30">1:30 AM</option>
		<option value="02:00">2:00 AM</option>
		<option value="02:30">2:30 AM</option>
		<option value="03:00">3:00 AM</option>
		<option value="04:00">4:00 AM</option>
		<option value="05:00">5:00 AM</option>
		<option value="05:30">5:30 AM</option>
		<option value="6:00">6:00 AM</option>
		<option value="6:30">6:30 AM</option>
		<option value="7:00">7:00 AM</option>
		<option value="7:30">7:30 AM</option>
		<option value="8:00">8:00 AM</option>
		<option value="8:30">8:30 AM</option>
		<option value="9:00">9:00 AM</option>
		<option value="9:30">9:30 AM</option>
		<option value="10:00">10:00 AM</option>
		<option value="10:30">10:30 AM</option>
		<option value="11:00">11:00 AM</option>
		<option value="11:30">11:30 AM</option>
		<option value="12:00">12:00 Noon</option>
		<option value="12:30">12:30 PM</option>
		<option value="13:00">1:00 PM</option>
		<option  value="13:30">1:30 PM</option>
		<option value="14:00">2:00 PM</option>
		<option value="14:30">2:30 PM</option>
		<option value="15:00">3:00 PM</option>
		<option value="15:30">3:30 PM</option>
		<option value="16:00">4:00 PM</option>
		<option value="16:30">4:30 PM</option>
		<option value="17:00">5:00 PM</option>
		<option value="17:30">5:30 PM</option>
		<option value="18:00">6:00 PM</option>
		<option value="18:30">6:30 PM</option>
		<option value="19:00">7:00 PM</option>
		<option value="19:30">7:30 PM</option>
		<option value="20:00">8:00 PM</option>
		<option value="20:30">8:30 PM</option>
		<option value="21:00">9:00 PM</option>
		<option value="21:30">9:30 PM</option>
		<option value="22:00">10:00 PM</option>
		<option value="22:30">10:30 PM</option>
		<option value="23:00">11:00 PM</option>
		<option value="23:30">11:30 PM</option></select></td>


	<td></td>									
</tr>
<tr>
	<td>End Time:</td>
	<td><select name="end_time" >
		<option value=" "> </option>
		<option value="24:00">Midnight</option>
		<option value="00:30">0:30 AM</option>
		<option value="01:00">1:00 AM</option>
		<option value="01:30">1:30 AM</option>
		<option value="02:00">2:00 AM</option>
		<option value="02:30">2:30 AM</option>
		<option value="03:00">3:00 AM</option>
		<option value="04:00">4:00 AM</option>
		<option value="05:00">5:00 AM</option>
		<option value="05:30">5:30 AM</option>
		<option value="6:00">6:00 AM</option>
		<option value="6:30">6:30 AM</option>
		<option value="7:00">7:00 AM</option>
		<option value="7:30">7:30 AM</option>
		<option value="8:00">8:00 AM</option>
		<option value="8:30">8:30 AM</option>
		<option value="9:00">9:00 AM</option>
		<option value="9:30">9:30 AM</option>
		<option value="10:00">10:00 AM</option>
		<option value="10:30">10:30 AM</option>
		<option value="11:00">11:00 AM</option>
		<option value="11:30">11:30 AM</option>
		<option value="12:00">12:00 Noon</option>
		<option value="12:30">12:30 PM</option>
		<option value="13:00">1:00 PM</option>
		<option  value="13:30">1:30 PM</option>
		<option value="14:00">2:00 PM</option>
		<option value="14:30">2:30 PM</option>
		<option value="15:00">3:00 PM</option>
		<option value="15:30">3:30 PM</option>
		<option value="16:00">4:00 PM</option>
		<option value="16:30">4:30 PM</option>
		<option value="17:00">5:00 PM</option>
		<option value="17:30">5:30 PM</option>
		<option value="18:00">6:00 PM</option>
		<option value="18:30">6:30 PM</option>
		<option value="19:00">7:00 PM</option>
		<option value="19:30">7:30 PM</option>
		<option value="20:00">8:00 PM</option>
		<option value="20:30">8:30 PM</option>
		<option value="21:00">9:00 PM</option>
		<option value="21:30">9:30 PM</option>
		<option value="22:00">10:00 PM</option>
		<option value="22:30">10:30 PM</option>
		<option value="23:00">11:00 PM</option>
		<option value="23:30">11:30 PM</option></select></td>
	<td></td>
</tr>
<tr>
	<td>Contact Person:</td>
	<td><input type="text" name="contact" maxlength="30" value="<?php echo $form->value("contact");?>"></td>
	<td> <?php echo $form->error("contact");?></td>
</tr>
<tr>
	<td>Number Officers Needed:</td>
	<td><input type="text" name="num_officers" maxlength="4" value="<?php echo $form->value("num_officers");?>"></td>
	<td><?php echo $form->error("num_officers");?></td>
</tr>
<tr>
	<td>Officer 1:</td>
	<td><select name="officer_1" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
    <option value=""></option><?php echo "$option"?></td>
	<td></td>
</tr>
<tr>
	<td>Officer 2:</td>
	<td><select name="officer_2" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>		
</tr>
<tr>
	<td>Officer 3:</td>
	<td><select name="officer_3" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 4:</td>
	<td><select name="officer_4" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 5:</td>
	<td><select name="officer_5" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 6:</td>
	<td><select name="officer_6" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 7:</td>
	<td><select name="officer_7" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 8:</td>
	<td><select name="officer_8" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 9:</td>
	<td><select name="officer_9" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Officer 10:</td>
	<td><select name="officer_10" onKeyDown="fnKeyDownHandler(this, event);" 
		onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  
		onChange="fnChangeHandler_A(this, event);>
		<option value=""></option><?php echo "$option"?></td>
	<td></td>	
</tr>
<tr>
	<td>Paid:</td>
	    <td>$15<input type="radio" name="paid" value=15 checked></td>
	    <td>$20<input type="radio" name="paid" value=20></td>
	    <td>$25<input type="radio" name="paid" value=25></td>
	    <td>$30<input type="radio" name="paid" value=30></td>
	    <td>No <input type="radio" name="paid" value=0> </td>
</tr>
<tr>
	<td colspan="3" style="color:#900; font-size:18px" align="center"><strong>NOTE:</strong> Manually added people must appear above the Auxiliary Officers in order for the program to work correctly.</td>
</tr>

<tr>
	<td colspan="2" align="right">
		<input type="hidden" name="subdetail" value="1">
		<input type="submit" value="Add Detail"></td>
	<td></td>		
</tr>
</table>
</form>

<?php
}
else	{
	echo "You do not have the proper user level to access this form.<br/>";
	echo "Contact the administrator if you feel that this is incorrect.<br/>";
	echo "<br/>Click [<a href=\"main.php\">here</a>] to continue.";
}
?>

</body>
</html>

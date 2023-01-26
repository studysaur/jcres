<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Jackson County Mounted Patrol - Roster</title>
	<meta charset="utf-8">
	<meta name="author" content="Jeffrey Clark">
	<!-- internal styles -->
	<style>
	body	{
		font-family: Verdana, Geneva, sans-serif;
		background-color: #FFF;
		padding: 50px;
	}
	
	
	ul#mainMenu, ul.sub1	{
		list-style-type:none;
		font-size:10px;
	}
	
	ul#mainMenu li  {
		width: 100px;
		text-align: center;
		position:relative;
		float: left;
		margin-right: 4px;
	}
	
	ul#mainMenu a {
		text-decoration:none;
		display:block;
		width: 100px;
		height:20px;
		color:#CCC;
		padding-top:7px;	
		background-color: #006;
		border: 1px solid #CCC;
		border-radius: 5px;
	}
	
	ul#mainMenu .sub1 a {
		margin-top: 0px;
	}
	
	ul#mainMenu li:hover > a	{
		background-color: #3366FF;
		color:#003;
	}
	
	ul#mainMenu li:hover a:hover {
		background-color: #3366FF;
	}
	
	
	ul#mainMenu ul.sub1 {
		display:block;
		position:absolute;
		left: 0px;
	}
	
	ul#mainMenu li:hover .sub1 {
		display:block;
	}

	</style> 

</head>
<body bgcolor="#FFFFFF" lang=EN-US>
<ul id="mainMenu" style="width:1170px">
	<li><a href="index.php">Home</a></li>
	<li><a href="mounted_patrol_roster.php">Current Roster</a></li>
	<li><a href="unit_details.php">Unit Details</a></li>
	<li><a href="personal_detail_sheet.php">Account Balance</a></li>
	<li><a href="citation_report.php">Various Reports</a></li>
	<li><a href="./admin/admin.php">Admin Center</a></li>
       <li><a href="#">My Account</a></li>
	<li><a href="process.php">Logout</a></li>
	<li><a href="#">Members Online</a>
		<ul class="sub1">
               <li><a href="#">Just You</a></li>
             </ul> 
       </li>
</ul>
<div>
  <br>
  <h1>Heading One</h1>
  <p>This is just some text for heading 1</p>

  <h1>Heading Two</h1>
  <p>Here is some text for heading 2</p>

  <h1>Heading Three</h1>
  <p>And here is some text for the last heading</p>
</div>
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>

<script type="text/javascript" src="my_code.js"></script>

</body>
</html>
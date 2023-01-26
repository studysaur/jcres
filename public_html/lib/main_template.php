<?php
require_once 'startsession.php';

print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";

require_once '../jcres_connect.php';

require_once 'user.php';

require_once 'new_menu.php';

/*
 * The main_template.php is the base template for the default style of pages.
 * The general concept, define a method named "jcres_content()" in a seperate
 * PHP file to fill in the main content block, while defining the rest of the
 * page content and structure here.
 *
 * Benefit over the multiple PHP files is all tags open and close in the same
 * file so you don't have to guess where one div opened, and where it ended.
 */
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!-- disable iPhone initial scale -->
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<title><?php print $page_title ?> Jackson County Sheriff Auxillary</title>
		<meta http-equiv="X-UA-Compatibible" content="IE=edge" />
		<meta name="keywords" content="jackson county, reserves, sheriff, mississippi, gulf coast" />
		<link rel="stylesheet" href="lib/new_main.css" type="text/css">
	</head>
	<body>
		<div class="page-view">
			<div class="top-view">
				<div class="header-badge"><img src="images/badge150.png" width="100%" /></div>
				<div class="header-group">
					<div class="header-text">Jackson County Sheriff Reserves</div>
				</div>
<?php
	jcres_menu();
?>
			</div>
			<div class="main-view">
<?php
	jcres_content();
?>
				</div>
<?php
	if ($errorMessage != '') {
?>
				<div class="error">
					<?php print $errorMessage; ?>
				</div>
<?php
	}
?>
				<div class="footer">
					<p> If you are looking
					for the official Jackson County Sheriff web site, you can find it <a
					href="http://www.co.jackson.ms.us/officials/sheriff/index.php"
					target="_blank">here</a>.</p> 
					<p>This web site was designed and
					hosted by a volunteer and are not official pages of Jackson County, MS or
					the Sheriff's Office</p>
				</div>
			</div>
		</div>
	</body>
</html>
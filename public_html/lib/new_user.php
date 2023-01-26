<?php
	require_once("lib/user.php");
	/*
	 * This function writes this pages content to the stream
	 */
	function jcres_content() {


?>
		<div class="main-content">
			    <h2>lib/New_user</h2>
	    <p>under construction </p>
		</div>
<?php
	}

	// Now that the function jcres_content has been defined, call the main_template.php
	// Since main_template.php calls jcres_content, the function must be defined first.
	require_once 'lib/main_template.php';

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream
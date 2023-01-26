<?php
try {
	/*
	 * This function writes this pages content to the stream
	 */
	function jcres_content() {
		// We end PHP processing, so the text editor can highlight HTML syntex.
		// We could replace with "print<<<EOT ... EOT;" but text editors will
		// highlight the entire thing as a string element.
?>
		<div class="main-content">
			<h2>Who we are</h2>
			<p>The Sheriff Auxillary Division of the Jackson County Sheriff's Department
			is comprised of fully commisioned deputies who volunteer their time to the
			Sheriff's Department and citizens of Jackson County, Mississippi.</p>
			<h2>Mission</h2> 
			<p>Our mission is to assist the Sheriff's Department in
			protecting and serving the citizens of Jackson County. The Reserves fulfill
			this mission by providing officers and equipment augment the Sheriff's
			Department search and rescue, as well as crowd control, traffic control,
			working security detail, working with other regular/Mounted Patrol officers,
			doing road patrol and any other duties that may be requested by the Sheriff.
			The Sheriff Reserves provide a highly visible presence in the community as a
			crime deterrent.</p>
		</div>
<?php
	}

	// Now that the function jcres_content has been defined, call the main_template.php
	// Since main_template.php calls jcres_content, the function must be defined first.
	require_once 'lib/main_template.php';

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream
} catch (Exception $e) {
	print $e->getMessage();
}

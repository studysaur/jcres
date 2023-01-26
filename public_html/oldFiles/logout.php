<?php
try {
	require_once '../jcres_connect.php';

	require_once 'lib/startsession.php';

	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Finally, destroy the session.
	session_destroy();

	/*
	 * This function writes this pages content to the stream
	 */
	function jcres_content() {
?>
		<div class="main-content">
			You have logged out.
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
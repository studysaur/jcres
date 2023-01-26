<?php
	require_once '../jcres_connect.php';

	session_start();

	$deleteOn = time() + 3600;
//	echo "<p> delete on = $deleteOn </p>";
/*	db_query("UPDATE session_info SET delete_on=NULL WHERE delete_on < ". time());

	if (db_update("UPDATE session_info SET delete_on=$deleteOn WHERE session_id='" . session_id() . "'") == 0) {
		db_query("INSERT INTO session_info (session_id, user_id, delete_on) VALUES ('" . session_id() . "', 0, $deleteOn)");
	}

	function setCurrentUser($id) {
		$sid = session_id();

		db_query("UPDATE session_info SET user_id=$id WHERE session_id='$sid'");
	}

	function getCurrentUser() {
		$sid = session_id();

		return mysqli_fetch_row(db_query("SELECT user_id FROM session_info WHERE session_id='$sid'"))[0];
	}

	function isLoggedIn() {
		return getCurrentUser() > 0;
	}
*/	
	// If the session vars aren't set, try to set them with a cookie
	if (!isset($_SESSION['user_id'])) {
		if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] > 0) {
			setCurrentUser($_COOKIE['user_id']);
		}
	}
?>
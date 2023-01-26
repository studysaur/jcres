<?php
/**
 * Load a list of roles for the current user (or guest if not logged in).
 */
function loadUserRoles($id = null) {
	$array = Array();

	if ($id == null) {
		$id = getCurrentUser();
	}

	if (isDatabaseConnected() && $id > 0) {
		// Pull current users roles from the database
		$query = "SELECT DISTINCT R.id FROM roles R LEFT JOIN user_roles X ON (R.id=X.role_id) WHERE X.user_id=$id OR R.type IN ('Default', 'User')";
	} else {
		$query = "SELECT DISTINCT R.id FROM roles R LEFT JOIN user_roles X ON (R.id=X.role_id) WHERE R.type IN ('Default', 'Guest')";
	}

	$result = db_query($query);
	if ($result) {
		while ($row = mysqli_fetch_row($result)) {
			$array[] = $row[0];
		}
	}

	return $array;
}

function myRoles() {
	$array = Array();

	$id = getCurrentUser();

	if (isDatabaseConnected() && $id > 0) {
		// Pull current users roles from the database
		$query = "SELECT DISTINCT R.* FROM roles R LEFT JOIN user_roles X ON (R.id=X.role_id) WHERE X.user_id=$id OR R.type IN ('Default', 'User')";
	} else {
		$query = "SELECT DISTINCT R.* FROM roles R LEFT JOIN user_roles X ON (R.id=X.role_id) WHERE R.type IN ('Default', 'Guest')";
	}

	$result = db_query($query);
	if ($result) {
		while ($row = mysqli_fetch_array($result)) {
			$array[] = $row;
		}
	}

	return $array;
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
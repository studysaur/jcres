<?php
	require_once("lib/user.php");
	/*
	 * This function writes this pages content to the stream
	 */
    session_start();
	function jcres_content() {
		global $errorMessage, $_GET;

		$post = 0;
		$canEdit = 1;
/*  
* This also allows the admin to edit other users. If somehow someone managed
* to get to this script, they still wouldn't be allowed to change someone elses
* information.
*/
?>
		<div class="main-content">
<?php
		$editSelf = db_fetch_row("SELECT MAX(R.edit_self) FROM roles R LEFT JOIN user_roles X ON (R.id=X.role_id) WHERE X.user_id=" . getCurrentUser())[0];
		$editOther = db_fetch_row("SELECT MAX(R.edit_other) FROM roles R LEFT JOIN user_roles X ON (R.id=X.role_id) WHERE X.user_id=" . getCurrentUser())[0];

		if ($editSelf == 1 && $editOther == 1) {
			$query = "SELECT id, first_name, last_name FROM users ORDER BY last_name, first_name";
		} else if ($editSelf == 1) {
			$query = "SELECT id, first_name, last_name FROM users WHERE id=" . getCurrentUser();
		} else if ($editOther == 1) {
			$query = "SELECT id, first_name, last_name FROM users WHERE id<>" . getCurrentUser();
		} else {
			$query = "SELECT id, first_name, last_name FROM users WHERE id=0";
		}

		if ($editOther == 1) {
				print<<<EOT
			<div><a href="new_user.php" id=new>[New User]</a></div>
EOT;
		}

		if ($result = db_query($query)) {
			while ($row = mysqli_fetch_row($result)) {
				print<<<EOT
			<div><a href="edit_user.php?id={$row[0]}">{$row[2]}, {$row[1]}</a></div>

EOT;
			}
		}
?>
		</div>
<?php
	}

	// Now that the function jcres_content has been defined, call the main_template.php
	// Since main_template.php calls jcres_content, the function must be defined first.
	require_once 'lib/main_template.php';

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream

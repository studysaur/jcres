<?php
	require_once '../jcres_connect.php';

	if (db_query("CREATE TABLE IF NOT EXISTS session_info (session_id VARCHAR(80) NOT NULL PRIMARY KEY, user_id BIGINT NOT NULL, delete_on BIGINT NOT NULL)")) {
		print "Created\n\n";
	} else {
		print $errorMessage . "\n\n";
	}

	/*
	db_query("DROP TABLE user_roles");
	db_query("DROP TABLE roles");
	db_query("DROP TABLE menu_roles");
	db_query("DROP TABLE menus");
	 */

	if (db_query("CREATE TABLE IF NOT EXISTS user_roles (id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, user_id BIGINT NOT NULL, role_id BIGINT NOT NULL, UNIQUE KEY (user_id, role_id))")) {
		print "Created\n\n";
	} else {
		print $errorMessage . "\n\n";
	}

	if ($errorMessage != '') {
		print $errorMessage . "\n\n";
	}

	$query =<<<EOT
CREATE TABLE IF NOT EXISTS roles (
	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(40) NOT NULL,
	view_self TINYINT NOT NULL DEFAULT 0,
	edit_self TINYINT NOT NULL DEFAULT 0,
	view_other TINYINT NOT NULL DEFAULT 0,
	edit_other TINYINT NOT NULL DEFAULT 0,
	type ENUM('Guest', 'Default', 'User', 'Assigned') NOT NULL DEFAULT 'Guest',
	UNIQUE KEY (name)
)

EOT;

	if (db_query($query)) {
		print "Created\n\n";
	} else {
		print $errorMessage . "\n\n";
	}

	if (db_query("CREATE TABLE IF NOT EXISTS menus (id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, parent_id BIGINT NOT NULL, label VARCHAR(40) NOT NULL, url VARCHAR(200) NOT NULL, sort_order INT NOT NULL, UNIQUE KEY (label))")) {
		print "Created\n\n";
	} else {
		print $errorMessage . "\n\n";
	}

	if (db_query("CREATE TABLE IF NOT EXISTS menu_roles (role_id BIGINT NOT NULL, menu_id BIGINT NOT NULL, UNIQUE KEY (role_id, menu_id))")) {
		print "Created\n\n";
	} else {
		print $errorMessage . "\n\n";
	}

	if (db_query("UPDATE users SET password=SHA1('test') WHERE id=2")) {
		print "Updated\n\n";
	} else {
		print $errorMessage . "\n\n";
	}

	/*
	db_query("INSERT INTO roles (name, view_self, edit_self, view_other, edit_other, type) VALUES ('Default', 0, 0, 0, 0, 'Default')") or die(mysqli_error($dbc));
	db_query("INSERT INTO roles (name, view_self, edit_self, view_other, edit_other, type) VALUES ('Guest', 0, 0, 0, 0, 'Guest')") or die(mysqli_error($dbc));
	db_query("INSERT INTO roles (name, view_self, edit_self, view_other, edit_other, type) VALUES ('User', 1, 1, 0, 0, 'User')") or die(mysqli_error($dbc));
	db_query("INSERT INTO roles (name, view_self, edit_self, view_other, edit_other, type) VALUES ('Admin', 1, 1, 1, 1, 'Assigned')") or die(mysqli_error($dbc));

	db_query("INSERT INTO menus (label, url, sort_order) VALUES ('Home', 'main_content.php', 0)") or die(mysqli_error($dbc));
	db_query("INSERT INTO menus (label, url, sort_order) VALUES ('Login', 'login.php', 1)") or die(mysqli_error($dbc));
	db_query("INSERT INTO menus (label, url, sort_order) VALUES ('Logout', 'logout.php', 1)") or die(mysqli_error($dbc));
	db_query("INSERT INTO menus (label, url, sort_order) VALUES ('Admin', 'admin.php', 10)") or die(mysqli_error($dbc));

	db_query("INSERT INTO menu_roles (role_id, menu_id) VALUES (1, 1)") or die(mysqli_error($dbc));
	db_query("INSERT INTO menu_roles (role_id, menu_id) VALUES (2, 2)") or die(mysqli_error($dbc));
	db_query("INSERT INTO menu_roles (role_id, menu_id) VALUES (3, 3)") or die(mysqli_error($dbc));
	db_query("INSERT INTO menu_roles (role_id, menu_id) VALUES (4, 4)") or die(mysqli_error($dbc));

	db_query("INSERT INTO user_roles (role_id, user_id) VALUES (1, 4)") or die(mysqli_error($dbc));
	db_query("INSERT INTO user_roles (role_id, user_id) VALUES (2, 4)") or die(mysqli_error($dbc));

	foreach ($roles as $role) {
		if ($result = db_query("SELECT id FROM roles WHERE name='$role'")) {
			if ($row = mysqli_query($result)) {
			} else {
			}
		}
	}
	 */

	if ($result = db_query("SHOW TABLES")) {
		while ($row = mysqli_fetch_row($result)) {
			$size = count($row);

			if ($res = db_query("SHOW CREATE TABLE " . $row[0])) {
				$row = mysqli_fetch_row($res);
				print $row[1] . "\n\n";
			} else {
				print "SHOW CREATE TABLE " . $row[0] . $errorMessage ."\n\n";
			}
		}
	}

	if ($result = db_query("SELECT * FROM users")) {
		print "<table>";

		while ($row = mysqli_fetch_row($result)) {
			print "<tr>";

			$size = count($row);

			for ($i=0; $i<$size; $i++) {
				print "<td>{$row[$i]}</td>";
			}

			print "</tr>";
		}

		print "<table>";
	}

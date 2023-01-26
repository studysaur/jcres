<?php
	
	require_once 'user.php';

	/*
	 * Function to load menus. As of this writing, only Home, Login and
	 * 'Contact Us' exist.
	 */
	function loadMenus() {
		$roles = loadUserRoles();

		$menus = Array();

		// Home -> index.php [default]
		// Login -> login.php [guest]
		// Admin -> admin.php [admin]
		// Contact Us -> contact.php [default]

		$r = implode($roles, ", ");
		$q = "SELECT M.label, M.url FROM menus M LEFT JOIN menu_roles X ON (X.menu_id=M.id) WHERE X.role_id in ($r) ORDER BY M.sort_order";

		if ($result = db_query($q)) {
			while ($row = mysqli_fetch_row($result)) {
				$menus[$row[0]] = $row[1];
			}
		}

		return $menus;
	}

	/*
	 * Function to print the menu to the stream
	 */
	function jcres_menu() {
		// First load the menus
		$menus = loadMenus();

		// Print the header div (Note: we don't use <ul>!)
		print<<<EOT
					<div class="header-menu">

EOT;

		// Loop through all items and write them to the stream
		foreach ($menus as $lbl => $href) {
			// Print the formated menu item (Note: we don't use <li>!)
			print<<<EOT
						<a class="menu-link" href="$href">$lbl</a>

EOT;
		}

		// Close the header div
		print<<<EOT
					</div>

EOT;
	}

	// Note: Don't end the PHP tag, it will ensure no stray characters are writen to the stream
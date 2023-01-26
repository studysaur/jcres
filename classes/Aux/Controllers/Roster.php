<?php # /Aux/Controllers/Roster.php

class Roster {
	private $usersTable;
	private $detailsTable;

	public function __construct() {
        $this->usersTable = new \Gen\DatabaseTable($pdo, 'users', 'uid', '\Aux\Entity\User', [&$this->detailsTable]);
        $this->detailsTable = new \Gen\DatabaseTable($pdo, 'details', 'detailNum', '\Aux\Entity\Details', [&$this->usersTable]);
    }


}
<?php
namespace Aux\Controllers;
use \Gen\DatabaseTable;
use \Gen\Authentication;

class Details {
	private $usersTable;
	private $detailsTable;
	private $authentication;

	public function __construct(DatabaseTable $detailsTable, DatabaseTable $usersTable, Authentication $authentication) {
		$this->usersTable = $usersTable;
		$this->detailsTable = $detailsTable;
		$this->authentication = $authentication;
	}
	public function dlist() {

		$details = $this->detailsTable->find('sheetPosted', '0000-00-00', 'date' );

		$title = 'Details';

		$user = $this->authentication->getUser();
		if(($_SESSION['status']&\Aux\Entity\User::EDIT_DETAILS) == \Aux\Entity\User::EDIT_DETAILS){
			$detail = ['detail', 'detaila'];
		} else {
			$detail = ['detail', 'detailr'];
		}
		return ['template' => 'Aux/details.html.php',
				'title' => $title,
				'cssa' => $detail,
				'variables' => [
						'details' => $details
						]
			];
		}
		

}
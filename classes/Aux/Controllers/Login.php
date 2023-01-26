<?php
namespace Aux\Controllers;

class Login {
	const CCHK = 0X59183301;
	const CHK = 0X8081100;


	private $authentication;

	public function __construct(\Gen\Authentication $authentication) {
		$this->authentication = $authentication;
	}
	public function loginForm() {
		return ['template' => '/Aux/login.html.php',
			 		'title' => 'Log in',
					'cssa' => ['log']
	];
	}
	public function processLogin() {
		//$_SESSION['jscrpt']=$POST['jscrpt'];
		if ($this->authentication->login($_POST['username'], $_POST['password'])) {
			$status = $_SESSION['status'];
			if (!$this->isValidUser()) {
				$_SESSION['password'] = 'STATUS';
				header('location: /login/status');	
				exit;		
			}
			if ($this->isDisabled()) {
				$_SESSION['password'] = '';
				header('location: /login/disabled');
				exit;
			} 
				header('location: /login/success');
			} else {
				return ['template' => 'Aux/login.html.php',
				            'title' => 'Log In',
				            'variables' => [
					            'error' => 'Invalid username/password.',
				            	'cssa'	=> ['log', 'table']
							]
			            ];
			}
	}
	public function isValidUser() {
		if (($_SESSION['status'] & self::CCHK) == self::CHK) {
			$_SESSION['validuser'] = 'true';
			return true;
		} else {
			$_SESSION['validuser'] = 'false';
			return false;
		}
	}
	public function isDisabled() {
		if (($_SESSION['status'] & \Aux\Entity\User::DISABLE) == \Aux\Entity\User::DISABLE) {
			return true;
		}
	}
	public function isLOA() {
		if (($_SESSION['status'] & \Aux\Entity\User::LOA) == \Aux\Entity\User::LOA) {
			return true;
		}
	}
	public function disable() {
		return ['template' => 'Aux/disabled.html.php', 'title' => 'Disabled account'];
	}
	public function loa() {
		return ['template' => 'Aux/loginloa.html.php', 'title' => 'Leave of absence'];
	}
	public function status() {
		return ['template' => 'Aux/loginstatus.html.php', 'title' => 'Status Problem'];
	} 
	public function success() {
		return ['template' => 'Aux/loginsuccess.html.php', 'title' => 'Login Successful'];
	}
	public function error() {
		return ['template' => 'Aux/loginerror.html.php', 'title' => 'You are not logged in'];
	}
/*	public function permissionsError() {
		return ['template' => 'Aux/permissionserror.html.php', 'title' => 'Access Denied'];
	} */
	public function logout() {
		if (session_status() === PHP_SESSION_ACTIVE) {
		unset($_SESSION);
		session_destroy();
		}
		return ['template' => 'Aux/home.html.php', 'title' => 'You have been logged out'];
	}
	public function home() {
		$title = 'Home';
		$css = 'log';
		return ['template' => 'Aux/home.html.php', 'title' => $title, 'css' => $css];
	}
} 
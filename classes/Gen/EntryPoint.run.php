<?php
namespace Gen;
class EntryPoint {
	private $route;
	private $method;
	private $routes;
	
	public function __construct($route) {
		$this->route = $route;
		$this->checkUrl();
	}
	
    private function checkUrl() {
    	if ($this->route !== strtolower($this->route)) {
    		http_response_code(301);
    		header('location: ' . strtolower($this->route));
	}
}

    private function loadTemplate($templateFileName, $variables = []) {
    	extract($variables);
	
    	ob_start();
    	include __DIR__ . '/../../templates/' . $templateFileName;
	
	return ob_get_clean();
	}

    private function callAction() {
		include __DIR__ . '/../../classes/DatabaseTable.php';
		include __DIR__ . '/../../includes/DatabaseConnection.php';
		
		$usersTable = new DatabaseTable($pdo, 'users', 'uid');
		$detailsTable = new DatabaseTable($pdo, 'details', 'detailNum');
		
		if ($this->route === 'users/list') {
		include __DIR__  . '/../../classes/controllers/UserController.php';
		$controller = new UserController($usersTable);
		$page = $controller->list();
		}
		else if ($this->route === '') {
		include __DIR__ . '/../../classes/controller/UserController.php';
		$controller = new UserController($usersTable);
		$pate = $controller->home();
		}
		else if ($this->route === 'details/list') {
		include __DIR__ . '/../../classes/controllers/DetailController.php';
		$controller = new DetailController($detailsTable);
		}
		return $page;

    }

} //end of EntryPoint class
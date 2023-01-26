<?php
namespace Gen;
class EntryPoint {
	private $route;
	private $method;
	private $routes;
	private $layout;
	
	public function __construct($route, $method, \Gen\Routes $routes, $layout) {
		$this->route = $route;
		$this->routes = $routes;
		$this->method = $method;
		$this->layout = $layout;
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
		if (isset($templateFileName)){
    		ob_start();
    		include  __DIR__ . '/../../templates/' . $templateFileName;
		}	
	
	return ob_get_clean();

	}

    public function run() {
		$routes = $this->routes->getRoutes();
		
		$authentication = $this->routes->getAuthentication();

		if (isset($routes[$this->route]['login'])  && !$authentication->isLoggedIn()) {
			header('location: /login/error');
		}
		else if (isset($routes[$this->route]['permissions']) && !$this->routes->checkPermission($routes[$this->route]['permissions'])) {
			header('location: /login/permissionserror');
		} else {
			$controller = $routes[$this->route][$this->method]['controller'];
			$action = $routes[$this->route][$this->method]['action'];
			$page = $controller->$action();
			
			$title = $page['title'];
			if (isset($page['cssa'])) {
				$cssa = $page['cssa'];
			} else {
				$cssa =[];
			}
			if (isset($page['scrpt'])) {
				$scrpt = $page['scrpt'];
			} else {
				$scrpt = [];
			}

            if (isset($page['variables'])) {
                $output = $this->loadTemplate($page['template'], $page['variables']);
            } else { 
                $output = $this->loadTemplate($page['template']);
            }
// echo $this->loadTemplate($layout) . '  ' ;
//'isDetail' => $authentication->hasPermission(\Aux\Entity\user::EDIT_DETAILS),
  //'isAdmin' => $authentication->hasPermission(\Aux\Entity\user::ADMIN),
echo $this->loadTemplate($this->layout,   ['loggedIn' => $authentication->isLoggedIn(),									
									'output' => $output,
									'title' => $title,
									'cssa' => $cssa
									]);
			} //end of else
	} // end of run()
} //end of EntryPoint class
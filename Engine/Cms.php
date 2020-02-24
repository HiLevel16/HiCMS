<?php 

namespace Engine;

use Engine\Helper\Url\UrlHelper as Url;
/**
 * 
 */
class Cms
{
	private $router;
	
	public function __construct($router)
	{
		$this->router = $router;
		$this->run();
	}

	private function run() 
	{
		$dispatcher = new Core\Route\Dispatcher();

		$route = $dispatcher->getRoute(Url::getMethod(), Url::getUrl(), $this->router->getRoutes());

		list($controllerName, $action) = explode('::', $route->getController());

		$controllerPath = '\\'.ENV.'\\Controller\\'.$controllerName;

		$controller = new $controllerPath();

		call_user_func_array([new $controller(), $action], $route->getParameters()==null ? [] : $route->getParameters());

	}
}
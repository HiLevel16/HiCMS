<?php 

namespace Engine;

use Engine\Helper\Request\Request;
use Engine\Helper\Config\Config;
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

		$route = $dispatcher->getRoute(Request::getMethod(), Request::getUrl(), $this->router->getRoutes());

		list($controllerName, $action) = explode('::', $route->getController());

		$controllerPath = '\\App\\'.ENV.'\\Controller\\'.$controllerName;
		
		$result = call_user_func_array([new $controllerPath(), $action], $route->getParameters()==null ? [] : $route->getParameters());
		
		if ($result) echo $result;
	}

	public static function defineEnvironment()
	{
		$environments = Config::getCoreConfig('Environments');
		$url = Request::getUrl().'/';

		foreach ($environments as $key => $value) {
			if (strpos($url, $key) !== false) {
				define('ENV', $value);
				return;
			}
		}
	}
}
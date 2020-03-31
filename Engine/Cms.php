<?php 

namespace Engine;

use Engine\Helper\Url\UrlHelper as Url;
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

		$route = $dispatcher->getRoute(Url::getMethod(), Url::getUrl(), $this->router->getRoutes());

		list($controllerName, $action) = explode('::', $route->getController());

		$controllerPath = '\\App\\'.ENV.'\\Controller\\'.$controllerName;

		$controller = new $controllerPath();

		call_user_func_array([new $controller(), $action], $route->getParameters()==null ? [] : $route->getParameters());

	}

	public static function defineEnvironment()
	{
		$environments = Config::getCoreConfig('Environments');
		$url = Url::getUrl();

		foreach ($environments as $key => $value) {
			if (strpos($url, $key) !== false) {
				define('ENV', $value);
				return;
			}
		}
	}
}
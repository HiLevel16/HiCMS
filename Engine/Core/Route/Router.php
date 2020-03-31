<?php 


namespace Engine\Core\Route;

use Engine\Helper\Url\UrlHelper as Url;

class Router 
{
	private $routes;

	private $dispatcher;

	public function __construct()
	{
		$this->routes = new DispatchedRouteCollection();

		$this->dispatcher = new Dispatcher();

		include(Url::getRoot() . '/App/'.ENV.'/Routes.php');

		return;
	}

	private function add($name, $controller, $pattern, $method = 'GET')
	{
		$pattern = rtrim($pattern, '/');
		$pattern = $this->dispatcher->dispatchPattern($pattern);

		$route = new DispatchedRoute($name, $controller, $pattern, $method);

		$this->routes->add($route);
	}

	public function getRoutes() 
	{
		return $this->routes->get();
	}
}
<?php

namespace Engine\Core\Route;

/**
 * 
 */
class DispatchedRouteCollection
{
	private $routes;

	public function __construct ()
	{
		$this->routes = [];
	}
	
	public function add($route)
	{
		array_push($this->routes, $route);

		return;
	}

	public function get()
	{
		return $this->routes;
	}
}
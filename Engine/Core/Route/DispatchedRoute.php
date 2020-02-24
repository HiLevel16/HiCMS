<?php 


namespace Engine\Core\Route;


use Engine\Helper\Url\UrlHelper;

/**
 * 
 */
class DispatchedRoute 
{
	private $name;

	private $controller;

	private $pattern;

	private $method;

	private $parameters;

	function __construct($name, $controller, $pattern = '/', $method = 'GET')
	{
		$this->name = $name;

		$this->controller = $controller;

		$this->method = $method;

		$this->pattern = $pattern;
	}


	public function getController() 
	{
		return $this->controller;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getPattern()
	{
		return $this->pattern;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function setParameters($parameters)
	{
		$this->parameters = $parameters;
	}


	
}
<?php 

namespace Engine\Core\Route;

/**
 * 
 */
class Dispatcher
{

	private $methods = [
        'GET',
        'POST'
    ];

    private $patterns = [
        'int' => '[0-9]+',
        'str' => '[a-zA-Z\.\-_%]+',
        'any' => '[a-zA-Z0-9\.\-_%]+'
    ];

    public function __construct()
    {

    }

	function dispatchPattern($pattern)
	{

		if (mb_stripos($pattern, '(') === false) return $pattern;

		return preg_replace_callback('#\((\w+):(\w+)\)#', [$this, 'replacePattern'], $pattern);
	}

    function dispatchParameters($parameters)
    {
        foreach ($parameters as $key => $value) {
            if (is_int($key)) unset($parameters[$key]);
        }

        return $parameters;
    }

	private function replacePattern ($matches) 
	{
		return '(?<' .$matches[1]. '>'. strtr($matches[2], $this->patterns) .')';
	}

    public function getRoute($method, $url, $routes)
    {
        $url = rtrim($url, '/');
        foreach ($routes as $route) {

            $pattern = '#^'.$route->getPattern().'$#s';

            if (preg_match($pattern, $url, $parameters) && $route->getMethod() == $method)
            {
                $route->setParameters($this->dispatchParameters($parameters));
                return $route;
            }

        }
        
        return new DispatchedRoute('404', 'ErrorController::pageNotFound');
    }
}
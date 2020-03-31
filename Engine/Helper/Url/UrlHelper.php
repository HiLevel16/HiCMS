<?php 

namespace Engine\Helper\Url;

/**
 * 
 */
class UrlHelper
{
	
	static function getUrl() 
	{
		$pathUrl = $_SERVER['REQUEST_URI'];
        if($position = strpos($pathUrl, '?'))
        {
            $pathUrl = substr($pathUrl, 0, $position);
        }
        return rtrim($pathUrl, '/');
	}

	static function getRoot()
	{
		return $_SERVER['DOCUMENT_ROOT'];
	}

	static function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	static function getGlobalUrl()
	{
		return $_SERVER['SERVER_NAME'];
	}

	static function redirect($url)
	{
		header('Location: '.$url);
	}
}
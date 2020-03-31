<?php 

namespace Engine\Helper\Config;

use Engine\Helper\Url\UrlHelper;
/**
 * 
 */
class Config
{
	
	public static function get($configName)
	{
		$path = UrlHelper::getRoot().'/'.ENV.'/config/'.$configName.'.php';
		if(is_file($path)) {
			include $path;
		} else {
			throw new \InvalidArgumentException('File '.$path.' does not exist');
		}
	}

	public static function getCoreConfig($configName)
	{
		$path = UrlHelper::getRoot().'/Engine/config/'.$configName.'.php';

		if(is_file($path)) {
			return include $path;
		} else {
			throw new \InvalidArgumentException('File '.$path.' does not exist');
		}
	}
}
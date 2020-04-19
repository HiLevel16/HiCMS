<?php 

namespace Engine\Helper\Config;

use Engine\Helper\Request\Request;
use Engine\Core\Database\DB;
/**
 * 
 */
class Config
{
	
	public static function get($configName)
	{
		$path = Request::getRoot().'/'.ENV.'/config/'.$configName.'.php';
		if(is_file($path)) {
			include $path;
		} else {
			throw new \InvalidArgumentException('File '.$path.' does not exist');
		}
	}

	public static function getCoreConfig($configName)
	{
		$path = Request::getRoot().'/Engine/config/'.$configName.'.php';

		if(is_file($path)) {
			return include $path;
		} else {
			throw new \InvalidArgumentException('File '.$path.' does not exist');
		}
	}

	public static function getGlobalSettings(DB $db)
	{
		return $db->query("SELECT `key`, `value` FROM setting");
	}
}
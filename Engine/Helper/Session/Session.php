<?php 
namespace Engine\Helper\Session;
session_start();

/**
 * 
 */
class Session
{

	public static function get($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $_SESSION[$key];
	}

	public static function set($key, $value, $oneTime = false)
	{
		if ($oneTime && !isset($_SESSION[$key])) 
			$_SESSION[$key] = $value;
		elseif (!$oneTime && !isset($_COOKIE[$key])) {
			setcookie($key, $value, time()+60*60*24*365*10);
		}
	}

	public static function delete($key)
	{
		if (isset($_SESSION[$key])) 
			unset($_SESSION[$key]);
		if (isset($_COOKIE[$key])) {
			setcookie($key, '1', 1);
		}
	}
}
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
		if (!empty($_COOKIE[$key]))
			return $_COOKIE[$key];
		elseif (!empty($_SESSION[$key]))
			return $_SESSION[$key];
		else 
			return null;
		
	}

	public static function set($key, $value, $remember = false)
	{
		if (!$remember) 
			$_SESSION[$key] = $value;
		else {
			setcookie($key, $value, time()+60*60*24*365*10, '/');
		}
	}

	public static function delete($key)
	{
		unset($_SESSION[$key]);

		setcookie($key, null, -1, '/');

		
	}
}
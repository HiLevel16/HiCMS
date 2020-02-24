<?php

namespace Engine;

/**
 * 
 */
class Model
{
	
	protected $db;


	function __construct()
	{
		$dbCredentials = \Engine\Helper\Config\Config::getCoreConfig('DBsettings');
		$this->db = new \Engine\Core\Database\DB($dbCredentials);
	}
}
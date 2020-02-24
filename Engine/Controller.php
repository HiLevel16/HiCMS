<?php 

namespace Engine;

Use Engine\Helper\Setting\Setting;
Use Engine\Core\View\Theme;
Use Engine\Core\View\View;
Use Engine\Model;

abstract class Controller 
{
	protected $view;

	protected $model;

	protected $data;

	protected $db;

	protected $config;

	public function __construct () 
	{
		$this->init();
	}

	private function init()
	{
		$activeTheme = Setting::getActiveTheme();

		$theme = new Theme($activeTheme);

		$this->view = new View($theme);
		$this->model = new Model();
		
	}

	protected function initDB()
	{
		$dbCredentials = \Engine\Helper\Config\Config::getCoreConfig('DBsettings');
		$this->db = new \Engine\Core\Database\DB($dbCredentials);

	}
}
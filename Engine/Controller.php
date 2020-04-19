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

	protected $settings;

	public function __construct () 
	{
		$this->init();
	}

	protected function init()
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

	protected function getSettings()
	{
		$this->initDB();
		$this->settings = \Engine\Helper\Config\Config::getGlobalSettings($this->db);
		$this->db->close();
	}
}
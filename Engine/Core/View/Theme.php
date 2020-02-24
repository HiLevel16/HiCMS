<?php 

namespace Engine\Core\View;
/**
 * 
 */
use Engine\Helper\Url\UrlHelper;

class Theme
{
	private $name;

	private $path;

	private $globalPath;


	const DEFAULT_THEME_FOLDER = 'Themes';

	const DEFAULT_THEME = 'default';



	function __construct($name)
	{
		$this->name = $name;

		$path = UrlHelper::getRoot().'/'.ENV.'/'.self::DEFAULT_THEME_FOLDER.'/'.$name.'/';
		$globalPath = '/'.ENV.'/'.self::DEFAULT_THEME_FOLDER.'/'.$name.'/';

		if (is_dir($path)) {
			$this->path = $path;
			$this->globalPath = $globalPath;
		}
		else {
			$this->path = UrlHelper::getRoot().'/'.ENV.'/'.self::DEFAULT_THEME_FOLDER.'/'.self::DEFAULT_THEME.'/';
			$this->globalPath = '/'.ENV.'/'.self::DEFAULT_THEME_FOLDER.'/'.self::DEFAULT_THEME.'/';
		}

	}

	public function getThemePath()
	{
		return $this->path;
	}

	public function getThemeGlobalPath()
	{
		return $this->globalPath;
	}

}
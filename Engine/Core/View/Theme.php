<?php 

namespace Engine\Core\View;
/**
 * 
 */
use Engine\Helper\Url\UrlHelper;

class Theme
{
	/**
	 * $name
	 *
	 * @var undefined
	 */
	public $name;

	/**
	 * $path
	 *
	 * @var undefined
	 */
	private $path;

	/**
	 * $globalPath
	 *
	 * @var undefined
	 */
	private $globalPath;




	/**
	 * __construct
	 *
	 * @param mixed $name
	 * @return void
	 */
	function __construct($name)
	{
		$this->name = $name;

		$path = UrlHelper::getRoot().'/App'.ENV.'/'.DEFAULT_THEME_FOLDER.'/'.$name.'/';
		$globalPath = '/App/'.ENV.'/'.DEFAULT_THEME_FOLDER.'/'.$name.'/';

		if (is_dir($path)) {
			$this->path = $path;
			$this->globalPath = $globalPath;
		}
		else {
			$this->path = UrlHelper::getRoot().'/App/'.ENV.'/'.DEFAULT_THEME_FOLDER.'/'.DEFAULT_THEME.'/';
			$this->globalPath = '/App/'.ENV.'/'.DEFAULT_THEME_FOLDER.'/'.DEFAULT_THEME.'/';
		}

	}

	/**
	 * getThemePath
	 *
	 * @return void
	 */
	public function getThemePath()
	{
		return $this->path;
	}

	/**
	 * getThemeGlobalPath
	 *
	 * @return void
	 */
	public function getThemeGlobalPath()
	{
		return $this->globalPath;
	}

}
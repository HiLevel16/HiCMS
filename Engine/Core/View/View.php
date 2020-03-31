<?php

namespace Engine\Core\View;
/**
 * 
 */
use Engine\Load;
use Engine\Helper\Url\UrlHelper as Url;
class View
{
	private $theme;

	private $loadPath;

	public $data = [];
	
	public function __construct(Theme $theme)
	{
		$this->theme = $theme;

		$this->loadFile = $this->theme->getThemePath().DEFAULT_LOAD_FILE.'.php';
	}

	public function render($template, $data = [])
	{
		$components = [];
		empty($data) ? : $this->data = $data;
		$templatePath = $this->theme->getThemePath().$template.'.php';
		if (!file_exists($templatePath)) throw new \Exception("Template ".$templatePath." was not found");

		
		if (file_exists($this->loadFile)) {
			$load = include $this->loadFile;

			if (array_key_exists($template, $load))
			$components = $this->getComponents($load[$template]);
		}

		extract($this->data);
        ob_start();
        ob_implicit_flush(0);

        try {
            require($templatePath);
        } catch (\Exception $e){
            ob_end_clean();
            throw $e;
        }
		echo $this->loadComponents(ob_get_clean(), $components);
	}

	public function header($name = null)
	{
		$name = $name ?? DEFAULT_HEADER_NAME;
		$this->simpleRender($name);
	}

	public function footer($name = null)
	{
		$name = $name ?? DEFAULT_FOOTER_NAME;
		$this->simpleRender($name);
	}

	public function sidebar($name = null)
	{
		$name = $name ?? DEFAULT_SIDEBAR_NAME;
		$this->simpleRender($name);
	}

	private function simpleRender($template)
	{
		$components = [];
		$templatePath = $this->theme->getThemePath().$template.'.php';
		if (file_exists($this->loadFile)) {
			$load = include $this->loadFile;

			if (array_key_exists($template, $load))
			$components = $this->getComponents($load[$template]);
		}

		extract($this->data);
        ob_start();
        ob_implicit_flush(0);

        try {
            require($templatePath);
        } catch (\Exception $e){
            ob_end_clean();
            throw $e;
        }
		echo $this->loadComponents(ob_get_clean(), $components);
		
	}

	private function getComponents($load)
	{
		$modules = [];
		foreach ($load as $key => $point) {
			$modules[$key] = [];
			foreach ($point as $lang => $paths) {
				foreach ($paths as $path => $parameters) {
					if (is_int($path)) $path = $parameters;
					$path = Load::getAssetPath($lang, $path, $this->theme->getThemeGlobalPath());
					array_push($modules[$key], Load::generateComponent($lang, $path, $parameters));
				}
			}
		}
		return $modules;
	}

	private function loadComponents($preview, $components)
	{
		$tmp = '';
		if (!$components) return $preview;
		$render = $preview;
		foreach ($components as $point => $modules) {
			foreach ($modules as $module) {
				$tmp .= $module;
			}
			$render = str_replace('@.'.$point.' ', $tmp, $preview);
		}
		return $render;
	}
}
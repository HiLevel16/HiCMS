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

	const DEFAULT_HEADER_NAME = 'header';
	const DEFAULT_FOOTER_NAME = 'footer';
	const DEFAULT_LOAD_FILE = 'load';

	
	public function __construct(Theme $theme)
	{
		$this->theme = $theme;
	}

	public function render($template, $data = [])
	{
		$templatePath = $this->theme->getThemePath().$template.'.php';
		if (!is_file($templatePath)) throw new \Exception("Template ".$templatePath." was not found");

		$loadFile = $this->theme->getThemePath().self::DEFAULT_LOAD_FILE.'.php';
		if (is_file($loadFile)) {
			$load = (include $loadFile)[$template];

			if ($load)
			$components = $this->getComponents($load);
		}

		
		$data['title'] = "Hmm";
		extract($data);
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

	public function header($name = '')
	{
		$name = !empty($name) ? $name : self::DEFAULT_HEADER_NAME;
		$this->render($name);
	}

	public function footer($name = '')
	{
		$name = !empty($name) ? $name : self::DEFAULT_FOOTER_NAME;
		$this->render($name);
	}

	private function getComponents($load)
	{
		$modules = [];
		foreach ($load as $key => $point) {
			$modules[$key] = [];
			foreach ($point as $lang => $paths) {
				foreach ($paths as $path) {
					$path = Load::getAssetPath($lang, $path, $this->theme->getThemeGlobalPath());
					array_push($modules[$key], Load::generateComponent($lang, $path));
				}
			}
		}
		return $modules;
	}

	private function loadComponents($preview, $components)
	{
		if (!$components) return $preview;
		$render = '';
		foreach ($components as $point => $modules) {
			foreach ($modules as $module) {
				$render .= str_replace('@.'.$point.' ', $module, $preview);
			}
		}
		return $render;
	}
}
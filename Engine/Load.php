<?php

namespace Engine;

/**
 * 
 */
class Load
{
	
	const JS_ENDING = '.js';
	const CSS_ENDING = '.css';

	const MASK_MODEL_ENTITY     = '\%s\Model\%s\%s';
    const MASK_MODEL_PROCESSOR = '\%s\Model\%s\%sProcessor';


	public static function getAssetPath($lang, $path, $themePath)
	{
		switch ($lang) {
			case 'js':
				$loadPath = static::getJsPath($path, $themePath);
				break;
			
			case 'css':
				$loadPath = static::getCssPath($path, $themePath);
				break;
		}
		return $loadPath;
	}

	private static function getJsPath($path, $themePath)
	{
		return $themePath.$path.self::JS_ENDING;
	} 

	private static function getCssPath($path, $themePath)
	{
		return $themePath.$path.self::CSS_ENDING;
	} 

	public static function generateComponent($lang, $path, $parameters = '')
	{
		switch ($lang) {
			case 'css':
				return "<link rel='stylesheet' href=".$path.">\n";
				break;
			
			case 'js':
				return "<script src=".$path."></script>\n";
				break;
		}
	}

	public static function Model($modelName)
	{
		$modelName = ucfirst($modelName);

		$namespaceModel = sprintf(
            self::MASK_MODEL_PROCESSOR,
            ENV, $modelName, $modelName
        );

        
        	return new $namespaceModel;
        
        return null;
	} 
}
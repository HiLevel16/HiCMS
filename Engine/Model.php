<?php

namespace Engine;

use Engine\Cms\Pagination\Pagination;
use Engine\Helper\Request\Request;

/**
 * 
 */
class Model
{
	
	protected $db;

	protected $hasAccess;

	public $pagination;

	
	function __construct()
	{
		$dbCredentials = \Engine\Helper\Config\Config::getCoreConfig('DBsettings');
		$this->db = new \Engine\Core\Database\DB($dbCredentials);
		
	}

	public function hasAccess($accesses, $link = '')
	{
		if (!empty($link))
			$link = rtrim($link, '/');
		else
			$link = rtrim(Request::getUrl(), '/');

        $menu = $this->db->query("SELECT system_name FROM admin_menu WHERE link = :link LIMIT 1", [
            'link' => $link
		]);
		if (empty($menu[0])) return $this->hasAccess = true;
		if (empty($accesses[$menu[0]->system_name]) || $accesses[$menu[0]->system_name])
			return $this->hasAccess = true;
		else 
			return $this->hasAccess = false;
	}

	protected function setIfIsset($array, $key)
	{
		if (empty($array[$key])) return null;
		else return $array[$key];
	}

	protected function getPagination($valuesInPage, $table)
	{
		return $this->pagination = new Pagination($valuesInPage, $table, $this->db);
	}

	protected function xssProtect($elements, $fields, $type = 'object')
    {
        if ($type == 'object') {
            if (is_array($elements)) {
                foreach ($fields as $field)
                    foreach ($elements as $element) {
                        $element->{$field} = htmlspecialchars($element->{$field}, ENT_QUOTES);
                    }
            } else {
                foreach ($fields as $field)
                    $elements->{$field} = htmlspecialchars($elements->{$field}, ENT_QUOTES);
            }

        } elseif ($type == 'assoc') {
            if (is_array($elements) && !$this->isAssocArray($elements)) {
                foreach ($fields as $field)
                    foreach ($elements as $element) {
                        $element[$field] = htmlspecialchars($element[$field], ENT_QUOTES);
                    }
            } else {
                foreach ($fields as $field)
                    $elements[$field] = htmlspecialchars($elements[$field], ENT_QUOTES);
            }
        }
        return $elements;
    }

    private function isAssocArray($array) {
        return (is_array($array) && !is_numeric(implode("", array_keys($array))));
    }
}
<?php

namespace App\Site\Model\Post;

use Engine\Model;

/**
 * 
 */
class PostProcessor extends Model
{
	
	public function add($params = [])
    {
        if (empty($params)) {
            return 0;
        }

        $menu = new Post;
        $menu->setTitle($params['title']);
        $menu->setContent($params['content']);
        $menuId = $menu->save();

        return $menuId;
    }

     public function getList()
    {
        $query = $this->db->query(
        	"SELECT * FROM `post`"
        );

        return $query;
    }
}
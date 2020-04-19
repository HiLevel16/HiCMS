<?php 

namespace App\Admin\Model\MenuItem;

use Engine\Model;

class MenuItemProcessor extends Model
{

    public function getList($accessLevel)
    {
        $rawMenus = $this->db->query("SELECT * FROM admin_menu WHERE visible=1");
        $menus = [];
        foreach ($rawMenus as $rawMenu) {
            if ($accessLevel[$rawMenu->system_name]) 
                $menus[] = $rawMenu;
        }

        foreach ($menus as $key => $menu) {
            $tmpMenu = new MenuItem();
            $tmpMenu->setId($menu->id);
            $tmpMenu->setLink($menu->link);
            $tmpMenu->setIcon($menu->icon);
            $tmpMenu->setName($menu->name);
            $menus[$key] = $tmpMenu;
        }

        return $menus;
    }

}
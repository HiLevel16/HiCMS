<?php 

namespace App\Admin\Model\MenuItem;

use Engine\Model;

class MenuItemProcessor extends Model
{
    const levels = [
        'admin' => 0,
        'moderator' => 1,
        'support' => 2,
        'user' => 3
    ];

    public function getList($role)
    {
        $rawMenus = $this->db->query("SELECT * FROM admin_menu");
        $menus = [];
        foreach ($rawMenus as $rawMenu) {
            if (self::levels[$rawMenu->access_level] >= self::levels[$role]) $menus[] = $rawMenu;
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

    public function hasAccess($role, $link)
    {
        $link = rtrim($link, '/');
        $menu = $this->db->query("SELECT access_level FROM admin_menu WHERE link = :link", [
            'link' => $link
        ]);
        if (self::levels[$menu[0]->access_level] >= self::levels[$role]) return true;
        else return false;
    }
}
<?php

namespace App\Admin\Controller;

use Engine\Helper\Data\Data;
use Engine\Load;

class SettingController extends DashboardController
{
    public function index()
    {
        $setting = Load::Model('Setting');
        $this->view->data['settings'] = $setting->getSettings();
        $this->view->data['title'] = 'Settings';
		$this->view->data['currentPage'] = 'Settings';
		$this->view->data['menus'] = $this->menuItem->getList($this->getCurrentUser()->getRole());
		$this->view->render('menuPages/settings');
    }

    public function update()
    {
        $settings = Data::post();
        $setting = Load::Model('Setting');
        $setting->setSettings($settings);

    }
}
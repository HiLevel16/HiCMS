<?php

namespace App\Admin\Controller;

use Engine\BackResponse\Success;
use Engine\Helper\Request\Request;
use Engine\Load;

class SettingController extends DashboardController
{
    public function index()
    {
        $setting = Load::Model('Setting');
        $this->view->data['settings'] = $setting->getSettings();
        $this->view->data['title'] = 'Settings';
		$this->view->data['currentPage'] = 'Settings';
		$this->view->render('menuPages/settings');
    }

    public function update()
    {
        $settings = Request::post();
        $setting = Load::Model('Setting');
        $setting->setSettings($settings);
        Success::print('Changes successfully applied');
    }
}
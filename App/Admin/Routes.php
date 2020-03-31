<?php 
$this->add('login-form','LoginController::loginForm', '/admin/login/');
$this->add('login-form','LoginController::logout', '/admin/logout/');
$this->add('login-processor','LoginController::login', '/admin/api/login/', 'POST');

$this->add('dashboard','DashboardController::index', '/admin/dashboard/');


$this->add('settings','SettingController::index', '/admin/settings/');
$this->add('settings-update','SettingController::update', '/admin/settings/update', 'POST');


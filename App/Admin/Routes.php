<?php 
$this->add('login-form','LoginController::loginForm', '/admin/login/');
$this->add('login-form','LoginController::logout', '/admin/logout/');
$this->add('login-processor','LoginController::login', '/admin/api/login/', 'POST');

$this->add('dashboard','DashboardController::index', '/admin/dashboard/');


$this->add('settings','SettingController::index', '/admin/settings/');
$this->add('settings-update','SettingController::update', '/admin/settings/update', 'POST');

$this->add('pages', 'PageController::index', '/admin/pages');
$this->add('pages', 'PageController::create', '/admin/pages/create', 'POST');
$this->add('pages', 'PageController::edit', '/admin/pages/edit', 'POST');
$this->add('pages', 'PageController::getPageInfo', '/admin/api/getpage', 'POST');
$this->add('pages', 'PageController::getPageList', '/admin/api/getpages', 'POST');
$this->add('pages', 'PageController::deletePage', '/admin/api/deletepage', 'POST');

$this->add('users', 'UserController::index', '/admin/users');


<?php


namespace App\Admin\Controller;


class UserController extends DashboardController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->data['title'] = 'Users';
        $this->view->data['currentPage'] = 'Users';
        $this->view->render('menuPages/users');
    }

}
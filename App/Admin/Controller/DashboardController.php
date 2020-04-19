<?php 

namespace App\Admin\Controller;

use Engine\BackResponse\Error;
use Engine\Helper\Request\Request;
use Engine\Load;

/**
 * 
 */
class DashboardController extends AdminController
{
	protected $menuItem;
	
	protected $userAccess;
	
	public function __construct()
	{
		parent::__construct();

		$this->menuItem = Load::Model('MenuItem');
		$access = Load::Model('AccessLevel');
		$this->userAccess = $access->getUserAccess($this->user->getId());
		if (!$this->menuItem->hasAccess($this->userAccess, Request::getUrl())) Error::print('You do not have access to this segment');
		$this->makeSettings();
	}
	
	public function index()
	{
		$this->view->data['title'] = 'Dashboard';
		$this->view->data['currentPage'] = 'Dashboard';
		$this->view->render('menuPages/dashboard');
	}

	protected function makeSettings()
	{
		$this->view->data['menus'] = $this->menuItem->getList($this->userAccess);
		$this->view->data['access'] = $this->userAccess;
	}
}
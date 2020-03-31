<?php 

namespace App\Admin\Controller;

use Engine\Helper\Url\UrlHelper;
use Engine\Load;

/**
 * 
 */
class DashboardController extends AdminController
{
	protected $menuItem;
	
	public function __construct()
	{
		$this->init();
		$this->initAdmin();
		$role = $this->getCurrentUser()->getRole();
		$this->menuItem = Load::Model('MenuItem');
		if (!$this->menuItem->hasAccess($role, UrlHelper::getUrl())) exit('You have no access to this page!');
	}
	
	public function index()
	{
		$this->view->data['title'] = 'Dashboard';
		$this->view->data['currentPage'] = 'Dashboard';
		$this->view->data['menus'] = $this->menuItem->getList($this->getCurrentUser()->getRole());
		$this->view->render('menuPages/dashboard');
	}
}
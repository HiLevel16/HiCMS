<?php 

namespace App\Admin\Controller;

use Engine\Controller;
use Engine\Core\Auth;
use Engine\Load;
use Engine\Helper\Request\Request;

class AdminController extends Controller
{
	protected $auth;

	protected $user;

	protected $loadedModels = [];
	
	public function __construct()
	{
		$this->init();
		$this->initAdmin();
	}

	protected function getCurrentUser() 
	{
		$id = $this->getCurrentAuth()->getId();

		$userModel = Load::Model('User', 'Site');

		$this->loadedModels['User'] = $userModel;

		$user = $userModel->getUser($id);

		return $user;
	}

	protected function getCurrentAuth() 
	{
        return new Auth();
	}

	protected function initAdmin()
	{
		$this->auth = $this->getCurrentAuth();
		$this->user = $this->getCurrentUser();

		if ($this->auth->getAuthorize() === false || $this->user->getRole() === 'user') {
			if (Request::getUrl() != '/admin/login' && Request::getUrl() != '/admin/api/login')
				Request::redirect('/admin/login');
			
		}
	}

	
}
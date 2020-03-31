<?php 

namespace App\Admin\Controller;

use Engine\Controller;
use Engine\Core\Auth;
use Engine\Load;
use Engine\Helper\Url\UrlHelper as Url;

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
		$auth = new Auth();

		return $auth;
	}

	protected function initAdmin()
	{
		$this->auth = $this->getCurrentAuth();
		$this->user = $this->getCurrentUser();

		if ($this->auth->getAuthorize() === false || $this->user->getRole() === 'user') {
			if (Url::getUrl() != '/admin/login' && Url::getUrl() != '/admin/api/login')
				Url::redirect('/admin/login');
			
		}
	}

	
}
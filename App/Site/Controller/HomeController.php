<?php 

namespace App\Site\Controller;

use Engine\Controller;
use Engine\Load;
use Engine\Core\Auth;
/**
 * 
 */
class HomeController extends Controller
{
	
	public function index()
	{
		/*$page = Load::Model('Post');
		var_dump($page->getList());*/
		$this->view->render('home');
	}

	
}
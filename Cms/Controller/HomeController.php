<?php 

namespace Cms\Controller;

use Engine\Controller;
use Engine\Load;
/**
 * 
 */
class HomeController extends Controller
{
	
	public function index()
	{
		$page = Load::Model('Post');
		var_dump($page->getList());
		$this->view->render('home');
	}

	
}
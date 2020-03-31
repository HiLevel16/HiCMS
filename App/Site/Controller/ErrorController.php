<?php 

namespace App\Site\Controller;

use Engine\Controller;

/**
 * 
 */
class ErrorController extends Controller
{
	

	public function pageNotFound()
	{
		echo 404;
	}
}
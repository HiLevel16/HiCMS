<?php 

namespace Cms\Controller;

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
<?php 

namespace App\Admin\Controller;


use Engine\Helper\Data\Data;
use Engine\Helper\Hash\Hash;
use Engine\Helper\Url\UrlHelper as Url;

class LoginController extends AdminController
{

	
	public function loginForm()
	{
        if ($this->auth->getAuthorize() && $this->user->getRole() != 'user') Url::redirect('/admin/dashboard');
        $this->view->data['title'] = "Authorization";
		$this->view->render('login', ['title' => "Authorization"]);
    }
    
    public function login()
    {
        $credentials = Data::post();
        if (is_array($credentials)) {
            empty($credentials['login']) ? $this->abort('Login field mustn\'t be empty') : $login = $credentials['login'];
            empty($credentials['password']) ? $this->abort('Password field mustn\'t be empty') : $password = Hash::password($credentials['password']);
            empty($credentials['remember']) ? $remember = false : $remember = $credentials['remember']; 
            $id = $this->checkCredentials($login, $password);
            if (!$id) $this->abort('Incorrect login or password');
            $hash = Hash::generate();
            $this->auth->authorize($id, $hash, (bool)$remember);
            $this->abort($hash, false, false);
        }
    }

    public function logout()
	{
        $this->auth->unAuthorize();
        Url::redirect('/admin/login');
	}

    private function checkCredentials($login, $password, $code = null)
    {
        return $this->loadedModels['User']->checkCredentials($login, $password, $code);
    }

    private function abort($reason, $error = true, $exit = true)
    {
        if ($error) $outReason['status'] = 'error';
        else $outReason['status'] = 'info';
        $outReason['message'] = $reason;
        echo json_encode($outReason);
        if ($exit)
        exit();
    }

    public function test()
    {
        echo '<pre>';
        var_dump($_COOKIE);
        var_dump($_SESSION);
        var_dump($this->auth);
        var_dump($this->user);
    }
}
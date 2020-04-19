<?php 

namespace App\Admin\Controller;


use Engine\Helper\Hash\Hash;
use Engine\Helper\Request\Request;
use Engine\BackResponse\Error;
use Engine\BackResponse\Success;
use Engine\Helper\Session\Session;

class LoginController extends AdminController
{


    public function loginForm()
	{
        if ($this->auth->getAuthorize() && $this->user->getRole() != 'user') Request::redirect('/admin/dashboard');
        $this->view->data['title'] = "Authorization";
		$this->view->render('login', ['title' => "Authorization"]);
    }
    
    public function login()
    {
        $credentials = Request::post();
        if (!empty($credentials) && is_array($credentials)) {
            empty($credentials['login']) ? Error::print('Login field mustn\'t be empty') : $login = $credentials['login'];
            empty($credentials['password']) ? Error::print('Password field mustn\'t be empty') : $password = Hash::password($credentials['password']);
            empty($credentials['remember']) ? $remember = false : $remember = $credentials['remember']; 
            $id = $this->checkCredentials($login, $password);
            if (!$id) Error::print('Incorrect login or password');
            $hash = Hash::generate();
            $parameters['hash'] = $hash;
            $parameters['id'] = $id;
            $parameters['userAgent'] = Request::getUserAgent();
            $parameters['ip'] = Request::getIp();
            $this->auth->authorize($parameters, (bool)$remember);
            Success::print($parameters['hash'], false);
        } else {
            Error::print('Incorrect data supplied');
        }
    }

    public function logout()
	{
        $this->auth->unAuthorize(Session::get(ID_SESSION_NAME));
        Request::redirect('/admin/login');
	}

    private function checkCredentials($login, $password, $code = null)
    {
        return $this->loadedModels['User']->checkCredentials($login, $password, $code);
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
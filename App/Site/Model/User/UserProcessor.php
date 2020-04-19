<?php

namespace App\Site\Model\User;

use Engine\Model;

/**
 * 
 */
class UserProcessor extends Model
{
	
	public function add($params = [])
    {
        if (empty($params)) {
            return 0;
        }

        $user = new User();
        $user->setLogin($params['login']);
        $user->setPassword($params['password']);
        $user->setHash($params['hash']);
        $user->setRole($params['role'] ?? 'user');
        $userId = $user->save();

        return $userId;
    }

    public function getList()
    {
        $query = $this->db->query(
        	"SELECT * FROM `user`"
        );

        return $query;
    }

    public function getUser($id)
    {
        $query = $this->db->query("SELECT * FROM `user` WHERE id = :id LIMIT 1", [
            "id" => $id
        ]);
        if ($query) {
            $user = new User();
            $user->setId($query[0]->id);
            $user->setHash($query[0]->hash);
            $user->setLogin($query[0]->login);
            $user->setPassword($query[0]->password);
            $user->setRole($query[0]->role);
            return $user;
        } else return null;
    }

    public function checkCredentials($login, $password, $code = null)
    {
        if (!$code)
            $query = $this->db->query('SELECT id FROM user WHERE login = :login AND password = :password', [
                'login' => $login,
                'password' => $password
            ]);
        if ($query)
        return $query[0]->id;
        else return null;
    }

    public function getAccessLevel($userId)
    {
        $query = $this->db->query('SELECT * FROM user_access WHERE user_id = :user_id LIMIT 1', [
            'user_id' => $userId
        ]);

        return $query[0];
    }
}
<?php

namespace App\Site\Model\User;

use Engine\Core\Database\ActiveRecord;

class User
{
    use ActiveRecord;

    protected $table = 'user';

    public $id;

    public $name;

    public $password;

    public $hash;

    public $role;

    public $registrationDate;

    public $lastOnline;

    public $status;

    /**
     * @return mixed
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param mixed $registrationDate
     */
    public function setRegistrationDate($registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return mixed
     */
    public function getLastOnline()
    {
        return $this->lastOnline;
    }

    /**
     * @param mixed $lastOnline
     */
    public function setLastOnline($lastOnline): void
    {
        $this->lastOnline = $lastOnline;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->Login;
    }

    /**
     * @param mixed $Login
     *
     * @return self
     */
    public function setLogin($Login)
    {
        $this->Login = $Login;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     *
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param $role
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
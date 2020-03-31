<?php 

namespace Engine\Helper\Hash;

class Hash
{
    public static function generate()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < 32; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        return md5($randomString); 
    }

    public static function password($password)
    {
        return hash('sha256', $password.SALT);
    }
}
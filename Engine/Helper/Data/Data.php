<?php 

namespace Engine\Helper\Data;

class Data 
{

    public static function post()
    {
        return $_POST;
    }

    public static function get()
    {
        return $_GET;
    }
}
<?php

class User {
    
    public static function ensureAuthenticated($confirmed = true)
    {
        $user = new Zend_Session_Namespace('user');
        if($confirmed && $user->status != 'CONFIRMED')
            return false;
        return $user;
    }
    
    public static function login($user)
    {
        $_SESSION['user'] = $user;
    }
    
    public static function logout()
    {
        $_SESSION['user'] = null;
    }
    
}
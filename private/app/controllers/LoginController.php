<?php

class LoginController extends CrudController {

    private static function _generateSalt()
    {
        $salt = '';
        for($i = 0; $i < 8; $i++)
            $salt .= chr(rand(33, 127));
            
        return $salt;
    }
    
    private static function _hashPassword($pass,$salt)
    {
        $hash = strrev($pass);
        $hash = sha1($hash.substr($salt,0,3));
        $hash = sha1(substr($salt,3,3).$hash);
        $hash = sha1($hash.substr($salt,6));
        return $hash;
    }

    public function indexAction()
    {   
        while($_POST) {

            $db = Zend_Registry::get('db');

            $email = trim($this->_getParam('email'));
            $password = trim($this->_getParam('password'));
            
            $q = "SELECT * FROM `users` WHERE email = ?";
            $user = $db->fetchRow($q, $email);
            
            if(!$user || $user['hash'] != self::_hashPassword($password,$user['salt'])) {
                break;
            }

            unset($user['hash']);

            $_SESSION['user'] = $user['name'];
            
            $this->_redirect('/questions');
        }    
    }
    
}

?>

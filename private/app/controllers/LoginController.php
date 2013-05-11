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
    
    public function checkemailAction() {
	   $ajaxEmail = $_POST['email'];
	   $ajaxPassword = $_POST['password'];
	   
	   $array = array("email" => $ajaxEmail, "password" => $ajaxPassword);
	   
	   if(!isset($ajaxEmail)) exit;
	   $db = Zend_Registry::get('db');

	   $emailDB = $db->fetchRow('SELECT * FROM `users` WHERE email = ?', $ajaxEmail);

	   if (!$emailDB) {
		  $data = array("error" => "E-Mail is al in gebruik.");
		  $this->_forward("home", "page", 'default', $data);
	   }
	   else
	   {
		   $this->_forward("login", "login", 'default', $array);
	   }
    }

    public function loginAction() {

       $db = Zend_Registry::get('db');

		  $email = trim($this->_getParam('email'));
		  $password = trim($this->_getParam('password'));

		  $q = "SELECT * FROM `users` WHERE email = ?";
		  $user = $db->fetchRow($q, $email);

		  if (!$user || $user['hash'] != self::_hashPassword($password, $user['salt'])) {
			
		  }

		  unset($user['hash']);

		  $_SESSION['user'] = $user['name'];

		  $this->_redirect('/questions');
    }
}

?>

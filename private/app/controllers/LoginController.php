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
	   $this->_helper->viewRenderer->setNoRender();
	   $this->view->layout()->disableLayout();
	   
	   $ajaxEmail = $_GET['email'];
	   $db = Zend_Registry::get('db');

	   $emailDB = $db->fetchRow('SELECT * FROM `users` WHERE email = ?', $ajaxEmail);

	   if (!$emailDB) {
		  echo "test";
	   }
	   else
	   {
		   $this->_redirect('/inloggen');
	   }
    }

    public function indexAction() {

       $db = Zend_Registry::get('db');

	   while ($_POST) {
	   	
		  $email = trim($this->_getParam('email'));
		  $password = trim($this->_getParam('password'));

		  var_dump($email, $password);
		  exit;

		  $q = "SELECT * FROM `users` WHERE email = ?";
		  $user = $db->fetchRow($q, $email);

		  if (!$user || $user['hash'] != self::_hashPassword($password, $user['salt'])) {
			 break;
		  }

		  unset($user['hash']);

		  $_SESSION['user'] = $user['name'];

		  $this->_redirect('/questions');
	   }
    }
}

?>

<?php

class AdminController extends AppController {

    private $user;
    
    public function preDispatch() {
        parent::preDispatch();

        $config = Zend_Registry::get('config');
        
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
        
        if(!$this->user):
            if ($this->_request->getActionName() != 'index')
                $this->_redirect('/');
            return false;
        endif;
        
    }

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
    
    public function loginAction()
    {
        while($_POST) {
            $email = trim($this->_getParam('email'));
            $password = trim($this->_getParam('password'));

            var_dump($email, $password);
            exit;
            
            $q = "SELECT * FROM `users` WHERE email = ?";
            $user = $this->_db->fetchRow($q, $email);
            
            if(!$user || $user['password_hash'] != self::_hashPassword($password,$user['password_salt'])) {
                break;
            }
            
            unset($user['password_hash']);
            unset($user['password_salt']);
            
            $this->_helper->redirector->gotoRouteAndExit(array('controller' => 'page', 'action' => 'home'));
        }
    }

    public function registerAction()
    {
    	while($_POST) {
            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();
            if($values['password']) {
                $salt = self::_generateSalt();
                $hash = self::_hashPassword($values['password'],$salt);
                
                $values['password_hash'] = $hash;
                $values['password_salt'] = $salt;
            }
            unset($values['password']);
            
            if($user)
                $this->_merge($user, $values);
            else
                $this->_add($values);
                
            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }
    }
    
    public function logoutAction()
    {
        $user = new Zend_Session_Namespace('cmsuser');
        $user->unsetAll();
        
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'login'));
    }
    
}

?>
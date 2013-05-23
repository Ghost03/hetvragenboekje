<?php

class UserController extends CrudController
{
    public function preDispatch()
    {
        parent::preDispatch();
        $this->_relation = 'users';
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
            
            $q = "SELECT * FROM `users` WHERE email = ? AND admin = 1";
            $user = $this->_db->fetchRow($q, $email);
            
            if(!$user || $user['hash'] != self::_hashPassword($password,$user['salt'])) {
                break;
            }
            
            if(!$user['active']) {
                break;
            }
            
            unset($user['hash']);
            unset($user['salt']);
            
            $user['admin'] = 1;
            
            // this is needed for the file manager
            $config = Zend_Registry::get('config');
            $staticBase = $config->static_base;
            $_SESSION['basedir'] = $staticBase . '../uploads/content/'; 
            
            $_SESSION['cmsuser'] = $user;
            
            if(isset($_GET['from']) && $_GET['from'] != '') 
            	$this->_redirect($config->baseurl . strtolower(MODE) . '/' . $_GET['from']);
            $this->_helper->redirector->gotoRouteAndExit(array(), 'home');
        }
    }
    
    public function logoutAction()
    {
        $user = new Zend_Session_Namespace('cmsuser');
        $user->unsetAll();
        
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'login'));
    }
    
    public function listAction()
    {
        $this->view->users = $this->_list();
    }
    
    public function addAction()
    {
        $this->editAction();
        
        $this->_helper->viewRenderer->setRender('edit');
    }
    
    public function editAction()
    {
        $form = $this->view->form = new userForm;
        
        $user = array();
        if($this->_request->getActionName() == 'edit')
            $user = $this->_get();
        
        while($_POST) {
            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();
            if($values['password']) {
                $salt = self::_generateSalt();
                $hash = self::_hashPassword($values['password'],$salt);
                
                $values['hash'] = $hash;
                $values['salt'] = $salt;
            }
            unset($values['password']);
            
            if($user)
                $this->_merge($user, $values);
            else
                $this->_add($values);
                
            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }
        
        if(!$_POST) $form->populate($user);
    }
    
    public function deleteAction()
    {
        $this->_delete();
        
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
    }
}


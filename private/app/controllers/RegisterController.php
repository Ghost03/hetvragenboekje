<?php

class RegisterController extends CrudController {

    public function preDispatch() {
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

    public function indexAction()
    {   
        $form = $this->view->form = new usersForm;

        $db = Zend_Registry::get('db');
        
        while($_POST) {

            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();
            $id = $db->fetchOne('SELECT id FROM users ORDER BY id DESC LIMIT 1') + 1;

            if($values['rpassword']) {
                $salt = self::_generateSalt();
                $hash = self::_hashPassword($values['rpassword'],$salt);
                
                $values['hash'] = $hash;
                $values['salt'] = $salt;
            }

            unset($values['rpassword']);

            $this->_add($values);

            $_SESSION['user'] = $values['name'];
                
            $this->_redirect('/questions');
        }
    }
    
}

?>

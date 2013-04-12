<?php

class ProfileController extends CrudController {

    public function preDispatch()
    {   
        parent::preDispatch();

        if( !$_SESSION['user'] ) {
            $this->_redirect('');
            exit;
        }

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

    public function editAction()
    {   
        // Includes
        $db = Zend_Registry::get('db');
        $form = $this->view->form = new ProfileForm;

        $user = $db->fetchRow('SELECT * FROM users WHERE name = ?', $_SESSION['user']);

        // Prefill form
        $form->populate($user);

        while($_POST) {

            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();

            $this->_merge($user, $values);
                
            $this->_redirect('profiel');
        }

    }
    
}

?>

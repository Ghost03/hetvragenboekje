<?php

class UserController extends AppController {
    
    public function preDispatch() {
        parent::preDispatch();
        
        if( !$_SESSION['user'] ) {
            $this->_redirect('');
            exit;
        }
    }

    public function logoutAction() {
        $user = new Zend_Session_Namespace('user');
        $user->unsetAll();
        
        $this->_redirect('');
    }
    
}

?>
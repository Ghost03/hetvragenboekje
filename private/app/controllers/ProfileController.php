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
        $form->setAttrib('enctype', 'multipart/form-data');

        $user = $db->fetchRow('SELECT * FROM users WHERE name = ?', $_SESSION['user']);

        // Prefill form
        $form->populate($user);

        while($_POST) {

            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();

            $this->_merge($user, $values);
                
            $this->_redirect('profiel');
        }

        // Views
        $this->view->user = $user;

    }

    public function photoAction()
    {
        $db = Zend_Registry::get('db');
        $this->view->layout()->disableLayout();

        $user = $_SESSION['user'];
        $user_id = $db->fetchOne("SELECT id FROM users WHERE name = ?", $user);

        $targetFolder = '/uploads/images/';

        if ( !empty($_FILES) ) {

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim( $targetPath,'/' ) . '/' . $_FILES['Filedata']['name'];
            
            $fileTypes = array('jpg','jpeg','gif','png');
            $fileParts = pathinfo( $_FILES['Filedata']['name'] );
            
            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);
                $q = $db->prepare('UPDATE users SET image = :image WHERE id = :id');
                $q->bindValue(':image', $_FILES['Filedata']['name']);
                $q->bindValue(':id', $user_id);
                $q->execute();
                echo '1';
            } else {
                echo 'Invalid file type.';
            }

        }
    }

    public function checkexistsAction()
    {
        $targetFolder = '/uploads/images/';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
}

?>

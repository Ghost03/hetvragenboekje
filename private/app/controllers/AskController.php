<?php

class AskController extends CrudController {

	public function preDispatch() {
		parent::preDispatch();

		$this->_relation = 'questions';

		if( !$_SESSION['user'] ) {
            $this->_redirect('');
            exit;
        }
	}

    public function indexAction()
    {   
    	// Includes
        $db = Zend_Registry::get('db');
        $form = $this->view->form = new QuestionForm;

        $user_id = $db->fetchOne('SELECT id FROM users WHERE name = ?', $_SESSION['user']);

        while($_POST) {

            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();

    		$values['user_id'] = $user_id;
    		$values['url'] = sanitize($values['name']);
            $values['date_created'] = date("Y-m-d H:i:s");

            $this->_add($values);
                
            $this->_redirect('question/' . $values['url']);
        }

        // Views
        $this->view->user = $user;
        $this->view->categories = $categories;
    }
}

?>

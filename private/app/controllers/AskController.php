<?php

class AskController extends CrudController {

    public function preDispatch() {
	   parent::preDispatch();

	   $this->_relation = 'questions';

	   if (!$_SESSION['user']) {
		  $this->_redirect('');
		  exit;
	   }
    }

    public function indexAction() {
	   // Request
	   $request = Zend_Controller_Front::getInstance()->getRequest();
	   $params = $request->getParams();
	   $steleenvraag_error = $params['steleenvraag-error'];

	   // Includes
	   $db = Zend_Registry::get('db');
	   $form = $this->view->form = new QuestionForm;

	   $user_id = $db->fetchOne('SELECT id FROM users WHERE email = ?', $_SESSION['user']);

	   while ($_POST) {

		  if (!$form->isValid($_POST))
			 break;

		  $values = $form->getValues();

		  $lastCharFix = substr($values['tags'], -1);
		  if ($lastCharFix == ";") {
			 $bugFix = substr($values['tags'], 0, -1);
			 $values['tags'] = $bugFix;
		  }

		  $checkExists = $db->fetchAll('SELECT * FROM questions WHERE name = ?', $values['name']);

		  if ($checkExists)
			 $this->_redirect('question/' . sanitize($values['name']));

		  else {

			 $values['user_id'] = $user_id;
			 $values['url'] = sanitize($values['name']);
			 $values['date_created'] = date("Y-m-d H:i:s");

			 $this->_add($values);

			 $this->_redirect('question/' . $values['url']);
		  }
	   }

	   // Views
	   $this->view->user = $user;
	   $this->view->categories = $categories;
	   $this->view->steleenvraag_error = $steleenvraag_error;
    }

}

?>

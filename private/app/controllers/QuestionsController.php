<?php

class QuestionsController extends CrudController {

    public function preDispatch() 
    {   
        parent::preDispatch();

        $this->_relation = 'answers';
    }

    public function overviewAction()
    {   
        if( !$_SESSION['user'] ) {
            $this->_redirect('');
            exit;
        }

    	// Includes 
    	$request = Zend_Controller_Front::getInstance()->getRequest();
        $db = Zend_Registry::get('db');
        $config = Zend_Registry::get('config');

        // Queries
        $session = $_SESSION['user'];
        $user_id = $db->fetchOne('SELECT id FROM users WHERE name = ?', $session);
        $questions = $db->fetchAll('SELECT * FROM questions WHERE user_id = ? ORDER BY date_created LIMIT 5', $user_id);

        // Views
        $this->view->questions = $questions;
    }

    public function detailAction()
    {  
        // Includes 
        $form = $this->view->form = new AnswerForm;
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $db = Zend_Registry::get('db');

        // Queries
        $question = $db->fetchRow('SELECT * FROM questions WHERE url = ?', $request->question);
        $category = $db->fetchRow('SELECT * FROM categories WHERE id = ?', $question['category_id']);
        $answers = $db->fetchAll('SELECT * FROM answers WHERE question_id = ? ORDER BY date_created', $question['id']);
        $question_ratings = $db->fetchAll('SELECT * FROM votes WHERE question_id = ?', $question['id']);
        $questioner = $db->fetchRow('SELECT * FROM users WHERE id = ?', $question['user_id']);

        foreach($question_ratings as $question_rating)
            $question_rating = $question_rating['total'] / $question_rating['votes'];

        foreach($answers as $answer):
            $answer_ratings = $db->fetchAll('SELECT * FROM votes WHERE answer_id = ?', $answer['id']);

            foreach($answer_ratings as $answer_rating):
                $answer_rating = $answer_rating['total'] / $answer_rating['votes'];
            endforeach;

        endforeach;

        // Views
        $this->view->questioner = $questioner;
        $this->view->question = $question;
        $this->view->answers = $answers;
        $this->view->question_rating = $question_rating;
        $this->view->answer_rating = $answer_rating;
        $this->view->category = $category;
        $this->view->tags = explode(';', $question['tags']);

        while($_POST) {

            if(!$form->isValid($_POST)) break;
            
            $values = $form->getValues();

            $values['question_id'] = $_POST['question_id'];
            $values['user_id'] = $user['id'];
            $values['date_created'] = date("Y-m-d H:i:s");

            $this->_add($values);
                
            $this->_redirect('question/' . $_POST['question_name']);
        }
    }
    
}

?>

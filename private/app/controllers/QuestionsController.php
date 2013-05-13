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
	    $countedAnswers = count( $db->fetchAll('SELECT * FROM answers WHERE question_id = ?', $question['id']) );
        $questioner = $db->fetchRow('SELECT * FROM users WHERE id = ?', $question['user_id']);
        $user = $db->fetchRow('SELECT * FROM users WHERE name = ?', $_SESSION['user']);
	   
        $questiondate = new Zend_Date($question['date_created']);
		
		($countedAnswers == 0 ? $countedAnswers = "Nog niet beantwoord." : $countedAnswers .= "x beantwoord");

        // Views
        $this->view->questioner = $questioner;
        $this->view->question = $question;
        $this->view->answers = $answers;
        $this->view->category = $category;
        $this->view->tags = explode(';', $question['tags']);
	    $this->view->questiondate = $questiondate->toString("dd MMMM YYYY");
	    $this->view->countedAnswers = $countedAnswers;
        $this->view->user = $user;
	   
        // Answer data
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
    
    public function generatehtmlAction()
    {
       // Get question and answer
	   if (!isset($_GET['q'])) exit;
	   if (!isset($_GET['a'])) exit;
	   
	   // Includes 
	   $db = Zend_Registry::get('db');

	   $question_id = (int) $_GET['q'];
	   $answer_id = (int) $_GET['a'];
	   
	   // Queries 
	   $question = $db->fetchRow('SELECT * FROM questions WHERE id = ?', $question_id);
       $answer = $db->fetchRow('SELECT * FROM answers WHERE id = ?', $answer_id);
	   
	   $data = array(
		  "question" => $question,
		  "answer" => $answer
	   );
	   
	   $this->view->layout()->disableLayout();
	   $this->view->data = $data;
    }
    
    
    public function createpdfAction()
    {
       // Get question and answer
	   if (!isset($_GET['q'])) exit;
	   if (!isset($_GET['a'])) exit;
	 
	   $question_id = (int) $_GET['q'];
	   $answer_id = (int) $_GET['a'];
	 
	   // Includes 
	   $config = Zend_Registry::get('config');
	   require_once('dompdf/dompdf_config.inc.php');  
	   
	   $this->_helper->viewRenderer->setNoRender();
	   $this->view->layout()->disableLayout();
	   
	   $autoloader = Zend_Loader_Autoloader::getInstance();
	   $autoloader->pushAutoloader('DOMPDF_autoload'); 
	
       // PDF
       $pdf = new DOMpdf();
       $pdf->set_paper('a4', 'landscape');
	  $html = file_get_contents( $config->baseurl . "printpdf?q=" . $question_id . "&a=" . $answer_id );
	   
       $pdf->load_html($html);
	  $pdf->render();
	  $pdf->stream("test.pdf", array("Attachment" => 0));
    }
    
}
?>

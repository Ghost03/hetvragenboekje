<?php

class PageController extends AppController {

    public function homeAction()
    {         
	 
	   
	   $request = Zend_Controller_Front::getInstance()->getRequest();
	   $params = $request->getParams();
	   $error = $params['error'];	   
        // Includes
        $db = Zend_Registry::get('db');
        // Queries
        $questions = $db->fetchAll('SELECT * FROM questions ORDER BY date_created DESC LIMIT 5');

        // Views
        $this->view->questions = $questions;
	   $this->view->error = $error;
        //$this->view->pdf = $pdf;
    }
    
}

?>

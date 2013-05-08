<?php

class PageController extends AppController {

    public function homeAction()
    {         
	   $request = Zend_Controller_Front::getInstance()->getRequest();
	   var_dump($request->_params);
	   exit();
        // Includes
        $db = Zend_Registry::get('db');
	   $db = Zend_Registry::get('db');
        
        // Queries
        $questions = $db->fetchAll('SELECT * FROM questions ORDER BY date_created DESC LIMIT 5');

        // Views
        $this->view->questions = $questions;
        //$this->view->pdf = $pdf;
    }
    
}

?>

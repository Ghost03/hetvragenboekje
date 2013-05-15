<?php

class PageController extends AppController {

    public function homeAction()
    {         
	  // Request
	  $request = Zend_Controller_Front::getInstance()->getRequest();
	  $params = $request->getParams();
	  $error = $params['error'];	   
	  $config = Zend_Registry::get('config');
	  
       // Includes
       $db = Zend_Registry::get('db');
        
       // Queries
       $questions = $db->fetchAll('SELECT * FROM questions ORDER BY date_created DESC LIMIT 5');

	  // Data 
	  $app_id = "117716921766168";
	  
	  
       // Views
       $this->view->questions = $questions;
	  $this->view->error = $error;
	  $this->view->appID = $app_id;
	  $this->view->baseurl = $config->baseurl;
	  
    }
    
}

?>

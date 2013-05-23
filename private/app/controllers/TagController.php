<?php

class TagController extends AppController {

    public function detailAction()
    {         
       // Includes
       $request = Zend_Controller_Front::getInstance()->getRequest();
       $db = Zend_Registry::get('db');

       $tag = $request->tag;
        
       // Queries
       $questions = $db->fetchAll('SELECT * FROM questions WHERE tags LIKE ? ORDER BY date_created DESC LIMIT 5', '%' . $tag . '%');

       // Data 
       $app_id = "117716921766168";

       // Views
       $this->view->questions = $questions;
       $this->view->tag = $tag;
       $this->view->appID = $app_id;
    }
    
}

?>

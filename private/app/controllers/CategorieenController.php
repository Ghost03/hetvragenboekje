<?php

class CategorieenController extends AppController {

    public function listAction()
    {   
        // Includes
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $db = Zend_Registry::get('db');
        $config = Zend_Registry::get('config');
        
        // Queries
        $q = $db->prepare('SELECT * FROM categories ORDER BY name');
        $q->execute();
        
        $categories = $q->fetchAll(PDO::FETCH_ASSOC);

        // Views
        $this->view->categories = $categories;
        $this->view->config = $config;
        $this->view->request = $request;
    }

    public function detailAction()
    {   
        // Includes
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $db = Zend_Registry::get('db');
        
        // Queries
        $category = $db->fetchRow('SELECT * FROM categories WHERE url = ?', $request->categorie);
        $questions = $db->fetchAll('SELECT * FROM questions WHERE category_id = ? ORDER BY date_created', $category['id']);

        // Functions
        foreach($questions as $question):
            $question_ratings = $db->fetchAll('SELECT * FROM votes WHERE question_id = ?', $question['id']);

            foreach($question_ratings as $question_rating)
                $question_rating = $question_rating['total'] / $question_rating['votes'];

        endforeach;

        // Data
        $app_id = "117716921766168";
        
        // Views
        $this->view->appID = $app_id;
        $this->view->category = $category;
        $this->view->questions = $questions;
        $this->view->question_rating = $question_rating;
    }
    
}

?>

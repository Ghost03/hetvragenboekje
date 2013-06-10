<?php

class CategorieenController extends AppController {

    public function listAction()
    {   
        // Includes
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $db = Zend_Registry::get('db');
        $config = Zend_Registry::get('config');
        
        // Queries
        $q = $db->prepare('SELECT * FROM categories ORDER BY id ASC');
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

        // Data
        $app_id = "117716921766168";

        if(!isset($_GET['page']))
            $_GET['page'] = 1;

        $view = Zend_Layout::getMvcInstance()->getView();
        $paginator = Zend_Paginator::factory( $questions );
        $paginator->setCurrentPageNumber( (int) @$_GET['page'] )
                  ->setItemCountPerPage(10);

        $pagination = $view->paginationControl( $paginator, 'Sliding', 'pagination.phtml' );

        // Views
        $this->view->appID = $app_id;
        $this->view->category = $category;
        $this->view->pagination = $pagination;
        $this->view->questions = Zend_Paginator::factory( $questions )
                                 ->setCurrentPageNumber( (int) @$_GET['page'] )
                                 ->setItemCountPerPage(10);
    }
    
}

?>

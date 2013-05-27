<?php

class PageController extends AppController {

    public function homeAction()
    {         
	  // Request
	  $request = Zend_Controller_Front::getInstance()->getRequest();
	  $params = $request->getParams();
	  $l_error = $params['login-error'];
	  $r_error = $params['register-error'];
	  $config = Zend_Registry::get('config');
	  
      // Includes
      $db = Zend_Registry::get('db');
        
      // Queries
      $questions = $db->fetchAll('SELECT * FROM questions ORDER BY date_created DESC');

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
	  $this->view->l_error = $l_error;
	  $this->view->r_error = $r_error;
	  $this->view->appID = $app_id;
	  $this->view->baseurl = $config->baseurl;
	  $this->view->pagination = $pagination;

	  $this->view->questions = Zend_Paginator::factory( $questions )
                             ->setCurrentPageNumber( (int) @$_GET['page'] )
                             ->setItemCountPerPage(10);
    }
    
}

?>

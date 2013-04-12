<?php

class ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {    
        $error = $this->_getParam('error_handler');
        
        header('HTTP/1.0 404 Not Found');
        
        #if($_SERVER['REMOTE_ADDR'] == '95.97.14.122')
            $this->view->error = $error->exception;
        
        $view = $this->getHelper('ViewRenderer')->view;
		echo $view->render('error/404.phtml');
        exit;
    }
}
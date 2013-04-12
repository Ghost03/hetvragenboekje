<?php

class APP {
    const SUCCESS = 'success';
    const ERROR   = 'error';
    const WARNING = 'warning';
    const INFO    = 'information';
}

class AppController extends Zend_Controller_Action {
    
    protected $db;
    protected $cache;
    protected $cmslinks = array();
    protected $social   = false;
    
    public function postDispatch() 
    {
        $this->view->cmslinks = $this->cmslinks;
    }
    
    /**
     * Send a message to the user
     * @param string $type    The message type
     *                         APP::SUCCESS, a success message
     * APP::ERROR, an error message
     * @param string $content The contents of the message
     */
    protected function message($type, $content) 
    {
        $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
        $messages[] = array(
            'type'    => $type,
            'content' => $content
        );
        $_SESSION['messages'] = $messages;
    }
       
    /**
     * Show a link to update the current product in the cms ?
     * @param type $url the url to the cms
     * @param type $text the text to display
     */
    protected function cmslink($url,$text) 
    {
        $this->cmslinks[$url] = $text;
    }
    
}
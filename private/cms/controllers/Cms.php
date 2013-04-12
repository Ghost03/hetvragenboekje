<?php

class Cms extends CrudController {
    const SUCCESS = 1;
    const ERROR = 2;
    const WARNING = 3;
    const NOTIFICATION = 4;

    private $flashMessenger = NULL;
    private $breadcrumbs = array();
    private $buttons = array();
    private $messages = array();
    protected $languages = array();
    protected $language = false;

    public function preDispatch() {
        /*parent::preDispatch();
        
        if($this->_getParam('nolanguage') == 1) return;
                
        if(!$this->_getParam('language',false))
            $this->_helper->redirector->gotoRouteAndExit(array('language' => 1));
        
        $config = Zend_Registry::get('config');
        $this->languages = $config->languages;
                
        $this->language = $this->getLanguageId($this->_getParam('language'),'id');
        if(!$this->language) throw new Exception('Invalid language parameter');   
        
        Zend_Registry::set('language',$this->language);*/        
    }
    
    /**
     * Get the language id of a specific code
     * @param type $code
     * @return type 
     */
    public function getLanguageId($code,$input = 'code') {
        foreach($this->languages as $language)
            if($language->$input == $code) return $language->id;
        return false;
    }

    /**
     * Add messages to the layout
     */
    public function postDispatch() {
        $this->_helper->layout()->messages = array_merge($this->_helper->getHelper('FlashMessenger')->getMessages(), $this->messages);
    }

    public function message($type, $content, $direct = false) {
        if ($direct) {
            $this->messages[] = array(
                'type' => $type,
                'content' => $content
            );
            return;
        }
        if (is_null($this->flashMessenger))
            $this->flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->flashMessenger->addMessage(array(
            'type' => $type,
            'content' => $content
        ));
    }

    public function button($url, $name) {
        $this->buttons[$url] = $name;
    }

    public function breadcrumb($url, $name) {
        $this->breadcrumbs[$url] = $name;
    }
        

}
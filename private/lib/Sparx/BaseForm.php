<?php

class Sparx_BaseForm extends Zend_Form
{
    private $_defaults = array();    
    public  $languages = array();
    public  $language  = false;
    
    public function __construct($options = null) 
    {
        $config = Zend_Registry::get('config');
        $this->languages = $config->languages; 
        
        $this->language  = Zend_Registry::get('language');
        
        parent::__construct($options);
    }
    
    public function setDefault($id, $value)
    {
        $this->_defaults[$id] = $value;
        
        parent::setDefault($id, $value);
    }
    
    public function isValid($data)
    {
        $data = array_merge($this->_defaults, $data);
        
        return parent::isValid($data);
    }
}
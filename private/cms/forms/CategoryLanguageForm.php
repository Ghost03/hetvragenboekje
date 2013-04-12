<?php

class CategoryLanguageForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $db = Zend_Registry::get('db');
        
        $element = new Sparx_SimpleText('name');
        $this->addElement($element);

        $element = new Sparx_SimpleText('content');
        $element->setMedium();
        $this->addElement($element);
    }
}
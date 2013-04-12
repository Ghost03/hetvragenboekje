<?php

class Sparx_SimpleTextarea extends Zend_Form_Element_Textarea
{
    public function init()
    {
        $this->setAttrib('class', 'textarea')
             ->addFilter('StringTrim');
        
        $this->getView()->addHelperPath('Sparx/View/Helper', 'Sparx_View_Helper');
    }
        
    public function addClass($class)
    {
        return $this->setAttrib('class', $this->getAttrib('class') . ' ' . $class);
    }
    
    public function loadDefaultDecorators()
    {
        return $this->addDecorator('ViewHelper');
    }
}
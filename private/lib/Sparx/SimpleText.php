<?php

class Sparx_SimpleText extends Zend_Form_Element_Text
{
    private $date = false;
    
    public function init()
    {
        $this->setAttrib('class', 'text-input')
             ->addFilter('StringTrim');
        
        $this->getView()->addHelperPath('Sparx/View/Helper', 'Sparx_View_Helper');
    }
    
    public function setValue($value) {
        if($this->date && $value < 1) $value = '';
        
        parent::setValue($value);
    }
        
    public function addClass($class)
    {
        return $this->setAttrib('class', $this->getAttrib('class') . ' ' . $class);
    }
    
    public function setShort()
    {
        return $this->addClass('small-input');
    }
    
    public function setMedium()
    {
        return $this->addClass('medium-input');
    }
    
    public function setLong()
    {
        return $this->addClass('long-input');
    }
    
    public function setColorpicker()
    {
        return $this->addClass('color-input');
    }    
    
    public function setImagepicker()
    {
        return $this->addClass('image-input');
    }
    
    public function setDatepicker()
    {
        $this->date = true;
        return $this->addClass('date-input');
    }
    
    public function placeholder($placeholder)
    {
        return $this->setAttrib('placeholder', $placeholder);
    }
    
    public function loadDefaultDecorators()
    {
        return $this->addDecorator('ViewHelper')
                    ->addDecorator('Errors');
    }
}
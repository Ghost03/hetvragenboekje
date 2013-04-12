<?php

class PageLanguageForm extends Sparx_BaseForm
{
    public function init()
    {   
        $element = new Sparx_SimpleText('name');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('menuname');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('title');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('keywords');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('description');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('content');
        $this->addElement($element);
        
    }
}
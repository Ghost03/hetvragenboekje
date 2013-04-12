<?php

class TranslateLanguageForm extends Sparx_BaseForm
{
    public function init()
    {
        $element = new Sparx_SimpleText('news');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('phonenumber');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('search');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('resultaten');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('adres');
        $element->setMedium();
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('more_news');
        $element->setMedium();
        $this->addElement($element);
    
    }
}
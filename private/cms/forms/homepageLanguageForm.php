<?php

class HomepageLanguageForm extends Sparx_BaseForm
{
    public function init()
    {   
        $element = new Sparx_SimpleTextarea('offers');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('about_us');
        $this->addElement($element);
        
        $element = new Sparx_SimpleTextarea('contact');
        $this->addElement($element);
    }
}
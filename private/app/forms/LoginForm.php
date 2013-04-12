<?php

class LoginForm extends Sparx_BaseForm
{    
    public function __construct()
    {
        $element = new Sparx_SimpleText('email');
        $element->setRequired(true)
                ->addValidator('EmailAddress');
        $this->addElement($element);
        
        $element = new Sparx_SimplePassword('password');
        $element->setRequired(true);
        $element->addFilter('Null');
        $this->addElement($element);
    }
}

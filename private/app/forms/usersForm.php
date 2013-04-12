<?php

class usersForm extends Sparx_BaseForm
{
    public function __construct()
    {
        $element = new Sparx_SimpleText('email');
        $element->setRequired(true)
                ->setAttrib('placeholder', 'E-mail');
        $this->addElement($element);

        $element = new Sparx_SimpleText('name');
        $element->setRequired(true) 
                ->setAttrib('placeholder', 'Naam');
        $this->addElement($element);
        
        $element = new Sparx_SimplePassword('password');
        $element->setRequired(true)
                ->setAttrib('placeholder', 'Wachtwoord');
        $this->addElement($element);
    }
}

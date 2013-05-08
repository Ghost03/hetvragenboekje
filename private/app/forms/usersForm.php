<?php

class usersForm extends Sparx_BaseForm
{
    public function __construct()
    {
        $element = new Sparx_SimpleText('email');
        $element->setRequired(true);
        $this->addElement($element);

        $element = new Sparx_SimpleText('name');
        $element->setRequired(true);
        $this->addElement($element);
        
        $element = new Sparx_SimplePassword('password');
        $element->setRequired(true);
        $this->addElement($element);
    }
}

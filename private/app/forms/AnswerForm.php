<?php

class AnswerForm extends Sparx_BaseForm
{    
    public function __construct()
    {
        $element = new Sparx_SimpleTextarea('name');
        $element->setRequired(true);
        $this->addElement($element);
    }
}

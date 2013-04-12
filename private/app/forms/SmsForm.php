<?php

class SmsForm extends Sparx_BaseForm
{    
    public $type;
    
    public function __construct($type) {
        $this->type = $type;
        
        parent::__construct();
    }
    
    public function init()
    {   
        if($this->type != 'code') {
            $element = new Sparx_SimpleText('cellphone');
            $element->setRequired(true);
            $this->addElement($element);   
        } else {        
            $element = new Sparx_SimpleText('code');
            $element->setRequired(true);
            $this->addElement($element);         
        }
    }
}

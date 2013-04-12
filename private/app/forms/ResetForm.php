<?php

/**
 * Reset customer password
 */
class ResetForm extends Sparx_BaseForm
{
    /**
     * Create a reset form
     * @param string $type The type of reset form (request|reset)
     */
    public function __construct($type = 'request')
    {
        if($type == 'request') {
            $element = new Sparx_SimpleText('email');
            $element->setRequired(true)
                    ->addValidator('EmailAddress');
            $this->addElement($element);
        } else {       
            $element = new Sparx_SimplePassword('password');
            $element->setRequired(true);
            $this->addElement($element);            
        }
    }
}
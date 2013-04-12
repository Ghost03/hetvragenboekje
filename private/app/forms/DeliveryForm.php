<?php

class DeliveryForm extends Sparx_BaseForm
{    
    public function __construct()
    {    
        $element = new Sparx_SimpleRadio('delivery_type');
        $element->setRequired(true)
                ->setValue('direct')
                ->addMultiOptions(array(
                   'direct'  => 'Direct', 
                   'delayed' => 'Select a different date', 
                ));
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('delivery_date');
        $element->addValidator('Date');
        if($_POST && isset($_POST['delivery']) && $_POST['delivery'] == 'delayed')
            $element->setRequired();
        $this->addElement($element);        
    }
}

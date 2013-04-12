<?php

class AddressForm extends Sparx_BaseForm
{    
    public function __construct($type = '')
    {                
        $element = new Sparx_SimpleText('name');
        $element->setRequired(true)
                ->setBelongsTo($type);
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('street');
        $element->setRequired(true)
                ->setBelongsTo($type);
        $this->addElement($element);
                
        $element = new Sparx_SimpleText('zipcode');
        $element->setRequired(true)
                ->setBelongsTo($type)
                ->addFilter('StringToUpper')
                ->addFilter(new Sparx_Zipcode)
                ->addValidator('Regex', true, array(
                    'pattern'  => '/[0-9]{4}[ ]?[A-Z]{2}/i',
                    'messages' => array(
                        Zend_Validate_Regex::INVALID   => 'Your zipcode is invalid', //$this->translate('Your zipcode is invalid'),
                        Zend_Validate_Regex::NOT_MATCH => 'Your zipcode is invalid', //$this->translate('Your zipcode is invalid'), //"De postcode '%value%' is ongeldig",
                    )
                ));
        $this->addElement($element);
        
        $element = new Sparx_SimpleText('city');
        $element->setRequired(true)
                ->setBelongsTo($type);
        $this->addElement($element);
        
        $locale = Zend_Registry::get('locale');
        
        $element = new Sparx_SimpleSelect('country');
        $element->setRequired(true)
                ->addMultiOptions($locale->getTranslationList('Territory', $locale, 2))
                ->setValue('NL')
                ->setBelongsTo($type);
        $this->addElement($element);
        
        $element = new Sparx_SimpleCheck('different');
        $element->setBelongsTo($type);
        $this->addElement($element);
    }
}

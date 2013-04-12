<?php

class PaymentForm extends Sparx_BaseForm
{    
    public function __construct()
    {             
        $cache = Zend_Registry::get('cache-infinite');
        
        $gateways = $cache->load('msp_gateways');
        
        if(!$gateways) {            

            $config = Zend_Registry::get('config');

            $multisafepay = new Sparx_Payment_Multisafepay();

            $multisafepay->test                         = $config->multisafepay->TEST_API;
            $multisafepay->merchant['account_id']       = $config->multisafepay->ACCOUNT_ID;
            $multisafepay->merchant['site_id']          = $config->multisafepay->SITE_ID;
            $multisafepay->merchant['site_code']        = $config->multisafepay->SITE_CODE;
                        
            $gateways = array();
            foreach($multisafepay->getGateways() as $gateway)
                $gateways[ $gateway['id'] ] = $gateway['description'];
            
            ksort($gateways);
            
            $cache->save($gateways);            
        }
        
        $element = new Sparx_SimpleRadio('gateway');
        $element->addMultiOptions($gateways)
                ->setRequired(true)
                ->setValue('IDEAL');
        $this->addElement($element);
    }
}

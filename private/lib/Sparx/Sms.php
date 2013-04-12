<?php

class Sparx_Sms {
        
    /**
     * Generate a 6 character sms confirmation code
     * @return string 
     */
    public static function code() {
        $letters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $salt = '';
        for ($i = 0; $i < 6; $i++)
            $salt .= $letters[rand(1, 36)];
        return $salt;
    }
    
    /**
     * Send an sms to a customer
     */
    public static function send($to,$message)
    {
        $config = Zend_Registry::get('config');
        
        $parameters = array(
            'originator' => $config->mollie->from,
            'username'   => $config->mollie->username,
            'password'   => $config->mollie->password,
            'recipients' => $to,
            'message' 	 => $message,
        );

        $url = 'http://www.mollie.nl/xml/sms/';

        $client = new Zend_Http_Client;
        $client->setUri($url);
        foreach($parameters as $var => $value)
                $client->setParameterGet($var,$value);
        $client->request('GET');	
    }
    
}
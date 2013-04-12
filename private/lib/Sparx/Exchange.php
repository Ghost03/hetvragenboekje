<?php

class Sparx_Exchange implements Zend_Currency_CurrencyInterface
{
    public function getRate($from, $to)
    {
        if ($from !== "EUR") {
            throw new Exception('We can only exchange EUR');
        }
         
        switch ($to) {
            case 'USD':
                return 1.30;
            case 'GBP':
                return 0.83;
       }
 
       throw new Exception("Unable to exchange $to");
    }
}
?>
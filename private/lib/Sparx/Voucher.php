<?php

class Sparx_Voucher {
    
    public $code = false;
    public $value = 0;
    public $valid = false;
    public $coupon;
        
    public function __construct($code = false) {        
        if($code)
            $this->code = $code;
        
        $this->check();
    }
    
    public function check() {
        
        if(!$this->code) return false;
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare(' SELECT * 
                            FROM coupon 
                            WHERE code = :code 
                            AND (
                                (type = \'limited\' AND date_used IS NULL)
                                OR
                                type = \'unlimited\'
                            )
                            LIMIT 1');
        $q->bindValue(':code',$this->code);
        $q->execute();
        
        $this->coupon = $coupon = $q->fetch(PDO::FETCH_ASSOC);
        
        if($coupon) {
            $this->valid = true;
            $this->value = $coupon['value'];
            return true;
        }
        
        return false;            
    }    
}
<?php

class Sparx_Shop_Voucher {
   
    public $order_id;
    public $coupon_id;
    public $value;
    
    /**
     * Link a coupon to an order 
     */
    public function save() 
    {             
        $db = Zend_Registry::get('db');
        
        $data = array(
            'order_id'  => $this->order_id,
            'coupon_id' => $this->coupon_id,
            'value'     => $this->value,
        );
        
        $db->beginTransaction();
        
        // store order coupon
        $q = $db->prepare('INSERT INTO `order_has_coupon` (`' . implode('`,`',array_keys($data)) . '`) 
                           VALUES (:' . implode(',:',array_keys($data)) . ')');
        foreach($data as $var => $value)
            $q->bindValue(":$var",$value);
        $q->execute();

        // update coupon
        $q = $db->prepare('UPDATE `coupon` SET `usage_count` = `usage_count` + 1 WHERE id = :id');
        $q->bindValue(':id',$this->coupon_id);
        $q->execute();
        
        $db->commit();
    }
    
}
<?php

class Sparx_Shop_OrderLine {
    
    public $order_id;
    public $order_customer_id;
    public $product_size_id;
    public $quantity;
    public $price;
    
    /**
     * Save an orderline to the database and decrease the stock of the product
     * that is linked to this orderline
     */
    public function save() 
    {             
        $db = Zend_Registry::get('db');
        
        $data = array(
            'order_id' => $this->order_id,
            'order_customer_id' => $this->order_customer_id,
            'product_size_id' => $this->product_size_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
        );
        
        $db->beginTransaction();
        
        // store order info
        $q = $db->prepare('INSERT INTO `order_line` (`' . implode('`,`',array_keys($data)) . '`) 
                           VALUES (:' . implode(',:',array_keys($data)) . ')');
        foreach($data as $var => $value)
            $q->bindValue(":$var",$value);
        $q->execute();

        // update product stock
        $q = $db->prepare('UPDATE `product_size` SET stock = stock - :quantity WHERE id = :id');
        $q->bindValue(':id',$this->product_size_id);
        $q->bindValue(':quantity',$this->quantity);
        $q->execute();
        
        $db->commit();
    }
    
    /**
     * Cancel an order line
     */
    public function cancel($delete = true)
    {
        $db = Zend_Registry::get('db');
                
        $db->beginTransaction();
        
        // delete an order line
        if($delete) 
        {
            $q = $db->prepare('DELETE FROM `order_line` WHERE order_id = :order_id AND product_size_id = :product_size_id LIMIT 1');
            $q->bindValue(':order_id',$this->order_id);
            $q->bindValue(':product_size_id',$this->product_size_id);
            $q->execute();
        }

        // update product stock
        $q = $db->prepare('UPDATE `product_size` SET stock = stock + :quantity WHERE id = :id');
        $q->bindValue(':id',$this->product_size_id);
        $q->bindValue(':quantity',$this->quantity);
        $q->execute();
        
        $db->commit();
    }
    
    /**
     * Populate an orderline
     * @param array $data
     * @return Sparx_Shop_OrderLine 
     */
    public function populate($data) {
        foreach($data as $var => $value)
            $this->$var = $value;
        return $this;
    }
    
}
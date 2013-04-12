<?php

/**
 * Logged in shop customer
 * 
 * All products are also stored in the database
 */
class Sparx_Shop_CustomerCart extends Sparx_Shop_Shoppingcart {
    
   private $customer;
    
   public function __construct($customer = false,$language = false)
   {
       $this->customer = $customer;
       
       parent::__construct($language);
   }
   
   public function add($id, $quantity) {
       $product = parent::add($id, $quantity);
       
       $db = Zend_Registry::get('db');
       $q = $db->prepare('INSERT INTO customer_basket (customer_id,product_size_id,quantity) VALUES (:customer_id,:product_size_id,:quantity)');
       $q->bindValue(':customer_id',$this->customer);
       $q->bindValue(':product_size_id',$id);
       $q->bindValue(':quantity',$quantity);
       $q->execute();
       
       return $product;
   }
   
   public function update($id, $quantity) {
       $product = parent::update($id, $quantity);
       
       $db = Zend_Registry::get('db');
       $q = $db->prepare('UPDATE customer_basket SET quantity = :quantity WHERE product_size_id = :product_size_id AND customer_id = :customer_id LIMIT 1');
       $q->bindValue(':customer_id',$this->customer);
       $q->bindValue(':product_size_id',$id);
       $q->bindValue(':quantity',$quantity);
       $q->execute();
       
       return $product;
   }
   
   public function delete($id) {       
       $db = Zend_Registry::get('db');
       $q = $db->prepare('DELETE FROM customer_basket WHERE product_size_id = :product_size_id AND customer_id = :customer_id LIMIT 1');
       $q->bindValue(':customer_id',$this->customer);
       $q->bindValue(':product_size_id',$id);
       $q->execute();
       
       parent::delete($id);
   }
   
}
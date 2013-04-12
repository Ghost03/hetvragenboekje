<?php

class Sparx_Address {
    
    private $customer;
        
    private $id = false;
    
    private $data;
    
    private $type;
    
    public function __construct($type = '',$id = false) 
    {
        $this->type = $type;        
        if(!$id) return;
        
        $this->id = $id;
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT * FROM customer_address WHERE id = :id LIMIT 1');  
        $q->bindValue(":id",$this->id);
        $q->execute();
        
        $this->data = $q->fetch(PDO::FETCH_ASSOC);
        
        if(!$this->data) return false;
        return true;
    }
    
    public function __toString() {
        return $this->data['name'] . '<br/>' . $this->data['street'] . ' ' . $this->data['number'] . '<br/>' . $this->data['zipcode'] . ' ' . $this->data['city'];
    }
    
    public function findOneByCustomerAndType($customer,$type) 
    {        
        $this->type = $type;                
        
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT * FROM customer_address WHERE customer_id = :customer AND type = :type ORDER BY id DESC LIMIT 1');  
        $q->bindValue(":type",$type);
        $q->bindValue(":customer",$customer);
        $q->execute();
        
        $this->data = $q->fetch(PDO::FETCH_ASSOC);
        
        if(!$this->data) return false;
        
        $this->id = $this->data['id'];
        
        return true;
    }
    
    public function setCustomer($customer) 
    {
        $this->customer = $customer;
    }
    
    public function setData($data) 
    {
        foreach($data as $var => $value) {
            if($var == 'id') $this->id = $value;
            $this->data[$var] = $value;
        }
    }
    
    public function getData() 
    {
        return $this->data;
    }
    
    public function isUsedInOrder() 
    {
        $db = Zend_Registry::get('db');
        $q = $db->prepare('SELECT id FROM `order` WHERE delivery_id = :id OR invoice_id = :id');  
        $q->bindValue(":id",$this->id);
        $q->execute();        
        return $q->fetchColumn();
    }
    
    /**
     * Edit or update a customer address
     */
    public function save() 
    {
        $db = Zend_Registry::get('db');
        
        unset($this->data['different']);
                    
        if($this->id) {
            $sql = array();
            foreach($this->data as $var => $value)
                $sql[] = "`$var` = :$var";
            $q = $db->prepare('UPDATE customer_address SET ' . implode(',',$sql) . ' WHERE id = :id');   
            $q->bindValue(":id",$this->id);
        } else {
            $this->data['customer_id'] = $this->customer;
            $this->data['type'] = $this->type;
            $q = $db->prepare('INSERT INTO customer_address (`' . implode('`,`',array_keys($this->data)) . '`) 
                               VALUES (:' . implode(',:',array_keys($this->data)) . ')');        
        }
               
        foreach($this->data as $var => $value)
            $q->bindValue(":$var",$value);
        
        $q->execute();
        
        return $db->lastInsertId();
    }
}
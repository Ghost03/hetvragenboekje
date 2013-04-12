<?php

class Sparx_Shop_Order {
    
    private $id = false;  
    private $date_created;
    private $price;
    private $transaction_id;
             
    private $order_status;
    
    private $delivery_status;
    private $delivery_date; 
    
    private $payment_gateway = '';
    private $payment_status = '';
    private $payment_method = '';
    private $payment_date = '';
    private $cart = false;
        
    public $vouchers = array();
    
    public $order_id;
    public $customer_id;
    public $delivery_id;
    public $invoice_id;
    public $email_send = 0;
    public $extra = '';
    public $delivery_price = 0;
    public $delivery_track = '';
    
    public $transaction_fee = 0;
    
    public function __construct($id = false,$key = 'id') 
    {
        $config = Zend_Registry::get('config');
        $this->delivery_price = $config->delivery->price;
        
        $this->date_created   = date('Y-m-d H:i:s');
        $this->payment_status = 'PENDING';
        $this->order_status   = 'AWAITING PAYMENT';
        
        if($id) {            
            $db = Zend_Registry::get('db');
            
            $q = $db->prepare('SELECT * FROM `order` WHERE ' . $key . ' = :id LIMIT 1');
            $q->bindValue(":id",$id);
            $q->execute();
            
            $order = $q->fetch(PDO::FETCH_ASSOC);
            
            if(!$order) return false;
            
            foreach($order as $var => $value)
                $this->$var = $value;
            
            return $this;
        }
    }
    
    public static function setUniqueOrderId($id)
    {
        $db = Zend_Registry::get('db');
        
        $q = $db->prepare('SELECT order_id FROM `order` ORDER BY order_id DESC LIMIT 1');
        $q->execute();
        $order_id = $q->fetchColumn();
        
        $order_id++;
        
        $q = $db->prepare('UPDATE `order` 
                           SET order_id = :order_id
                           WHERE id = :id 
                           AND order_id IS NULL LIMIT 1');
        $q->bindValue(":id",$id);
        
        $store = true;
        while($store) {
            try {
                $q->bindValue(":order_id",$order_id);
                $q->execute();
                $store = false;
            } catch(Exception $e){
                $order_id++;
            }
        }
        
        return $order_id;
    }
    
    public function updateStatus($status = '',$type = false) 
    {
        $db = Zend_Registry::get('db');
        
        $status = strtoupper($status);
        
        if($type == 'payment') {
            $this->payment_status = $status;            
            if($status == 'COMPLETED') {
                $this->updateStatus('AWAITING DELIVERY','order');
                $this->sendEmail();
                $this->createCoupon();
            }
        } elseif($type == 'delivery') {
            $this->delivery_status = $status;
            
            if($status == 'PLANNED')
                $this->updateStatus('DELIVERY SCHEDULED','order');
        } elseif($type == 'order') {
            $this->order_status = $status;
        } else
            throw new Exception('Invalid status update: ' . $type);
                
        $q = $db->prepare('UPDATE `order` SET ' . $type . '_status = :status WHERE id = :id LIMIT 1');
        $q->bindValue(":id",$this->id);
        $q->bindValue(":status",$status);
        $q->execute();
        
        $q = $db->prepare('INSERT INTO order_status (order_id,order_customer_id,type,code,date_created)
                           VALUES (:order_id,:customer_id,:type,:code,:date_created)');
        $q->bindValue(":order_id",$this->id);
        $q->bindValue(":customer_id",$this->customer_id);
        $q->bindValue(":date_created",date('Y-m-d H:i:s'));
        $q->bindValue(":type",$type);
        $q->bindValue(":code",$status);
        $q->execute();
        
        return $this;
    }
    
    public function sendEmail()
    {
        $db = Zend_Registry::get('db');
        
        // voor het geval dat
        Sparx_Shop_Order::setUniqueOrderId($this->id);
        
        // customer info
        $q = $db->prepare('SELECT firstname,lastname,email FROM customer WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$this->customer_id);
        $q->execute();
        $customer = $q->fetch(PDO::FETCH_ASSOC);
        
        $q = $db->prepare('SELECT order_id,email_send FROM `order` WHERE id = :id');
        $q->bindValue(':id',$this->id);
        $q->execute();
        $order = $q->fetch(PDO::FETCH_ASSOC);
        $this->order_id = $order['order_id'];
        
        // already send
        if($order['email_send'] > 0) return;
                
        // update the email status
        $q = $db->prepare('UPDATE `order` SET email_send = 1 WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$this->getId());
        $q->execute();
        
        // Send the email
        $mail = new Sparx_Mailer();
        $mail->setSubject('Orderbevestiging van order ' . $this->order_id . ' bij 5Minuten.tv');
        $mail->addTo($customer['email'], $customer['firstname'] . ' ' . $customer['lastname']);
        $mail->view->order = $this;
        $mail->view->customer = $customer;
        $mail->render('order/confirm.phtml');       
        $mail->send();
    }
    
    public function trackAndTrace($code,$view) 
    {
        $db = Zend_Registry::get('db');
                
        // update the track & trace code
        $q = $db->prepare('UPDATE `order` SET delivery_track = :code WHERE id = :id LIMIT 1');
        $q->bindValue(":id",$this->id);
        $q->bindValue(":code",$code);
        $q->execute();
                
        $this->delivery_track = $code;
        
        // already send
        if($this->email_send > 1) return;
            
        // customer info
        $q = $db->prepare('SELECT * FROM customer WHERE id = :id');
        $q->bindValue(':id', $this->customer_id);
        $q->execute();
        $customer = $q->fetch(PDO::FETCH_ASSOC);

        // delivery info
        $delivery = new Sparx_Address('delivery',$this->delivery_id);   
        $invoice = false;
        if($this->delivery_id != $this->invoice_id)
            $invoice = new Sparx_Address('invoice',$this->invoice_id);
        
        $config = Zend_Registry::get('config');
        
        // create invoice pdf       
        $pdf = new Sparx_Pdf('P', 'pt', 'LETTER');
        $pdf->view = $view;        
        $pdf->order = $this;
        $pdf->order_lines = $this->getOrderLines(true);
        $pdf->customer = $customer;
        $pdf->delivery = $delivery;
        $pdf->invoice = $invoice;
        $pdf->type = 'invoice';
        $pdf->CreateInvoice();
        $attachment = $pdf->Output('invoice.pdf','S');
        
        // create a mail attachment
        $at = new Zend_Mime_Part( $attachment );
        $at->type        = 'application/pdf';
        $at->disposition = Zend_Mime::DISPOSITION_INLINE;
        $at->encoding    = Zend_Mime::ENCODING_BASE64;
        $at->filename    = 'factuur.pdf';
        
        // Send the email
        $mail = new Sparx_Mailer();
        $mail->addAttachment($at);
        $mail->setSubject('Track & Trace van order ' . $this->order_id . ' bij 5Minuten.tv');
        $mail->addTo($customer['email'], $customer['firstname'] . ' ' . $customer['lastname']);
        $mail->view->address = $delivery;
        $mail->view->order = $this;
        $mail->view->customer = $customer;
        $mail->render('order/track-n-trace.phtml');       
        $mail->send();
        
        // update the email status
        $q = $db->prepare('UPDATE `order` SET email_send = 2 WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$this->id);
        $q->execute();
    }
    
    private function createCoupon() {
        
        $fields = array(
            'code'          => Sparx_Voucher::generate(8),
            'type'          => 'unlimited',
            'date_created'  => date('Y-m-d H:i:s'),
            'usage_count'   => 0,
            'value'         => 5,
            'customer_id'   => $this->customer_id,
        );
                
        $db = Zend_Registry::get('db');
        $q = $db->prepare('INSERT INTO coupon (' . implode(',',array_keys($fields)) . ')
                           VALUES (:' . implode(',:',array_keys($fields)) . ')');
        foreach($fields as $var => $value)
            $q->bindValue(":$var",$value);
        $q->execute();
        
        $q = $db->prepare('UPDATE `order` SET coupon_id = :coupon_id WHERE id = :id LIMIT 1');
        $q->bindValue(":id",$this->id);
        $q->bindValue(":coupon_id",$db->lastInsertId());
        $q->execute();
        
        $this->coupon_id = $db->lastInsertId();
    }
        
    public function save(Sparx_Shop_Shoppingcart $cart) 
    {        
        $db = Zend_Registry::get('db');
        
        $this->cart = $cart;
        
        $price = $cart->getPrice(false);
                        
        // delivery cost
        $config = Zend_Registry::get('config');
        if($price < $config->delivery->min) 
            $price += $this->delivery_price;
        else             
            $this->delivery_price = 0;
                
        // transaction cost
        if($this->transaction_fee != 'FREE')
            $price += $this->transaction_fee;
                        
        // voucher discount
        $discount = 0;
        foreach($this->vouchers as $voucher)
            $discount += $voucher['value'];
        
        $price -= $discount;
        
        // store order info
        $data = array(
            'order_status'  => $this->order_status,
            'date_created'  => $this->date_created,
            'delivery_date' => $this->delivery_date,
            'delivery_price'=> $this->delivery_price,
            'payment_status'=> $this->payment_status,
            'customer_id'   => $this->customer_id,
            'delivery_id'   => $this->delivery_id,
            'invoice_id'    => $this->invoice_id,
            'extra'         => $this->extra,
            'price'         => $price,
            'discount'      => $discount,
        );
                
        $q = $db->prepare('INSERT INTO `order` (`' . implode('`,`',array_keys($data)) . '`) 
                           VALUES (:' . implode(',:',array_keys($data)) . ')');
        foreach($data as $var => $value)
            $q->bindValue(":$var",$value);
        $q->execute();
        
        $this->id = $db->lastInsertId();
        
        // store order lines        
        $products = $cart->getProducts();
        foreach($products as $product)
            $this->createOrderLine($product);
        
        // store discount codes
        foreach($this->vouchers as $voucher)
            $this->createDiscount($voucher);
        
        // delete shoppingcart products
        $cart->delete();
        $cart->store();
        
        $data['id'] = $this->id;
        
        return $data;
    }
    
    public function getOrderLines($extended = false)
    {
        $db = Zend_Registry::get('db');
        
        if(!$extended)
            $q = $db->prepare('SELECT * FROM order_line WHERE order_id = :id');
        else {
            $q = $db->prepare('SELECT o.quantity, o.price, sl.name AS size, pl.name, pl.url, pl.description, ps.product_id, ps.number
                               FROM order_line o
                               LEFT JOIN product_size ps ON ps.id = o.product_size_id
                               LEFT JOIN product p ON p.id = ps.product_id
                               LEFT JOIN size_language sl ON sl.size_id = ps.size_id
                               LEFT JOIN product_language pl ON pl.product_id = ps.product_id
                               WHERE o.order_id = :id');
        }
        $q->bindValue(':id',$this->id);
        $q->execute();
        $orderline_data = $q->fetchAll(PDO::FETCH_ASSOC);        
                
        $orderlines = array();
        foreach($orderline_data as $data){
            $orderline    = new Sparx_Shop_OrderLine();
            $orderlines[] = $orderline->populate($data);
        }
                       
        return $orderlines;
    }
    
    public function createOrderLine($product) 
    {
        $orderline = new Sparx_Shop_OrderLine;
        $orderline->order_id = $this->id;
        $orderline->order_customer_id = $this->customer_id;
        
        $orderline->product_size_id = $product['id'];
        $orderline->quantity = $product['quantity'];
        $orderline->price = $product['price'];
        
        $orderline->save();
    }
    
    public function createDiscount($coupon) 
    {
        $voucher = new Sparx_Shop_Voucher;
        $voucher->order_id  = $this->id;
        $voucher->coupon_id = $coupon['id'];
        $voucher->value     = $coupon['value'];
        $voucher->save();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function getDate()
    {
        return $this->date_created;
    }
    
    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }
    
    public function setDeliveryDate($date)
    {
        $this->delivery_date = $date;
    }
    
    public function setPaymentMethod($method)
    {
        $this->payment_method = $method;
    }
    
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
    
    public function getPaymentGateway()
    {
        return $this->payment_gateway;
    }
    
    public function setPaymentDate($date)
    {
        $this->payment_date = $date;
    }
    
    public function getCustomerId()
    {
        return $this->customer_id;
    }
    
    public function getStatus($type = 'payment')
    {
        if($type == 'payment')
            return $this->payment_status;
        if($type == 'delivery')
            return $this->delivery_status;
        if($type == 'order')
            return $this->order_status;
    }    
}
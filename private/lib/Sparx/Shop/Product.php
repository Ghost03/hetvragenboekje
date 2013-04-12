<?php

class Sparx_Shop_Product {
     
    /**
     * The language of the product
     * @var type 
     */
    private $language;
    
    /**
     * The product data
     * @var type 
     */
    private $data;
    
    /**
     * Create a product form an array or a product id
     * @param type $product 
     */
    public function __construct($product,$language = false)
    {
        if(!$language)
            $language = Zend_Registry::get('language');
        $this->language = $language;
        
        if(!is_array($product)) {
            
            $db = Zend_Registry::get('db');
            $q = $db->prepare('SELECT 
                                    s.*,
                                    (p.price + s.price) as price, p.style, p.color_id,
                                    l.name, l.url, l.description,
                                    c.image AS color_image
                               FROM product_size s
                               LEFT JOIN product p ON s.product_id = p.id
                               LEFT JOIN product_language l ON l.product_id = p.id
                               LEFT JOIN color c ON c.id = p.color_id
                               WHERE s.id = :id
                               AND l.language_id = :language
                               LIMIT 1');
            $q->bindValue(':id',$product);
            $q->bindValue(':language',$this->language);
            $q->execute();

            $product = $q->fetch(PDO::FETCH_ASSOC);

            if(!$product)
                throw new Sparx_Shop_ProductException('Product not found');
        }
        
        $this->data = $product;
    }
    
    /**
     * Export a product
     * @return type 
     */
    public function export() 
    {
        return $this->data;
    }
    
    /**
     * Setter
     * @param type $var
     * @param type $value 
     */
    public function __set($var,$value) {
        $this->data[$var] = $value;
    }
    
    /**
     * Getter
     * @param type $var
     * @return type 
     */
    public function __get($var) {
        return isset( $this->data[$var] ) ? $this->data[$var] : null;
    }
        
}


class Sparx_Shop_ProductException extends Exception { }
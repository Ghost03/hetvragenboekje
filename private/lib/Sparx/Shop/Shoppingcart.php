<?php

/**
 * Sparx Shoppingcart
 * 
 * A shoppingcart is fixed to a customer;
 */
class Sparx_Shop_Shoppingcart {

    private $id = false;
    protected $language = false;
    protected $products = array();
    private static $instance;

    public static function getInstance() {
        if (self::$instance instanceof Sparx_Shop_Shoppingcart)
            return self::$instance;

        self::$instance = new Sparx_Shop_Shoppingcart(Zend_Registry::get('language'));

        return self::$instance;
    }

    /**
     * Create a new shoppingcart
     * @param type $language 
     */
    private function __construct($language) {
        $this->language = $language;

        // products are stored in the session
        $products = isset($_SESSION['products']) ? $_SESSION['products'] : false;
        if ($products)
            $this->products = json_decode($products, true);
    }

    /**
     * Get the price
     * @return type 
     */
    public function getPrice($display = true) {
        $currency = Zend_Registry::get('currency');
        $currency->setValue(0);

        foreach ($this->products as $product)
            $currency->add($product['price'] * $product['quantity'], 'EUR');

        if (!$display)
            return $currency->getValue();

        return $currency->toCurrency();
    }

    /**
     * Count the amount of products in the cart
     * @return integer 
     */
    public function countProducts() {
        return count($this->products);
    }

    /**
     * Get the products from the shoppingcart
     * @return array 
     */
    public function getProducts() {
        
        uasort($this->products,'productsort');
        
        return $this->products;
    }

    /**
     * Check wether the items in the shoppingcart have enough quantity
     * @return boolean Wether the stock of the cart has been updated
     */
    public function checkQuantities() {
        $db = Zend_Registry::get('db');
        $q = $db->prepare(' SELECT stock 
                            FROM product_size 
                            WHERE id = :id 
                            LIMIT 1');

        $stock_dirty = false;
        foreach ($this->products as $id => $product) {
            $q->bindValue(':id', $id);
            $q->execute();

            $stock = (int) $q->fetchColumn();

            if ($stock < $product['quantity']) {
                $product['stock'] = $stock;
                $product['quantity'] = $stock;
                $stock_dirty = true;
            }

            $this->products[$id] = $product;
                        
            if($stock < 1) {
                unset($this->products[$id]);
                $stock_dirty = true;
            }
        }

        $this->store();

        return $stock_dirty;
    }

    /**
     * Add a product to the shopping cart
     * 
     * @param type $id
     * @param type $quantity
     * @return type 
     */
    public function add($id, $quantity = 0) {
        $product = new Sparx_Shop_Product($id);
        $product->quantity = $quantity ? $quantity : 1;

        if($product->stock < $product->quantity) 
            return false;
        
        $this->products[$id] = $product->export();
        return $this->products[$id];
    }

    /**
     * Update the quantity of a shoppingcart product
     * @param type $id
     * @param type $quantity
     * @return type 
     */
    public function update($id, $quantity) {
        if (!isset($this->products[$id]))
            return $this->add($id, $quantity);

        if ($quantity < 1)
            return $this->delete($id);

        $product = new Sparx_Shop_Product($this->products[$id]);
        $product->quantity = $quantity;

        $this->products[$id] = $product->export();

        return $this->products[$id];
    }

    /**
     * Replace a product with another product
     * @param type $id
     * @param type $replacement
     * @return type 
     */
    public function color($id, $id_new) {
        if(!isset($this->products[$id]))
            return false;
             
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
                           WHERE p.id = :id
                           AND s.size_id = :size
                           AND l.language_id = :language
                           LIMIT 1');
        $q->bindValue(':id',$id_new);
        $q->bindValue(':size',$this->products[$id]['size_id']);
        $q->bindValue(':language',$this->language);
        $q->execute();
        
        $product = new Sparx_Shop_Product($q->fetch(PDO::FETCH_ASSOC));
        
        if(!$product)           return false; 
        if($product->stock < 1) return false;
        
        unset($this->products[$id]);
        
        $product->quantity = 1;        
                
        $this->products[ $product->id ] = $product->export();
        
        return $this->products[$product->id];
    }

    /**
     * Replace a product with another product
     * @param type $id
     * @param type $replacement
     * @return type 
     */
    public function size($id, $id_new) {        
        $quantity = isset($this->products[$id]) ? $this->products[$id]['quantity'] : 1;
        unset($this->products[$id]);

        $product = new Sparx_Shop_Product($id_new);
        if ($product->stock < $quantity)
            $quantity = 1;

        $product->quantity = $quantity;
        $this->products[$id_new] = $product->export();
        
        return $this->products[$id_new];
    }

    /**
     * Delete a product from the shoppingcart
     * @param mixed $key
     */
    public function delete($key = false) {
        if (is_numeric($key))
            unset($this->products[$key]);
        else
            $this->products = array();
    }

    /**
     * Store the shoppingcart
     */
    public function store() {
        $_SESSION['products'] = json_encode($this->products);
    }

}

function productsort($a, $b) {
    $a = ord(substr($a['name'],0,1));
    $b = ord(substr($b['name'],0,1));
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

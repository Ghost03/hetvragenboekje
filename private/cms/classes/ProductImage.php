<?php

class ProductImage {
    
    private $product = false;
    private $path    = '';
    
    public function __construct($id)
    {
        $db = Zend_Registry::get('db');
        
        $q = $db->prepare('SELECT * FROM product WHERE id = :id');
        $q->bindValue(':id',$id);
        $q->execute();
        
        $this->product = $q->fetch(PDO::FETCH_OBJ);
        
        $this->path = DOCROOT . '../uploads/';
    }
    
    public function upload() 
    {        
        if(!isset($_FILES['Filedata'])) die('Invalid file');
        
        $tempFile   = $_FILES['Filedata']['tmp_name'];
	$targetPath = $this->path . 'tmp/';
	$targetFile = time() . '-' .  $_FILES['Filedata']['name'];
        
	$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	$fileTypes  = str_replace(';','|',$fileTypes);
	$typesArray = explode('|',$fileTypes);
	$fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$typesArray)) {
            move_uploaded_file($tempFile,$targetPath . $targetFile);
            echo $targetFile;
	} else {
            echo 'Invalid file type.';
	}
        exit;
    }
    
    public function generate() 
    {
        $code = $_POST['code'];
        
        // get the product image from the database        
        $db = Zend_Registry::get('db');
        
        $q = $db->prepare('SELECT * FROM product_image WHERE product_id = :product_id AND code = :code LIMIT 1');
        $q->bindValue(':product_id',$this->product->id);
        $q->bindValue(':code',$code);
        $q->execute();
        
        $image = $q->fetch(PDO::FETCH_OBJ);
        
        if(!$image) {
            $q = $db->prepare('INSERT INTO product_image (product_id,code) VALUES (:product_id,:code)');
            $q->bindValue(':product_id',$this->product->id);
            $q->bindValue(':code',$code);
            $q->execute();
            
            $image = new stdClass();
            $image->id = $db->lastInsertId();
            $image->src = '';
        }
        
        // delete original image + thumb
        if($image->src != '') {
            @unlink($this->path . 'product/' . $src);
            @unlink($this->path . 'product/thumb/' . $src);
        }
        
        // move uploaded file to the product directory
        $file_orig = 'tmp/' . $_POST['image'];
        $parts = explode('.',$file_orig);
        
        $file_prod = time() . '-' . $code . '.' . end($parts);
        
        rename($this->path . $file_orig,
               $this->path . 'product/' . $file_prod);
        
        $q = $db->prepare('UPDATE product_image SET src = :src WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$image->id);
        $q->bindValue(':src',$file_prod);
        $q->execute();
        
        $response = array(
            'image' => $file_prod
        );
        
        echo json_encode($response);
        exit;
    }
    
    public function delete() 
    {
        $code = $_POST['code'];
        
        $db = Zend_Registry::get('db');
        
        $q = $db->prepare('SELECT * FROM product_image WHERE product_id = :product_id AND code = :code LIMIT 1');
        $q->bindValue(':product_id',$this->product->id);
        $q->bindValue(':code',$code);
        $q->execute();
        
        $image = $q->fetch(PDO::FETCH_OBJ);
        
        if(!$image) die('OK');
        
        // delete original image + thumb
        if($image->src != '') {
            @unlink($this->path . 'product/' . $src);
            @unlink($this->path . 'product/thumb/' . $src);
        }
        
        $q = $db->prepare('DELETE FROM product_image WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$image->id);
        $q->execute();
        
        die('OK');
    }
    
}
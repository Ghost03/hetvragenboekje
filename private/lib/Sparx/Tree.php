<?php

class Sparx_Tree {
    
    public $max = false;
    
    private $branches;
    
    public function __construct($branches) 
    {
        $this->branches = $branches;        
    }
    
    public function build($parent,$level = 0) 
    {
        $result = array();        
        foreach($this->branches as $i => $branch) {
            if((string)$parent == $branch['category_id']) {
                
                if(!$this->max || $level < $this->max)
                    $branch['children'] = $this->build($parent . ',' . $branch['id'],$level + 1);
                
                $branch['name'] = str_pad('',$level * 2,'- ',STR_PAD_LEFT) . $branch['name'];
                $branch['key']  = $parent . ',' . $branch['id'];
                $result[] = $branch;
                unset($this->branches[$i]);
            } 
        }        
        return $result;        
    } 
    
}
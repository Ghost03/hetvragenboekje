<?php

/**
 * Breadcrumb view helper
 * 
 * @author Frank Broersen
 */
class Sparx_View_Helper_BreadCrumb extends Zend_View_Helper_Abstract {

    /**
     * Breadcrumb
     * @var array
     */
    protected $_breadcrumb = array();

    /**
     * Separator
     * @var type 
     */
    private $_separator = '';
    
    /**
     * Element wrappers
     */
    private $_wrapper_open = '<ul class=breadcrumb>';
    private $_wrapper_close = '</ul>';
    private $_element_open = '<li:class>';
    private $_element_close = '</li>';
    private $_class_first = 'first';
    private $_class_last = 'last';

    /**
     * Add 1 or more url | title pairs to the breadcrumb
     * @return Sparx_View_Helper_BreadCrumb 
     */
    public function breadcrumb() {
        $args = func_get_args();

        $count = count($args);
        if ($count == 1 && is_array($args[0])) {
            foreach ($args[0] as $u => $n)
                $this->_breadcrumb[] = array('url'=>$u,'name'=>$n);
        } elseif ($count ==  2) {
            $this->_breadcrumb[] = array('url'=>$args[0],'name'=>$args[1]);
        } elseif ($count == 1) {
            $this->_breadcrumb[] = array('url'=>$args[0],'name'=>$args[0]);
        }
        return $this;
    }
    
    public function pre($url,$name)
    {        
        array_unshift($this->_breadcrumb,array('url'=>$url,'name'=>$name));
        return $this;
    }

    /**
     * Compile and output the breadcrumb
     * @return string
     */
    public function __toString() {    
                
        if(!$this->_breadcrumb) return '';
        
        $breadcrumb = '<div class="breadcrumbs">';	        
        $last  = false;
        foreach ($this->_breadcrumb as $i => $part) {
            unset($this->_breadcrumb[$i]);
            
            if(!$this->_breadcrumb) $last = true;
            
            $breadcrumb .= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                              <a href="' . $part['url'] . '" itemprop="url">
                                <span itemprop="title">' . $this->view->escape($part['name']) . '</span>
                              </a> ' . ($last ? '' : '&rsaquo;') . '
                            </div> ';            
        }
        $breadcrumb .= '</div>';
        return $breadcrumb;
    }

}
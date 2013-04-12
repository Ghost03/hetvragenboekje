<?php

class ProductForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $db = Zend_Registry::get('db');
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $language_id = $request->language;

        $q = $db->prepare('SELECT c.id,c.parent_id, cl.name 
                           FROM category AS c
                           LEFT JOIN category_language cl ON cl.category_id = c.id
                           WHERE cl.language_id = ?
                           ORDER BY c.parent_id > 0 ASC,c.parent_id ASC
                           ');
        $q->execute(array($language_id));        
        $categories = $q->fetchAll(PDO::FETCH_ASSOC);

        $options = array();
        $disable = array();
        
        foreach($categories as $i => $category) {
            if($category['parent_id'] > 0) 
                continue;
            $options[ $category['id'] ] = $category['name'];
            $disable[] = $category['id'];
        
            foreach($categories as $j => $subcategory) {
                if($subcategory['parent_id'] != $category['id']) 
                    continue;         
                $options[ $subcategory['id'] ] = '- ' . $subcategory['name'];
                unset($categories[$j]);
            }   
            unset($categories[$i]);
        }

        $element = new Sparx_SimpleSelect('category_id');
        $element->setShort()
                ->addMultiOption(false,'-- No category --')
                ->addMultiOptions($options)
                ->setAttrib('disable',$disable);
        $this->addElement($element);

        foreach( $this->languages as $language ) {
            $form = new ProductLanguageForm();
            $form->setElementsBelongTo($language->code);
            $this->addSubForm($form,$language->name);
        }
    }
}
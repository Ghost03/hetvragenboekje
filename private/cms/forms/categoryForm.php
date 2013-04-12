<?php

class CategoryForm extends Sparx_BaseForm
{
    
    public function init()
    {   
        $db = Zend_Registry::get('db');

        $q = $db->prepare('SELECT cl.category_id, cl.name FROM category_language AS cl
                           LEFT JOIN category AS c ON cl.category_id = c.id
                           WHERE c.parent_id = 0
                           AND cl.language_id = :language_id');
        $q->bindValue(':language_id', $this->language);
        $q->execute();
        $menu_items = $q->fetchAll(PDO::FETCH_KEY_PAIR);
        
        $element = new Sparx_SimpleSelect('parent_id');
        $element->setShort()
                ->addMultiOption(false,'-- No parent page --')
                ->addMultiOptions($menu_items);
        $this->addElement($element);
        
        foreach( $this->languages as $language ) {
            $form = new CategoryLanguageForm();
            $form->setElementsBelongTo($language->code);
            $this->addSubForm($form,$language->name);
        }
    }
}
<?php

class QuestionForm extends Sparx_BaseForm
{
    public function __construct()
    {
    	$db = Zend_Registry::get('db');
    	
    	$q = $db->prepare('SELECT id,name FROM categories ORDER BY name');
        $q->execute();
    	$categories = $q->fetchAll(PDO::FETCH_KEY_PAIR);

        $element = new Sparx_SimpleSelect('category_id');
        $element->setShort()
                ->setRequired(true)
                ->addMultiOptions($categories);
        $this->addElement($element);

        $element = new Sparx_SimpleTextarea('name');
        $this->addElement($element);

        $element = new Sparx_SimpleText('tags');
        $this->addElement($element);
    }
}

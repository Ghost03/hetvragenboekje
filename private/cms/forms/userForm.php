<?php

class userForm extends Sparx_BaseForm
{
    public function __construct()
    {
        $firstName = new Sparx_SimpleText('name');
        $firstName->setRequired(true);
        $this->addElement($firstName);
        
        $lastName = new Sparx_SimpleText('lastname');
        $lastName->setRequired(true);
        $this->addElement($lastName);
        
        $email = new Sparx_SimpleText('email');
        $email->setRequired(true)
            ->addValidator('EmailAddress');
        $this->addElement($email);
        
        $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        
        $password = new Sparx_SimplePassword('password');
        if($action == 'add')
            $password->setRequired(true);
        $password->addFilter('Null');
        $this->addElement($password);
        
        $active = new Sparx_SimpleCheck('active');
        $active->setRequired(true);
        $this->addElement($active);
        $this->setDefault('active', true);

        $admin = new Sparx_SimpleCheck('admin');
        $admin->setRequired(true);
        $this->addElement($admin);
        $this->setDefault('admin', false);
    }
}

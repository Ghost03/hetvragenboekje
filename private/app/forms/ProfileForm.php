<?php

class ProfileForm extends Sparx_BaseForm
{
    public function __construct()
    {
        $element = new Sparx_SimpleText('name');
        $element->setRequired(true)
                ->addFilter('StripTags');
        $this->addElement($element);

        $element = new Sparx_SimpleText('lastname');
        $element->addFilter('StripTags');
        $this->addElement($element);

        $element = new Sparx_SimpleText('email');
        $element->addFilter('StripTags');
        $this->addElement($element);
    }
}

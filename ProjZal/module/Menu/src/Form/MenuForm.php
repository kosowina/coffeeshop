<?php
namespace Menu\Form;

use Zend\Form\Form;

class MenuForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('menu');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'category',
            'type' => 'text',
            'options' => [
                'label' => 'Category',
            ],
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'price',
            'type' => 'text',
            'options' => [
                'label' => 'Price',
            ],
        ]);        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
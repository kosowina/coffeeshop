<?php
namespace Home\Form;

use Zend\Form\Form;

class HomeForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Home');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'about',
            'type' => 'text',
            'options' => [
                'label' => 'about',
            ],
        ]);
        $this->add([
            'name' => 'open',
            'type' => 'text',
            'options' => [
                'label' => 'open',
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
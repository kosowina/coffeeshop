<?php
namespace Menu\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Menu
{
    public $id;
    public $category;
    public $name;
	public $price;
	
    private $inputFilter;

    public function exchangeArray($data)
    {
        $this->id     = isset($data['id']) ? $data['id'] : null;
        $this->category = isset($data['category']) ? $data['category'] : null;
        $this->name  = isset($data['name']) ? $data['name'] : null;
		$this->price  = isset($data['price']) ? $data['price'] : null;

    }
	public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'category' => $this->category,
            'name'  => $this->name,
			'price'  => $this->price,
        ];
    }
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'category',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 75,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 75,
                    ],
                ],
            ],
        ]);
		
        $inputFilter->add([
            'name' => 'price',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 8,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
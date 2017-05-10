<?php
namespace Product\Model;

class Product
{
    public $id;
    public $brand;
    public $name;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->brand = !empty($data['brand']) ? $data['brand'] : null;
        $this->name  = !empty($data['name']) ? $data['name'] : null;
    }
}
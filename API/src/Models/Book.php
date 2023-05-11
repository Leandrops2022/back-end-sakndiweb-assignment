<?php

namespace MyTest\Models;

class Book extends Product
{
    private float $weight;

    public function __construct(
        string $productType,
        string $sku,
        string $name,
        float $price,
        float $weight
    ) {
        parent::__construct($productType, $sku, $name, $price);
        $this->weight = $weight;
    }

    public function setSku($sku)
    {
        $this->sku = 'B'.$sku;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getProductInfo():array
    {
        return array(
            'productType' => $this->getProductType(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'weight' => $this->getWeight()
        );
    }
}
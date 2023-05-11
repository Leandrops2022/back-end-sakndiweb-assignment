<?php

namespace MyTest\Models;

class Dvd extends Product
{

    private int $size;

    public function __construct(
        string $productType,
        string $sku,
        string $name,
        float $price,
        int $size
    ) {
        parent::__construct($productType, $sku, $name, $price);
        $this->size = $size;
    }

    public function setSku($sku)
    {
        $this->sku = 'D'.$sku;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getProductInfo(): array
    {
        return array(
            'productType' => $this->getProductType(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'size' => $this->getSize()
        );
    }
}
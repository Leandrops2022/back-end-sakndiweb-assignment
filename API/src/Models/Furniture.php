<?php

namespace MyTest\Models;

class Furniture extends Product
{
    private int $height;
    private int $width;
    private int $length;

    public function __construct(
        string $productType,
        string $sku,
        string $name,
        float $price,
        int $height,
        int $width,
        int $length)
    {
        parent::__construct($productType, $sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function setSku($sku)
    {
        $this->sku = 'F'.$sku;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getProductInfo(): array
    {
        return array(
            'productType' => $this->getProductType(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'length' => $this->getLength(),
        );
    }
}
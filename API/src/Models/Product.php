<?php

namespace MyTest\Models;

use InvalidArgumentException;

abstract class Product
{
    protected int $id;
    protected string $productType;
    protected string $sku;
    protected string $name;
    protected float $price;

    public function __construct(
        string $productType,
        string $sku,
        string $name,
        float $price
    ) {
        $this->productType = $productType;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public abstract function setSku($sku);

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public abstract function getProductInfo(): array;
}
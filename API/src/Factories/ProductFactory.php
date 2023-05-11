<?php

namespace MyTest\Factories;

use InvalidArgumentException;

class ProductFactory
{
    private array $factories = [];

    public function registerFactory(
        string $productType,
        IProductFactory $factory
    ) {
        $this->factories[$productType] = $factory;
    }

    public function create(string $productType, array $properties)
    {
        if (!isset($this->factories[$productType])) {
            throw new InvalidArgumentException('Invalid productType');
        }
        return $this->factories[$productType]->createProduct($properties);
    }
}
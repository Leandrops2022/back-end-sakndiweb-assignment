<?php

namespace MyTest\Factories\Strategies;

use MyTest\Factories\IProductFactory;
use MyTest\Models\Furniture;

class FurnitureFactory implements IProductFactory
{
    public function createProduct($properties): Furniture
    {
        $properties = array_values($properties);

        return new Furniture(...$properties);
    }
}
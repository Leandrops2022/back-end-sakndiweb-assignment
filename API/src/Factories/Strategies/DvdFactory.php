<?php

namespace MyTest\Factories\Strategies;

use MyTest\Factories\IProductFactory;
use MyTest\Models\Dvd;

class DvdFactory implements IProductFactory
{
    public function createProduct($properties): Dvd
    {
        $properties = array_values($properties);

        return new Dvd(...$properties);
    }
}
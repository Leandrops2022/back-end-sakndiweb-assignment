<?php

namespace MyTest\Factories\Strategies;

use MyTest\Factories\IProductFactory;
use MyTest\Models\Book;

class BookFactory implements IProductFactory
{
    public function createProduct($properties): Book
    {
        $properties = array_values($properties);

        return new Book(...$properties);
    }
}
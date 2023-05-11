<?php

namespace MyTest\Services\Validators;

use InvalidArgumentException;

abstract class SkuValidator implements IValidator
{
    public static function validate($property)
    {
        if (
            empty($property)
            || strlen($property) > 60
            || preg_match('/[^a-zA-Z0-9.\-]/', $property)
        ) {
            header("HTTP/1.1 400 Bad Request");
            throw new InvalidArgumentException(
                'SKU Error! SKU must not be empty and can have up to 60 
                characters: numbers, letters or -'
            );
        }
    }
}
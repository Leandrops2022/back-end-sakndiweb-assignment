<?php

namespace MyTest\Services\Validators;

use InvalidArgumentException;

abstract class PriceValidator implements IValidator
{
    public static function validate($property)
    {
        if (
            floatval($property) <= 0
            || !preg_match('/^\d{1,6}(\.\d{1,2})?$/', $property)
        ) {
            header("HTTP/1.1 400 Bad Request");
            throw new InvalidArgumentException(
                'Invalid price! Only positive numbers are accepted up to a 
                maximum of 999999.99'
            );
        }
    }
}
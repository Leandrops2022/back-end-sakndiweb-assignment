<?php

namespace MyTest\Services\Validators;

use InvalidArgumentException;

abstract class WeightValidator implements IValidator
{
    public static function validate($property)
    {
        if (
            !preg_match('/^\d{1,2}(\.\d{1,3})?$/', $property)
            || floatval($property) <= 0
        ) {
            header("HTTP/1.1 400 Bad Request");
            throw new InvalidArgumentException(
                'The weight provided is not valid. Must be a positive number
                 less than 100. ex: 99.999'
            );
        }
    }
}
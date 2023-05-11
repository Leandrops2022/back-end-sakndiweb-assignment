<?php

namespace MyTest\Services\Validators;

use InvalidArgumentException;

abstract class DimensionsValidator implements IValidator
{
    public static function validate($property)
    {
        if (
            preg_match('/[^0-9]/', $property)
            || intval($property) < 0
        ) {
            header("HTTP/1.1 400 Bad Request");
            throw new InvalidArgumentException(
                "Only positive numbers are allowed in dimensions"
            );
        }

    }
}
<?php

namespace MyTest\Services\Validators;

use InvalidArgumentException;

abstract class NameValidator implements IValidator
{
    public static function validate($property)
    {
        if (
            empty($property)
            || strlen($property) > 60
            || preg_match('/[^a-zA-Z0-9.\- ]/', $property)
        ) {
            header("HTTP/1.1 400 Bad Request");
            throw new InvalidArgumentException(
                'Error! The name can not be empty or bigger than 60 
                        characters nor contain special characters'
            );
        }
    }
}
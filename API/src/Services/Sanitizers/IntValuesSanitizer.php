<?php

namespace MyTest\Services\Sanitizers;

abstract class IntValuesSanitizer implements ISanitizer
{
    public static function sanitize($property)
    {
        $property = preg_replace('/[^0-9]/', '', $property);

        return intval($property);
    }
}
<?php

namespace MyTest\Services\Sanitizers;

abstract class FloatValuesSanitizer implements ISanitizer
{
    public static function sanitize($property)
    {
        $property = str_replace(',', '.', $property);
        $property = preg_replace('/[^0-9.]/', '', $property);

        return floatval($property);
    }
}
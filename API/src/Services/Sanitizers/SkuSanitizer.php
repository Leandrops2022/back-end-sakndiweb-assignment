<?php

namespace MyTest\Services\Sanitizers;

abstract class SkuSanitizer implements ISanitizer
{
    public static function sanitize($property)
    {
        return preg_replace('/[^a-zA-Z0-9.\-]/', '', $property);
    }
}
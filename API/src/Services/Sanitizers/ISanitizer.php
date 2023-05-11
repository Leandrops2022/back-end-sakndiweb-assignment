<?php

namespace MyTest\Services\Sanitizers;

interface ISanitizer
{
    public static function sanitize($property);
}
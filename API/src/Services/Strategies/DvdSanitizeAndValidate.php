<?php

namespace MyTest\Services\Strategies;

use MyTest\Services\Sanitizers\IntValuesSanitizer;
use MyTest\Services\Validators\SizeValidator;

class DvdSanitizeAndValidate implements ISanitizeAndValidate
{
    public function execute($obj): array
    {
        SizeValidator::validate($obj->size);
        $size = IntValuesSanitizer::sanitize($obj->size);
        $property['size'] = $size;

        return $property;
    }
}
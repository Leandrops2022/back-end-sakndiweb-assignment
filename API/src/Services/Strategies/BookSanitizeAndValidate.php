<?php

namespace MyTest\Services\Strategies;

use MyTest\Services\Sanitizers\FloatValuesSanitizer;
use MyTest\Services\Validators\WeightValidator;

class BookSanitizeAndValidate implements ISanitizeAndValidate
{
    public function execute($obj): array
    {
        WeightValidator::validate($obj->weight);
        $weight = FloatValuesSanitizer::sanitize($obj->weight);
        $property['weight'] = $weight;

        return $property;
    }
}
<?php

namespace MyTest\Services\Strategies;

use MyTest\Services\Sanitizers\FloatValuesSanitizer;
use MyTest\Services\Validators\DimensionsValidator;

class FurnitureSanitizeAndValidate implements ISanitizeAndValidate
{
    public function execute($obj): array
    {
        $dimensions = array(
            'height' => $obj->height,
            'width' => $obj->width,
            'length' => $obj->length
        );

        foreach ($dimensions as $key=>$value){
            DimensionsValidator::validate($value);
            $dimensions[$key] = FloatValuesSanitizer::sanitize($value);
        }

        return $dimensions;
    }
}
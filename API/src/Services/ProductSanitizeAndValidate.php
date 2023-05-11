<?php

namespace MyTest\Services;

use InvalidArgumentException;
use MyTest\Services\Sanitizers\FloatValuesSanitizer;
use MyTest\Services\Sanitizers\NameSanitizer;
use MyTest\Services\Sanitizers\SkuSanitizer;
use MyTest\Services\Strategies\ISanitizeAndValidate;
use MyTest\Services\Validators\{SkuValidator, NameValidator, PriceValidator};

class ProductSanitizeAndValidate
{
    private array $validationStrategies =[];

    public function registerValidationStrategy(
        string $productType,
        ISanitizeAndValidate $strategy
    ) {
        $this->validationStrategies[$productType] = $strategy;
    }

    public function SanitizeAndValidateProperties($obj): array
    {
        if (!isset($this->validationStrategies[$obj->productType])) {
            throw new InvalidArgumentException(
                "Invalid productType: $obj->productType"
            );
        }

        SkuValidator::validate($obj->sku);
        $sku = SkuSanitizer::sanitize($obj->sku);

        NameValidator::validate($obj->name);
        $name = NameSanitizer::sanitize($obj->name);

        PriceValidator::validate($obj->price);
        $price = FloatValuesSanitizer::sanitize($obj->price);

        $commonProperties = array(
            'productType' => $obj->productType,
            'sku' => $sku,
            'name' => $name,
            'price' => $price
        );
        $productProperties = $this->validationStrategies[$obj->productType]
            ->execute($obj);

        return array_merge($commonProperties, $productProperties);
    }
}
<?php

namespace MyTest\Services\Strategies;

interface ISanitizeAndValidate
{
    public function execute($obj): array;
}
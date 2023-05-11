<?php

require_once 'autoload.php';

use MyTest\Controllers\ProductController;
use MyTest\Factories\ProductFactory;
use MyTest\Factories\Strategies\BookFactory;
use MyTest\Factories\Strategies\DvdFactory;
use MyTest\Factories\Strategies\FurnitureFactory;
use MyTest\Repositories\ProductRepository;
use MyTest\Services\ProductSanitizeAndValidate;
use MyTest\Services\Strategies\BookSanitizeAndValidate;
use MyTest\Services\Strategies\DvdSanitizeAndValidate;
use MyTest\Services\Strategies\FurnitureSanitizeAndValidate;

$connectionString = parse_ini_file(
    '/home/u255404056/domains/dominionlps.com/iniFiles/dbConnection.ini'
);

$connection = new PDO(
    $connectionString['dsn'],
    $connectionString['username'],
    $connectionString['password']
);
$factory = new ProductFactory();
$factory->registerFactory('book', new BookFactory());
$factory->registerFactory('dvd', new DvdFactory());
$factory->registerFactory('furniture', new FurnitureFactory());

$productRepo = new ProductRepository($connection);

$sanitizerAndValidator = new ProductSanitizeAndValidate();

$sanitizerAndValidator->registerValidationStrategy(
    'book',
    new BookSanitizeAndValidate()
);

$sanitizerAndValidator->registerValidationStrategy(
    'dvd',
    new DvdSanitizeAndValidate()
);

$sanitizerAndValidator->registerValidationStrategy(
    'furniture',
    new FurnitureSanitizeAndValidate()
);


$controller = new ProductController(
    $_SERVER,
    $factory,
    $productRepo,
    $sanitizerAndValidator
);

$controller->sendResponse();
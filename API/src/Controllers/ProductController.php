<?php 

namespace MyTest\Controllers;

use PDO;
use Exception;
use InvalidArgumentException;

use MyTest\Factories\ProductFactory;
use MyTest\Repositories\ProductRepository;
use MyTest\Services\ProductSanitizeAndValidate;

class ProductController
{
    private $server;
    private $factory;
    private ProductSanitizeAndValidate $sanitizeAndValidate;
    private ProductRepository $productRepository;

    public function __construct(
        $server,
        $factory,
        $productRepository,
        $sanitizeAndValidate
    ) {
        $this->server = $server;
        $this->factory = $factory;
        $this->productRepository = $productRepository;
        $this->sanitizeAndValidate = $sanitizeAndValidate;
    }

    public function getProductRepository(): ProductRepository
    {
        return $this->productRepository;
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function sendResponse()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Max-Age: 86400');

        try {
            $requestType = $this->getServer()['REQUEST_METHOD'];
            $productMaker = $this->getFactory();
            $requestBody = file_get_contents('php://input');
            $userInputObj = json_decode($requestBody);
            switch ($requestType) {
                case 'OPTIONS':
                    header("Access-Control-Allow-Origin: *");
                    header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
                    header("Access-Control-Allow-Headers: Content-Type");
                    exit();
                    break;
                case 'POST':
                    if ($userInputObj === null) {
                        header("HTTP/1.1 400 Bad Request");
                        throw new InvalidArgumentException(
                            'No data was received'
                        );
                    } else {
                        $sanitizedInput = $this->sanitizeAndValidate
                            ->SanitizeAndValidateProperties($userInputObj);

                        $product = $productMaker->create(
                            $sanitizedInput['productType'],
                            $sanitizedInput
                        );

                        $saveResult = $this->productRepository->save($product);

                        header("HTTP/1.1 201 Created");
                        print_r($saveResult);
                    }
                    break;
                case 'GET':
                    $this->productRepository->getProducts();
                    break;
                case 'DELETE':
                    if ($userInputObj === null) {
                        header("HTTP/1.1 400 Bad Request");
                        throw new InvalidArgumentException(
                            'No data was received'
                        );
                    } else {
                        $this->productRepository->deleteEntries($userInputObj);
                        header("HTTP/1.1 200 Ok");
                    }
                    break;
                default:
                    header("HTTP/1.1 400 Bad Request");
                    echo 'Bad request';
                    break;
            }
        } catch (InvalidArgumentException | Exception $e) {
            echo $e->getMessage();
        }
    }
}
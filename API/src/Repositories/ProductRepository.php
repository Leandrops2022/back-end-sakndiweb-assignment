<?php

namespace MyTest\Repositories;

use InvalidArgumentException;

use PDO;

class ProductRepository
{
    private PDO $pdo;
    private $bookCollection;
    private $dvdCollection;
    private $furnitureCollection;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getBookCollection()
    {
        return $this->bookCollection;
    }

    public function setBookCollection($books): void
    {
        $this->bookCollection = $books;
    }

    public function getDvdCollection()
    {
        return $this->dvdCollection;
    }

    public function setDvdCollection($dvds): void
    {
        $this->dvdCollection = $dvds;
    }

    public function getFurnitureCollection()
    {
        return $this->furnitureCollection;
    }

    public function setFurnitureCollection($furniture): void
    {
        $this->furnitureCollection = $furniture;
    }

    public function verifyExistingSku(string $productType, string $sku)
    {
        $tables = ['books', 'dvds', 'furniture'];
        foreach ($tables as $table){
            $stmt = $this->pdo->prepare(
                "SELECT sku FROM $table WHERE sku = :sku"
            );
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
            $existingSku = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingSku) {
                header('HTTP/1.1 409 sku Conflict');

                throw new InvalidArgumentException(
                    "Error! SKU already registered to another product!"
                );
            }
        }
    }

    public function saveToDbAndReturnResult($obj)
    {
        $table = $obj->getProductType() == 'book'
            || $obj->getProductType() == 'dvd'
            ? $obj->getProductType().'s'
            : $obj->getProductType();

        $objValues = array_values($obj->getProductInfo());
        $objValues = array_map(
            function ($value)
            {
                return "'" . $value . "'";
            },
            $objValues
        );

        $objKeys = implode(', ', array_keys($obj->getProductInfo()));
        $values = implode(', ', $objValues);

        $query = "INSERT INTO $table ($objKeys)
            VALUES ($values)";
        $stmt = $this->getPdo()->prepare($query);

        $stmt->execute();

        $lastId = $this->getPdo()->lastInsertId();
        $stmt = $this->getPdo()->prepare("SELECT * FROM $table where id = ?");
        $stmt->execute([$lastId]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function save($obj)
    {
        $this->verifyExistingSku($obj->getProductType(), $obj->getSku());
        $this->saveToDbAndReturnResult($obj);
    }

    function compareById($objA, $objB)
    {
        return $objA->id - $objB->id;
    }

    public function getProducts()
    {
        $tables = ['books', 'dvds', 'furniture'];
        foreach ($tables as $table){
            $query = "SELECT * FROM $table";
            $stmt = $this->getPdo()->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            if ($table == 'books') {
                $this->setBookCollection($results);
            } elseif ($table == 'dvds') {
                $this->setDvdCollection($results);
            } else {
                $this->setFurnitureCollection($results);
            }
        }

        $allProducts = array_merge(
            $this->getDvdCollection(),
            $this->getFurnitureCollection(),
            $this->getBookCollection()
        );

        usort($allProducts, array($this, 'compareById'));
        header('HTTP/1.1 200');
        print_r(json_encode($allProducts));
        exit();
}


    public function deleteEntries($obj) {
        $idsByProductType = [
            'book'=>array(),
            'dvd'=>array(),
            'furniture'=>array()
        ];

        $tables = ['books', 'dvds', 'furniture'];

        foreach ($obj as $product){
            if (array_key_exists($product->productType, $idsByProductType)) {
                $id = preg_replace('/[^0-9]/','', $product->id);
                $idsByProductType[$product->productType][] = intval($id);
            } else {
                throw new InvalidArgumentException('Invalid data was sent to the server!');
            }
        }

        foreach ($tables as $table) {
            $values = $table == 'furniture'
                ? array_values($idsByProductType[$table])
                : array_values($idsByProductType[substr($table, 0, strlen($table)-1)]);

            if($values){
                $values = implode(', ', $values);

                $query = "DELETE FROM $table WHERE id IN ($values)";
                $stmt = $this->getPdo()->prepare($query);
                $stmt->execute();
            }
        }
        $this->getProducts();
    }
}
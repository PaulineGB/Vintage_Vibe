<?php

namespace App\Model;

class ProductManager extends AbstractManager
{
    public const TABLE = 'product';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $product
     * @return int
     */
    public function insert(array $product): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " SET (`title`, `artist`, `category_id`, `size_id`, `description`, `picture`, `price`, `quantity`)
        VALUES (:title, :artist, :category_id, :size_id, :description, :picture, :price, :quantity)");
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('artist', $product['artist'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $product['category_id'], \PDO::PARAM_INT);
        $statement->bindValue('size_id', $product['size_id'], \PDO::PARAM_INT);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $product['picture'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('quantity', $product['quantity'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $product
     * @return bool
     */
    public function update(array $product): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " (`title`, `artist`, `category_id`, `size_id`, `description`, `picture`, `price`, `quantity`) 
        VALUES (:title, :artist, :category_id, :size_id, :description, :picture, :price, :quantity)");
        $statement->bindValue('id', $product['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('artist', $product['artist'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $product['category_id'], \PDO::PARAM_INT);
        $statement->bindValue('size_id', $product['size_id'], \PDO::PARAM_INT);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $product['picture'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('quantity', $product['quantity'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}

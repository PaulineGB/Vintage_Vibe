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
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT
        title, artist, description, picture, price, quantity,
        category_id, category.name AS category_name,
        size_id, size.name AS size_name
        FROM product, category, size
        WHERE category.id = product.category_id AND size.id = product.size_id
        ')->fetchAll();
    }

    /**
     * @param array $product
     * @return int
     */
    public function insert(array $product): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (`title`, `artist`, `category_id`, `size_id`, `description`, `picture`, `price`, `quantity`)
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
        " SET `title` = :title, `artist` = :artist, `category_id` = :category_id, `size_id` = :size_id,
        `description` = :description, `picture` = :picture, `price` = :price, `quantity` = :quantity
        WHERE id=:id");
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

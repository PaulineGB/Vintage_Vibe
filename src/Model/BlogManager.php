<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class BlogManager extends AbstractManager
{
    public const TABLE = 'blog';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $blog
     * @return int
     */
    public function insert(array $blog): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (`title`, `description`, `picture`) 
        VALUES (:title, :description, :picture)");
        $statement->bindValue('title', $blog['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $blog['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $blog['picture'], \PDO::PARAM_STR);

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
     * @param array $blog
     * @return bool
     */
    public function update(array $blog): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " SET `title` = :title, `description` = :description, `title` = :title, `picture` = :picture WHERE id=:id");
        $statement->bindValue('id', $blog['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $blog['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $blog['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $blog['picture'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}

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
class ContactManager extends AbstractManager
{
    public const TABLE = 'contact';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     *
     * @param array $contact
     * @return int
     */
    public function insert(array $contact): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`firstname`,`lastname`, `email`, `message`)
         VALUES (:firstname, :lastname, :email, :message)");
        $statement->bindValue('firstname', $contact['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $contact['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $contact['email'], \PDO::PARAM_STR);
        $statement->bindValue('message', $contact['message'], \PDO::PARAM_STR);

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
     * @param array $contact
     * @return bool
     */
    public function update(array $contact): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `email` = :email WHERE id=:id");
        $statement->bindValue('id', $contact['id'], \PDO::PARAM_INT);
        $statement->bindValue('email', $contact['email'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}

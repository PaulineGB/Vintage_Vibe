<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

use PDO;

/**
 *
 */
class InvoiceManager extends AbstractManager
{
    public const TABLE = 'order';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT
        o.id, o.user_id, o.created_at, o.total,
        u.firstname AS u_firstname, u.lastname AS u_lastname, u.address AS u_address
        FROM `order` AS o
        JOIN user AS u ON u.id = o.user_id
        ')->fetchAll();
    }

    public function insertOrder(array $order): int
    {
        $statement = $this->pdo->prepare("INSERT INTO `order` (user_id, created_at, total)
        VALUES (:user_id, :created_at, :total)");
        $statement->bindValue('user_id', $order['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $order['created_at'], \PDO::PARAM_STR);
        $statement->bindValue('total', $order['total'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function getInvoiceByUser(int $idUser)
    {
        $statement = $this->pdo->prepare("SELECT
        o.id, o.user_id, o.created_at, o.total,
        u.firstname AS u_firstname, u.lastname AS u_lastname, u.address AS u_address
        FROM `order` AS o
        JOIN user AS u ON u.id = o.user_id
        WHERE o.user_id = :user_id");
        $statement->bindValue('user_id', $idUser, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }
}

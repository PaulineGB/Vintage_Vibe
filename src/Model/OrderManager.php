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
class OrderManager extends AbstractManager
{
    public const TABLE = 'order_product';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare('SELECT
        op.id, op.order_id, op.product_id, op.quantity,
        o.user_id AS o_user_id, o.created_at AS o_created_at, o.total AS o_total,
        p.picture AS p_picture, p.title AS p_title, p.price AS p_price, p.quantity AS p_quantity
        FROM order_product AS op
        JOIN `order`AS o ON o.id = op.order_id
        JOIN product AS p ON p.id = op.product_id
        WHERE o.user_id = :id');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function selectOneOrder(int $idInvoice)
    {
        $statement = $this->pdo->prepare("SELECT
        op.id, op.order_id, op.product_id, op.quantity,
        o.user_id AS o_user_id, o.created_at AS o_created_at, o.total AS o_total,
        p.picture AS p_picture, p.title AS p_title, p.price AS p_price
        FROM `order_product` AS op
        JOIN `order`AS o ON o.id = op.order_id
        JOIN product AS p ON p.id = op.product_id
        WHERE op.order_id= :order_id");
        $statement->bindValue('order_id', $idInvoice, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $order)
    {
        $statement = $this->pdo->prepare("INSERT INTO `order_product` (order_id, product_id, quantity)
        VALUES (:order_id, :product_id, :quantity)");
        $statement->bindValue('order_id', $order['order_id'], PDO::PARAM_INT);
        $statement->bindValue('product_id', $order['product_id'], PDO::PARAM_INT);
        $statement->bindValue('quantity', $order['quantity'], PDO::PARAM_INT);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }
}

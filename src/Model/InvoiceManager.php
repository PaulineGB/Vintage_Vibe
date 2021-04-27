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


    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare('SELECT
        o.id, o.user_id, o.created_at, o.total,
        order_product.quantity AS op_quantity,
        u.firstname AS user_firstname, u.lastname AS user_lastname, u.email AS user_email, u.address AS user_address,
        p.picture AS p_picture, p.title AS p_title, p.price AS p_price, p.quantity AS p_quantity
        FROM `order` AS o
        JOIN order_product ON o.id = order_product.order_id
        JOIN `user` AS u ON o.user_id = u.id
        JOIN product AS p ON p.id = o.product_id
        WHERE o.user_id=:id');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}

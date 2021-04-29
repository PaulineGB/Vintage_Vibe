<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\WishlistManager;
use App\Model\ProductManager;

class WishlistController extends AbstractController
{
    /**
     * Display wishlist page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();
        return $this->twig->render('Home/index.html.twig', [
            'products' => $products
        ]);
    }

    public function like(int $idProduct)
    {
        $wishManager = new WishlistManager();
        //$isLiked = $wishManager->isLikedByUser($idProduct, $_SESSION['user']['id']);
        //var_dump($isLiked); die;
        //if(!$isLiked) {
            $wish = [
            'user_id' => $_SESSION['user']['id'],
            'product_id' => $idProduct
            ];
            $wishManager->insert($wish);
        //}
            header('Location: /home/shop');
    }

    public function dislike(int $idWish)
    {
        $wishManager = new WishlistManager();
        $wishManager->delete($idWish);
        header('Location: /user/account');
    }
}

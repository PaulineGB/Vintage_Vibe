<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\WishlistManager;

class WishlistController extends AbstractController
{
    public function like(int $idProduct)
    {
        if (isset($_SESSION['user'])) {
            $wishManager = new WishlistManager();
            $isLiked = $wishManager->isLikedByUser($idProduct, $_SESSION['user']['id']);
            if (!$isLiked) {
                $wish = [
                'user_id' => $_SESSION['user']['id'],
                'product_id' => $idProduct
                ];
                $wishManager->insert($wish);
                header('Location: /home/userAccount');
            } else {
                return $this->twig->render('Home/alreadylike.html.twig');
            }
        } else {
            header('Location: /security/login');
        }
    }

    public function dislike(int $idWish)
    {
        $wishManager = new WishlistManager();
        $wishManager->delete($idWish);
        header('Location: /home/userAccount');
    }
}

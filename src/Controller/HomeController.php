<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
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
            'products' => $products,
        ]);
    }


    public function userAccount()
    {
        $id = $_SESSION['user']['id'];

        if (isset($_SESSION['user']['id'])) {
            $userManager = new UserManager();
            $user = $userManager->selectOneById($id);
            return $this->twig->render('Home/account.html.twig', ['user' => $user]);
        } else {
            header('Location: /');
        }
    }
}

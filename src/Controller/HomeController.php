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
            return $this->twig->render('Account/account.html.twig', ['user' => $user]);
        } else {
            header('Location: /');
        }
    }

    public function editAccount(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();

            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                return $donnees;
            };

            if (strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 40) {
                    $user['firstname'] = $securityForm($_POST['firstname']);
                    $user['lastname'] = $securityForm($_POST['lastname']);
                    $user['email'] = filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL);
                    $user['address'] = $securityForm($_POST['address']);
                    $user['password'] = $securityForm(md5($_POST['password']));
            } else {
                $errors[] = "Password must contain between 6 and 12 characters";
            }

            $userManager->update($user);
            header('Location:/home/userAccount');
        }

        return $this->twig->render('Account/edit.html.twig', [
            'user' => $user,
            'errors' => $errors
        ]);
    }
}

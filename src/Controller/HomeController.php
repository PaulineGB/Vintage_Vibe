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
use App\Model\InvoiceManager;
use App\Model\OrderManager;

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

            $invoiceManager = new InvoiceManager();
            $order = $invoiceManager->selectOneById($id);

            return $this->twig->render('Account/account.html.twig', [
                'user' => $user,
                'order' => $order
                ]);
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
            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                return $donnees;
            };

            if (
                !empty($_POST['firstname']) && !empty($_POST['lastname'])
                && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_POST['check_password'])
            ) {
                if (strlen($_POST['check_password']) >= 6 && strlen($_POST['check_password']) <= 12) {
                    if ($user['password'] === md5($_POST['check_password'])) {
                            $user['firstname'] = $securityForm($_POST['firstname']);
                            $user['lastname'] = $securityForm($_POST['lastname']);
                            $user['email'] = filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL);
                            $user['address'] = $securityForm($_POST['address']);

                            $userManager->update($user);
                            header('Location:/home/userAccount');
                    } else {
                        $errors[] = "Invalid password";
                    }
                } else {
                    $errors[] = "Password must contain between 6 and 12 characters";
                }
            } else {
                $errors[] = "All fields are required";
            }
        }

        return $this->twig->render('Account/edit.html.twig', [
            'user' => $user,
            'errors' => $errors
        ]);
    }
}

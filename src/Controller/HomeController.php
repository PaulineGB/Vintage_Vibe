<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\NewsletterManager;
use App\Model\BlogManager;
use App\Model\ProductManager;
use App\Model\UserManager;
use App\Model\SizeManager;
use App\Model\CategoryManager;
use App\Model\InvoiceManager;
use App\Model\WishlistManager;
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
            'products' => $products
        ]);
    }

    // SHOP all & detail
    public function shop()
    {
        $productManager = new ProductManager();
        $sizeManager = new SizeManager();
        $size = $sizeManager->selectAll();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectAll();

        if (isset($_GET['sizename']) && !empty($_GET['sizename'])) {
            $products = $productManager->filtersize($_GET['sizename']);
            return $this->twig->render('Home/shop.html.twig', [
                'products' => $products,
                'size' => $size,
                'category' => $category
                ]);
        }

        if (isset($_GET['categoryname']) && !empty($_GET['categoryname'])) {
            $products = $productManager->filtercategory($_GET['categoryname']);
            return $this->twig->render('Home/shop.html.twig', [
                'products' => $products,
                'size' => $size,
                'category' => $category
                ]);
        }

        $products = $productManager->selectAll();
        return $this->twig->render('Home/shop.html.twig', [
            'products' => $products,
            'size' => $size,
            'category' => $category
        ]);
    }

    public function showproduct(int $id)
    {
        $productManager = new ProductManager();

        $product = $productManager->selectOneById($id);
        return $this->twig->render('Home/showproduct.html.twig', ['product' => $product]);
    }

    // User Account
    public function userAccount()
    {
        $id = $_SESSION['user']['id'];

        if (isset($_SESSION['user']['id']) && !empty($_SESSION['user'])) {
            $userManager = new UserManager();
            $user = $userManager->selectOneById($id);

            $invoiceManager = new InvoiceManager();
            $invoice = $invoiceManager->getInvoiceByUser($id);

            $wishManager = new WishlistManager();
            $productManager = new ProductManager();

            $wishlist = $wishManager->getWishlistByUser($_SESSION['user']['id']);
            $result = [];
            foreach ($wishlist as $wish) {
                $product = $productManager->selectOneById($wish['product_id']);
                $result[] = ["wish_id" => $wish['id'], "product" => $product];
            }

            return $this->twig->render('Account/account.html.twig', [
                'user' => $user,
                'invoices' => $invoice,
                'wishlist' => $result
                ]);
        } else {
            header('Location: /');
        }
    }

    public function showInvoice(int $idInvoice)
    {
        if (!isset($_SESSION['user']['id']) && !empty($_SESSION['user'])) {
            header('Location: /');
        }
            $orderManager = new OrderManager();
            $userManager = new UserManager();

            $order = $orderManager->selectOneOrder($idInvoice);

            $result = [];
        foreach ($order as $detail) {
            $user = $userManager->selectOneById($detail['o_user_id']);
            $detail['o_user_id'] = $user;

            $result[] = $detail;
        }
            return $this->twig->render('Account/detail.html.twig', [
                'order' => $order,
                'user' => $result,
                'idInvoice' => $idInvoice,
            ]);
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

    // Blog
    public function blog()
    {
        $blogManager = new BlogManager();
        $blogs = $blogManager->selectAll();
        return $this->twig->render('Home/blog.html.twig', [
            'blogs' => array_reverse($blogs)
        ]);
    }


    // FAQ & Terms pages
    public function terms()
    {
        return $this->twig->render('Home/terms.html.twig');
    }

    public function faq()
    {
        return $this->twig->render('Home/faq.html.twig');
    }


    // Newsletter
    public function newsletter()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsletter = array_map('trim', $_POST);

            if (empty($newsletter['email'])) {
                $errors[] = 'Indiquez votre adresse e-mail s\'il vous plait';
            }
            $newsletterContact = filter_var($newsletter['email'], FILTER_VALIDATE_EMAIL);
            if ($newsletterContact === false) {
                $errors[] = 'Veuillez renseigner une adresse mail valide!';
            }

            if (empty($errors)) {
                $newsletterManager = new NewsletterManager();
                $newsletter = [
                    'email' => $_POST['email'],
                ];
                $newsletterManager->insert($newsletter);
                header('Location:/');

                $sentence = 'Merci de vous etre inscrit à notre Newsletter avec cette adresse e-mail: '
                    . $newsletter['email'] . ', nous vous contactons bientôt.';
                return $this->twig->render('Home/index.html.twig', [
                    'sentence' => $sentence
                ]);
            }
        }
        return $this->twig->render('Home/index.html.twig', [
            'errors' => $errors
        ]);
    }

    public function team()
    {
        return $this->twig->render('Home/team.html.twig');
    }
}

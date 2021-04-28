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
use App\Model\SizeManager;
use App\Model\CategoryManager;

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

    public function blog()
    {
        $blogManager = new BlogManager();
        $blogs = $blogManager->selectAll();
        return $this->twig->render('Home/blog.html.twig', [
            'blogs' => array_reverse($blogs)
        ]);
    }

    public function showproduct(int $id)
    {
        $productManager = new ProductManager();

        $product = $productManager->selectOneById($id);
        return $this->twig->render('Home/showproduct.html.twig', ['product' => $product]);
    }

    public function newsLetter()
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

                $sentence = 'Merci de vous etre inscrit à notre Newsletter avec cette adresse e-mail: '
                    . $newsletter['email'] . ', nous vous contactons bientôt.';
                $newsletterManager->insert($newsletter);
                return $this->twig->render('Home/newsLetter.html.twig', [
                    'sentence' => $sentence
                ]);
            }
        }
        return $this->twig->render('Home/newsLetter.html.twig', [
            'errors' => $errors
        ]);
    }

    public function contactNewsLetter()
    {
        $newsLetterManager = new NewsLetterManager();
        $newsLetters = $newsLetterManager->selectAll();

        return $this->twig->render('Newsletter/index.html.twig', ['newsLetters' => $newsLetters]);
    }
}

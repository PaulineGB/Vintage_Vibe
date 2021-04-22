<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\NewsletterManager;
use App\Model\ProductManager;

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

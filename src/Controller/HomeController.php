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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsletterManager = new NewsletterManager();
            $newsletter = [
                'email' => $_POST['email'],
            ];
            $newsletterManager->insert($newsletter);
            header('Location: /home/newsLetter');
        }
        return $this->twig->render('Home/newsLetter.html.twig');
    }

      /**
     * Display item informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function contactNewsLetter(int $id)
    {
        $newsLetterManager = new NewsLetterManager();
        $newsLetters = $newsLetterManager->selectOneById($id);

        return $this->twig->render('Home/contactNewsLetter.html.twig', ['newsLetters' => $newsLetters]);
    }
}

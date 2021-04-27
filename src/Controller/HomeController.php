<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\BlogManager;
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

    public function blog()
    {
        $blogManager = new BlogManager();
        $blogs = $blogManager->selectAll();
        return $this->twig->render('Home/blog.html.twig', [
            'blogs' => array_reverse($blogs)
        ]);
    }
}

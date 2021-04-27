<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

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
}

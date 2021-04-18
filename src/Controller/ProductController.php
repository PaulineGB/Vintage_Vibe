<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\CategoryManager;
use App\Model\SizeManager;

class ProductController extends AbstractController
{
    // page ADMIN all products
    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $productManager = new ProductManager();
        $categoryManager = new CategoryManager();
        $sizeManager = new SizeManager();
        $products = $productManager->selectAll();
        $categories = $categoryManager->selectAll();
        $sizes = $sizeManager->selectAll();

        return $this->twig->render('Product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    // page ADMIN add products
    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $categoryManager = new CategoryManager();
        $sizeManager = new SizeManager();

        $categories = $categoryManager->selectAll();
        $sizes = $sizeManager->selectAll();

        $product = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();

            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                $donnees = htmlspecialchars($donnees);
                return $donnees;
            };

            $product = [
                'title' => $securityForm($_POST['title']),
                'artist' => $securityForm($_POST['artist']),
                'category_id' => $_POST['category_id'],
                'size_id' => $_POST['size_id'],
                'description' => $securityForm($_POST['description']),
                'picture' => $securityForm($_POST['picture']),
                'price' => $securityForm($_POST['price']),
                'quantity' => $securityForm($_POST['quantity'])
            ];

            $productManager->insert($product);
            header('Location:/product/index');
        }
        return $this->twig->render('Product/add.html.twig', [
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    // page ADMIN edit products
    /**
     * Display item edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $productManager = new ProductManager();
        $categoryManager = new CategoryManager();
        $sizeManager = new SizeManager();

        $product = $productManager->selectOneById($id);
        $categories = $categoryManager->selectAll();
        $sizes = $sizeManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                $donnees = htmlspecialchars($donnees);
                return $donnees;
            };

            $product['title'] = $securityForm($_POST['title']);
            $product['artist'] = $securityForm($_POST['artist']);
            $product['category_id'] = $_POST['category_id'];
            $product['size_id'] = $_POST['size_id'];
            $product['description'] = $securityForm($_POST['description']);
            $product['picture'] = $securityForm($_POST['picture']);
            $product['price'] = $securityForm($_POST['price']);
            $product['quantity'] = $securityForm($_POST['quantity']);
            $productManager->update($product);
            header('Location:/product/index');
        }

        return $this->twig->render('Product/edit.html.twig', [
            'product' => $product,
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    // page ADMIN delete products

    /**
     * Handle item deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location:/product/index');
    }

    /**
     * Display user informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        return $this->twig->render('Product/show.html.twig', ['product' => $product]);
    }
}

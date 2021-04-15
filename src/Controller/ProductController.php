<?php

namespace App\Controller;

use App\Model\ProductManager;

// use App\Model\CategoryManager;
// use App\Model\SizeManager;

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
        $products = $productManager->selectAll();

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            $product = [
                'title' => $_POST['title'],
                'artist' => $_POST['artist'],
                'category_id' => $_POST['category_id'],
                'size_id' => $_POST['size_id'],
                'description' => $_POST['description'],
                'picture' => $_POST['picture'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity']
            ];
            $productManager->insert($product);
            header('Location:/product/index');
        }
            return $this->twig->render('Product/add.html.twig');
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
        $product = $productManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product['title'] = $_POST['title'];
            $product['artist'] = $_POST['artist'];
            $product['category_id'] = $_POST['category_id'];
            $product['size_id'] = $_POST['size_id'];
            $product['description'] = $_POST['description'];
            $product['picture'] = $_POST['picture'];
            $product['price'] = $_POST['price'];
            $product['quantity'] = $_POST['quantity'];
            $productManager->update($product);
        }

        return $this->twig->render('Product/edit.html.twig', ['product' => $product]);
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
}

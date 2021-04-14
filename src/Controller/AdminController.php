<?php

namespace App\Controller;

use App\Model\ProductManager;

class AdminController extends AbstractController
{
    // page ADMIN products
    public function products()
    {
        $productManager = new ProductManager();
        // $categoryManager = new CategoryManager();
        // $sizeManager = new SizeManager();

        $products = $productManager->selectAll();
        // $categories = $categoryManager->selectAll();
        // $sizes = $sizeManager->selectAll();

        return $this->twig->render('Admin/products.html.twig', [
            'products' => $products,
            // 'categories' => $categories,
        ]);
    }

    // page ADMIN add products
    public function add()
    {
        // $categoryManager = new CategoryManager();

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
            header('Location:/Admin/products');
        }
            return $this->twig->render('/Admin/Products/add.html.twig', [
                // 'categories' => $categoryManager->selectAll(),
            ]);
    }
}

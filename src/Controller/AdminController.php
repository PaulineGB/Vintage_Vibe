<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\CategoryManager;

class AdminController extends AbstractController
{
    // page ADMIN products
    public function products()
    {
        $productManager = new ProductManager();
        $categoryManager = new CategoryManager();
        // $sizeManager = new SizeManager();

        $products = $productManager->selectAll();
        $categories = $categoryManager->selectAll();
        // $sizes = $sizeManager->selectAll();

        return $this->twig->render('Admin/products.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    // page ADMIN add products
    public function add()
    {
        $categoryManager = new CategoryManager();
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
            header('Location:/admin/products');
        }
            return $this->twig->render('Admin/Products/add.html.twig', [
            'categories' => $categoryManager->selectAll(),
            ]);
    }

    // page ADMIN edit products
    public function edit(int $id): string
    {
        // $categoryManager = new CategoryManager();
        // $sizeManager = new SizeManager();
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

        return $this->twig->render('Admin/Products/edit.html.twig', ['product' => $product]);
        // 'categories' => $categoryManager->selectAll(),
        // 'size' => $sizeManager->selectAll(),
    }

    // page ADMIN delete products
    public function delete(int $id)
    {
        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location:/admin/products');
    }
}

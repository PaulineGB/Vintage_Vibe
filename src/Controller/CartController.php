<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ProductManager;

class CartController extends AbstractController
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
        return $this->twig->render('Cart/index.html.twig', [
            'products' => $products
        ]);
    }

    public function cart()
    {
        return $this->twig->render('Cart/cart.html.twig', [
            'cart' => $this->cartInfos(),
            'totalCart' => $this->getTotalCart()
            ]);
    }

    public function addToCart(int $idProduct)
    {
        if (!empty($_SESSION['cart'][$idProduct])) {
            $_SESSION['cart'][$idProduct]++;
        } else {
            $_SESSION['cart'][$idProduct] = 1;
        }
        header('Location: /cart/cart');
    }

    public function deleteFromCart(int $idProduct)
    {
        $cart = $_SESSION['cart'];
        if (!empty($cart[$idProduct])) {
            unset($cart[$idProduct]);
        }
        $_SESSION['cart'] = $cart;
        header('Location: /cart/cart');
    }

    public function cartInfos()
    {
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $cartInfos = [];
            $productManager = new ProductManager();
            foreach ($cart as $id => $quantity) {
                $product = $productManager->selectOneById($id);
                $product['quantity'] = $quantity;
                $cartInfos[] = $product;
            }
            return $cartInfos;
        }
        return false;
    }

    public function getTotalCart()
    {
        $total = 0;
        if ($this->cartInfos() != false) {
            foreach ($this->cartInfos() as $product) {
                $total += $product['price'] * $product['quantity'];
            }
        }
        return $total;
    }
}

<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\UserManager;
use App\Model\InvoiceManager;
use App\Model\OrderManager;
use App\Model\WishlistManager;

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


    public function cart()
    {
        $userManager = new UserManager();
        $errors = [];

        if (!isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                if (!empty($_POST['email']) && !empty($_POST['password'])) {
                    $user = $userManager->searchUser($_POST['email']);
                    if ($user) {
                        if ($user['password'] === md5($_POST['password'])) {
                            $_SESSION['user'] = $user;
                            header('Location: /cart/cart');
                        } else {
                            $errors[] = "Invalid password";
                        }
                    } else {
                        $errors[] = "This email does not exist";
                    }
                } else {
                    $errors[] = "All fields are required";
                }
            }
        }

        return $this->twig->render('Cart/cart.html.twig', [
            'cart' => $this->cartInfos(),
            'totalCart' => $this->getTotalCart(),
            'errors' => $errors
        ]);
    }

    public function addToCart(int $idProduct)
    {
        $wishlistManager = new WishlistManager();

        if (!empty($_SESSION['cart'][$idProduct])) {
            $_SESSION['cart'][$idProduct]++;
        } else {
            $_SESSION['cart'][$idProduct] = 1;
        }

        if (isset($_SESSION['user'])) {
            $userwishlist = $wishlistManager->getWishlistByUser($_SESSION['user']['id']);
            $result = [];
            foreach ($userwishlist as $wish) {
                $result[] = ["wish_id" => $wish['id']];

                if ($wish['product_id'] == $idProduct) {
                    $wishlistManager->delete($wish['id']);
                }
            }
        }

        $_SESSION['count'] = $this->countArticle();
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

    //Order
    public function order()
    {
        $invoiceManager = new InvoiceManager();
        $orderManager = new OrderManager();
        $productManager = new ProductManager();

        $order = [
            'created_at' => date('y-m-d'),
            'total' => $this->getTotalCart(),
            'user_id' => $_SESSION['user']['id'],
        ];

        $idOrder = $invoiceManager->insertOrder($order);

        if ($idOrder) {
            foreach ($_SESSION['cart'] as $idProduct => $quantity) {
                $product = $productManager->selectOneById($idProduct);
                $newQty = $product['quantity'] - $quantity;
                $productManager->updateQuantity($idProduct, $newQty);
                $invoiceTicket = [
                    'order_id' => $idOrder,
                    'product_id' => $idProduct,
                    'quantity' => $quantity,
                ];
                $orderManager->insert($invoiceTicket);
            }
            unset($_SESSION['cart']);
            header('Location: /cart/payment');
        }

        return $this->twig->render('Cart/order.html.twig', [
            'cart' => $this->cartInfos(),
            'totalCart' => $this->getTotalCart()
        ]);
    }

    public function success()
    {
        return $this->twig->render('Account/success.html.twig');
    }

    // Cart COUNT in navbar
    public function countArticle()
    {
        $total = 0;
        if ($this->cartInfos() != false) {
            foreach ($this->cartInfos() as $item) {
                $total += $item['quantity'];
            }
            return $total;
        }
        return $total;
    }

    public function payment()
    {
        return $this->twig->render('Cart/payment.html.twig');
    }
}

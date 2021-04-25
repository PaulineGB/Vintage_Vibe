<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\UserManager;

class AdminController extends AbstractController
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
        return $this->twig->render('Admin/index.html.twig');
    }

    public function adminLog()
    {
        $userManager = new UserManager();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $user = $userManager->searchUser($_POST['email']);
                if ($user) {
                    if ($user['password'] === md5($_POST['password'])) {
                        $_SESSION['user'] = $user;
                        header('Location: /Admin/index.html.twig');
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
        return $this->twig->render('Admin/adminlogin.html.twig', ['errors' => $errors]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}

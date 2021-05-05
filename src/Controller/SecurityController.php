<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\UserManager;

class SecurityController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function register()
    {
        $userManager = new UserManager();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (
                !empty($_POST['email']) && !empty($_POST['firstname'])
                && !empty($_POST['lastname']) && !empty($_POST['address'])
                && !empty($_POST['password']) && !empty($_POST['check_pass'])
            ) {
                $user = $userManager->searchUser($_POST['email']);
                if (!$user) {
                    if ($_POST['password'] === $_POST['check_pass']) {
                        if (strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 12) {
                            $_POST['is_admin'] = false;
                            $user = [
                                'email' => filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL),
                                'firstname' => trim($_POST['firstname']),
                                'lastname' => trim($_POST['lastname']),
                                'address' => trim($_POST['address']),
                                'password' => md5($_POST['password']),
                                'is_admin' => $_POST['is_admin']
                            ];
                            $id = $userManager->insert($user);
                            if ($id) {
                                $_SESSION['user'] = $userManager->selectOneById($id);
                                header('Location: /');
                            }
                        } else {
                            $errors[] = "Password must contain between 6 and 12 characters";
                        }
                    } else {
                        $errors[] = "Passwords do not match";
                    }
                } else {
                    $errors[] = "This email already exist";
                }
            } else {
                $errors[] = "All fields are required";
            }
        }
        return $this->twig->render('Security/register.html.twig', ['errors' => $errors]);
    }

    public function login()
    {
        $userManager = new UserManager();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $user = $userManager->searchUser($_POST['email']);
                if ($user) {
                    if ($user['password'] === md5($_POST['password'])) {
                        $_SESSION['user'] = $user;
                        if ($_SESSION['user']['is_admin']) {
                            header('Location: /Admin/index/');
                        } else {
                            header('Location: /home/userAccount');
                        }
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
        return $this->twig->render('Security/login.html.twig', ['errors' => $errors]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}

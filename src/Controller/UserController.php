<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\UserManager;
use App\Model\WishlistManager;
use App\Model\ProductManager;

/**
 * Class UserController
 *
 */
class UserController extends AbstractController
{
    /**
     * Display user listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
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
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }


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
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();

            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                return $donnees;
            };

            if (strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 40) {
                if (empty($_POST['is_admin'])) {
                    $_POST['is_admin'] = false;

                    $user['firstname'] = $securityForm($_POST['firstname']);
                    $user['lastname'] = $securityForm($_POST['lastname']);
                    $user['email'] = filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL);
                    $user['address'] = $securityForm($_POST['address']);
                    $user['password'] = $securityForm(md5($_POST['password']));
                    $user['is_admin'] = $_POST['is_admin'];
                } else {
                    $user['firstname'] = $securityForm($_POST['firstname']);
                    $user['lastname'] = $securityForm($_POST['lastname']);
                    $user['email'] = filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL);
                    $user['address'] = $securityForm($_POST['address']);
                    $user['password'] = $securityForm(md5($_POST['password']));
                    $user['is_admin'] = $_POST['is_admin'];
                }
            } else {
                $errors[] = "Password must contain between 6 and 12 characters";
            }

            $userManager->update($user);
            header('Location:/user/index');
        }

        return $this->twig->render('User/edit.html.twig', [
            'user' => $user,
            'errors' => $errors
        ]);
    }


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
        $userManager = new UserManager();
        $errors = [];
        $user = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                return $donnees;
            };

            if (strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 12) {
                if (empty($_POST['is_admin'])) {
                    $_POST['is_admin'] = false;
                    $user = [
                        'firstname' => $securityForm($_POST['firstname']),
                        'lastname' => $securityForm($_POST['lastname']),
                        'email' => filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL),
                        'address' => $securityForm($_POST['address']),
                        'password' => $securityForm(md5($_POST['password'])),
                        'is_admin' => $_POST['is_admin']
                    ];
                } else {
                    $user = [
                        'firstname' => $securityForm($_POST['firstname']),
                        'lastname' => $securityForm($_POST['lastname']),
                        'email' => filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL),
                        'address' => $securityForm($_POST['address']),
                        'password' => $securityForm(md5($_POST['password'])),
                        'is_admin' => $_POST['is_admin']
                    ];
                }
            } else {
                $errors[] = "Password must contain between 6 and 12 characters";
            }

            $userManager->insert($user);
            header('Location:/User/index/');
        }

        return $this->twig->render('User/add.html.twig', [
            'errors' => $errors
        ]);
    }


    /**
     * Handle item deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $userManager = new UserManager();
        $userManager->delete($id);
        header('Location:/User/index');
    }
}

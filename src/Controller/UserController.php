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

        return $this->twig->render('User/index.html.twig', ['user' => $user]);
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
        $errors=[];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_POST['password'])) {
                $firstname = trim($_POST['firstname']);
                $lastname = trim($_POST['lastname']);
                $email = trim($_POST['email']);
                $address = trim($_POST['address']);
                $password = trim($_POST['password']);
                $is_admin = false;
            }

            if (empty($_POST['firstname']) && empty($_POST['lastname']) && empty($_POST['email'])
            && empty($_POST['address']) && empty($_POST['password'])) {
                $errors[] = "All fields are required.";
            }

            if (empty($_POST['firstname'])) {
                $errors[] = "Firstname is required.";
            }

            if (empty($_POST['lastname'])) {
                $errors[] = "Lastname is required.";
            }

            if (empty($_POST['email'])) {
                $errors[] = "Email is required.";
            }

            if (empty($_POST['address'])) {
                $errors[] = "Address is required.";
            }

            if (empty($_POST['password'])) {
                $errors[] = "Password is required.";
            }

            $userManager->update($user);
        }

        return $this->twig->render('User/edit.html.twig', ['user' => $user]);
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $userManager = new UserManager();
            $errors=[];

            if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])
            && !empty($_POST['address']) && !empty($_POST['password'])) {
                $firstname = trim($_POST['firstname']);
                $lastname = trim($_POST['lastname']);
                $email = trim($_POST['email']);
                $address = trim($_POST['address']);
                $password = trim($_POST['password']);
                $is_admin = false;
            }

            if (empty($_POST['firstname']) && empty($_POST['lastname']) && empty($_POST['email']) && empty($_POST['address']) && empty($_POST['password'])) {
                $errors[] = "All fields are required.";
            }

            if (empty($_POST['firstname'])) {
                $errors[] = "Firstname is required.";
            }

            if (empty($_POST['lastname'])) {
                $errors[] = "Lastname is required.";
            }

            if (empty($_POST['email'])) {
                $errors[] = "Email is required.";
            }

            if (empty($_POST['address'])) {
                $errors[] = "Address is required.";
            }

            if (empty($_POST['password'])) {
                $errors[] = "Password is required.";
            }

            $user = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'address' => $address,
                'password' => $password,
                'is_admin' => $is_admin,
            ];

            $id = $userManager->insert($user);
            header('Location:/Admin/user/' . $id);
        }

        return $this->twig->render('User/add.html.twig');
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

<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ContactManager;

/**
 * Class ContactController
 *
 */
class ContactController extends AbstractController
{
    /**
     * Display contact listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {

        $contactManager = new ContactManager();
        $contacts = $contactManager->selectAll();

        return $this->twig->render('Contact/index.html.twig', ['contacts' => $contacts]);
    }


    /**
     * Display contact informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->selectOneById($id);


        return $this->twig->render('Contact/show.html.twig', ['contact' => $contact]);
    }


    /**
     * Display contact creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $errors = [];
        $sentence = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactManager = new ContactManager();
            $contact = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'message' => $_POST['message']
            ];
            if (
                !empty($_POST['lastname']) || !empty($_POST['firstname'])
                || !empty($_POST['email']) || !empty($_POST['message'])
            ) {
                $contact = array_map("trim", $_POST);
                $userMailOk = filter_var($contact['email'], FILTER_VALIDATE_EMAIL);

                //securisé les entrées de données
                if (empty($_POST['lastname'])) {
                    $errors['lastname'] = "* Please enter your lastname.";
                    echo $errors['lastname'] . '</br>';
                };
                if (empty($_POST['firstname'])) {
                    $errors['firstname'] = "* Please enter your firstname.";
                    echo $errors['firstname'] . '</br>';
                };
                if (empty($_POST['email'])) {
                    $errors['email'] = "* Please enter your email.";
                    echo $errors['email'] . '</br>';
                };
                if (empty($_POST['message'])) {
                    $errors['message'] = "* Please enter your message.";
                    echo $errors['message'] . '</br>';
                };
                if ($userMailOk === false) {
                    $errors['email'] = 'Please enter a valid email address!';
                    echo $errors['email'] . '</br>';
                }
            } else {
                $errors['allField'] = "* Please fill in all the fields.";
                echo $errors['allField'] . '</br>';
            }

            if (empty($errors)) {
                $id = $contactManager->insert($contact);
                header('Location:/Contact/add/' . $id);
                $sentence = 'Merci' . ' ' . $contact['firstname'] . ' ' . $contact['lastname']
                    . ' ' . 'de nous avoir contacté à propos de “'
                    . ($_POST['message']) . '” .</br>' .
                    'Un de nos conseiller vous contactera à l’adresse '
                    . $contact['email'] .
                    'dans les plus brefs délais 
                    pour traiter votre demande :</br> ' . $contact['message'];
                return $sentence;
            }
        }

        return $this->twig->render('Contact/add.html.twig', [
            'errors' => $errors,
            'sentence' => $sentence
        ]);
    }



    /**
     * Handle item deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $contactManager = new ContactManager();
        $contactManager->delete($id);
        header('Location:/Contact/index');
    }
}

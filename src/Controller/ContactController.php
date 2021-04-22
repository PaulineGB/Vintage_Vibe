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
    public function data()
    {

        $contactManager = new ContactManager();
        $contacts = $contactManager->selectAll();

        return $this->twig->render('Contact/data.html.twig', ['contacts' => $contacts]);
    }

    /**
     * Display contact creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function formulaire()
    {
        $errors = [];
        $sentence = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact = array_map("trim", $_POST);
            if (
                empty($_POST['lastname']) && empty($_POST['firstname'])
                && empty($_POST['email']) && empty($_POST['message'])
            ) {
                    var_dump($contact);
                    //securisé les entrées de données
                    $userMailOk = filter_var($contact['email'], FILTER_VALIDATE_EMAIL);
                if (empty($contact['lastname'])) {
                    $errors['lastname'] = "* Please enter your lastname.";
                }
                if (empty($contact['firstname'])) {
                    $errors['firstname'] = "* Please enter your firstname.";
                }
                if (empty($contact['email'])) {
                    $errors['email'] = "* Please enter your email.";
                }
                if (empty($contact['message'])) {
                    $errors['message'] = "* Please enter your message.";
                }
                if ($userMailOk === false) {
                    $errors['email'] = 'Please enter a valid email address!';
                }
                if (empty($errors)) {
                    $contactManager = new ContactManager();
                    $contact = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'message' => $_POST['message'],
                    ];
                    $contactManager->insert($contact);
                }
                $sentence = 'Merci' . ' ' . $contact['firstname'] . ' ' . $contact['lastname']
                . ' ' . 'de nous avoir contacté à propos de “'
                . ($_POST['message']) . '”.</br>' . 'Un de nos conseiller vous contactera à l’adresse '
                . $contact['email'] . 'dans les plus brefs délais pour traiter votre demande :</br> '
                . $contact['message'];
                return
                $sentence;
            }
            return $this->twig->render('Contact/formulaire.html.twig', [
                'errors' => $errors,
                'sentence' => $sentence,
                ]);
                header('Location:/Contact/formulaire.html.twig');
        }
    }
}

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
        return $this->twig->render('Contact/data.html.twig', [
            'contacts' => $contacts
            ]);
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
        return $this->twig->render('Contact/show.html.twig', [
            'contact' => $contact
            ]);
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
        $sentence = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact = array_map("trim", $_POST);
            $userMailOk = filter_var($contact['email'], FILTER_VALIDATE_EMAIL);
            if (
                empty($contact['lastname']) && empty($contact['firstname'])
                && empty($contact['email']) && empty($contact['message'])
            ) {
                $errors['allFields'] = "Please, complete all fields!";
            } else {
                if (empty($contact['lastname'])) {
                    $errors['lastname'] = "Please, enter your lastname!";
                }
                if (empty($contact['firstname'])) {
                    $errors['firstname'] = "Please, enter your firstname!";
                }
                if (empty($contact['email'])) {
                    $errors['email'] = "Please, enter your e-mail address!";
                }
                if (empty($contact['message'])) {
                    $errors['message'] = "Please, indicate your message!";
                }
                if (!$userMailOk) {
                    $errors['emailNotOk'] = 'Please, enter a valid e-mail!';
                }
            }

            $contactManager = new ContactManager();
            $contact = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'message' => $_POST['message']
            ];
            if (empty($errors)) {
                $contactManager->insert($contact);
                $sentence = 'Thank you ' . ' ' . $contact['firstname'] . ' ' . $contact['lastname']
                    . ' ' . 'for contacting us about “ '
                    . ($contact['message']) .
                    ' " One of our advisors will contact you at: '
                    . $contact['email'] .
                    ' as soon as possible to process your request.';
            }
        }
        return $this->twig->render('Contact/formulaire.html.twig', [
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
        header('Location:/Contact/data/' . $id);
    }
}

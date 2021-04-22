<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\SizeManager;

/**
 * Class SizeController
 *
 */
class SizeController extends AbstractController
{
    public function index()
    {
        $sizeManager = new SizeManager();
        $sizes = $sizeManager->selectAll();

        return $this->twig->render('Size/index.html.twig', ['sizes' => $sizes]);
    }


    /**
     * Display size informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $sizeManager = new SizeManager();
        $size = $sizeManager->selectOneById($id);

        return $this->twig->render('Size/show.html.twig', ['size' => $size]);
    }


    /**
     * Display size edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $sizeManager = new SizeManager();
        $size = $sizeManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $size['name'] = $_POST['name'];
            $sizeManager->update($size);
            header('Location:/size/index/');
        }

        return $this->twig->render('Size/edit.html.twig', ['size' => $size]);
    }


    /**
     * Display size creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sizeManager = new SizeManager();
            $size = [
                'name' => $_POST['name'],
            ];
            $id = $sizeManager->insert($size);
            header('Location:/size/index/' . $id);
        }

        return $this->twig->render('Size/add.html.twig');
    }


    /**
     * Handle size deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $sizeManager = new SizeManager();
        $sizeManager->delete($id);
        header('Location:/size/index');
    }
}

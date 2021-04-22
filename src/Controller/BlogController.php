<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\BlogManager;

/**
 * Class BlogController
 *
 */
class BlogController extends AbstractController
{
    /**
     * Display blog listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $blogManager = new BlogManager();
        $blogs = $blogManager->selectAll();

        return $this->twig->render('Blog/index.html.twig', ['blogs' => $blogs]);
    }

    /**
     * Display blog informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $blogManager = new BlogManager();
        $blog = $blogManager->selectOneById($id);

        return $this->twig->render('Blog/show.html.twig', ['blog' => $blog]);
    }


    /**
     * Display blog edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $blogManager = new BlogManager();
        $blog = $blogManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blog['title'] = $_POST['title'];
            $blog['description'] = $_POST['description'];
            $blog['picture'] = $_POST['picture'];
            $blogManager->update($blog);
            header('Location:/blog/index/');
        }

        return $this->twig->render('Blog/edit.html.twig', ['blog' => $blog]);
    }


    /**
     * Display blog creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blogManager = new BlogManager();
            $blog = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'picture' => $_POST['picture'],
            ];
            $id = $blogManager->insert($blog);
            header('Location:/blog/index/' . $id);
        }

        return $this->twig->render('Blog/add.html.twig');
    }


    /**
     * Handle blog deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $blogManager = new BlogManager();
        $blogManager->delete($id);
        header('Location:/blog/index');
    }
}

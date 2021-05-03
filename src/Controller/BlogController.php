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
    // Display blog informations specified by $id

    public function show(int $id)
    {
        $blogManager = new BlogManager();
        $blog = $blogManager->selectOneById($id);

        return $this->twig->render('Blog/show.html.twig', ['blog' => $blog]);
    }
}

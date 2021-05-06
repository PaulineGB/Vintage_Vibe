<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\UserManager;
use App\Model\BlogManager;
use App\Model\CategoryManager;
use App\Model\ContactManager;
use App\Model\OrderManager;
use App\Model\ProductManager;
use App\Model\SizeManager;
use App\Model\NewsletterManager;
use App\Model\InvoiceManager;

/**
 * Class AdminController
 *
 */
class AdminController extends AbstractController
{
    // ADMIN HOME PAGE INDEX

    public function index()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        return $this->twig->render('Admin/index.html.twig');
    }

    // LOGIN & LOGOUT ADMIN

    public function pouletdiscodance()
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
                            header('Location:/Admin/index/');
                        } else {
                            $errors[] = "You're not allowed to come in";
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
        return $this->twig->render('Admin/adminlog.html.twig', ['errors' => $errors]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    // PRODUCT SECTION
    // Display informations products

    public function indexProduct()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $productManager = new ProductManager();
        $categoryManager = new CategoryManager();
        $sizeManager = new SizeManager();
        $products = $productManager->selectAll();
        $categories = $categoryManager->selectAll();
        $sizes = $sizeManager->selectAll();

        return $this->twig->render('Product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    // Add products

    public function addProduct()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $categoryManager = new CategoryManager();
        $sizeManager = new SizeManager();

        $categories = $categoryManager->selectAll();
        $sizes = $sizeManager->selectAll();

        $product = [];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();

            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                return $donnees;
            };

            if (empty($_POST['category_id']) && empty($_POST['size_id'])) {
                $errors[] = "Choose a category and a size!";
            } else {
                $product = [
                    'title' => $securityForm($_POST['title']),
                    'artist' => $securityForm($_POST['artist']),
                    'category_id' => $_POST['category_id'],
                    'size_id' => $_POST['size_id'],
                    'description' => $securityForm($_POST['description']),
                    'picture' => $securityForm($_POST['picture']),
                    'price' => $securityForm($_POST['price']),
                    'quantity' => $securityForm($_POST['quantity'])
                ];

                $productManager->insert($product);
                header('Location:/admin/indexProduct/');
            }
        }

        return $this->twig->render('Product/add.html.twig', [
            'errors' => $errors,
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    // Edit products

    public function editProduct(int $id): string
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $productManager = new ProductManager();
        $categoryManager = new CategoryManager();
        $sizeManager = new SizeManager();

        $product = $productManager->selectOneById($id);
        $categories = $categoryManager->selectAll();
        $sizes = $sizeManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $securityForm = function ($donnees) {
                $donnees = trim($donnees);
                return $donnees;
            };

            $product['title'] = $securityForm($_POST['title']);
            $product['artist'] = $securityForm($_POST['artist']);
            $product['category_id'] = $_POST['category_id'];
            $product['size_id'] = $_POST['size_id'];
            $product['description'] = $securityForm($_POST['description']);
            $product['picture'] = $securityForm($_POST['picture']);
            $product['price'] = $securityForm($_POST['price']);
            $product['quantity'] = $securityForm($_POST['quantity']);
            $productManager->update($product);
            header('Location:/admin/indexProduct/');
        }

        return $this->twig->render('Product/edit.html.twig', [
            'product' => $product,
            'categories' => $categories,
            'sizes' => $sizes
        ]);
    }

    // Delete products

    public function deleteProduct(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location:/admin/indexProduct/');
    }

    // Display product informations specified by $id

    public function showProduct(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        return $this->twig->render('Product/show.html.twig', ['product' => $product]);
    }

    // NEWSLETTER SECTION

    public function newsletter()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }
        $newsletterManager = new NewsletterManager();
        $newsletters = $newsletterManager->selectAll();

        return $this->twig->render('Newsletter/index.html.twig', ['newsletters' => $newsletters]);
    }

    // ORDER SECTION
    // Display orders listing

    public function indexOrder()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $invoiceManager = new InvoiceManager();
        $invoice = $invoiceManager->selectAll();

        return $this->twig->render('Order/index.html.twig', ['invoices' => $invoice]);
    }

    // Display order informations specified by $id

    public function showOrder(int $idInvoice)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }
            $orderManager = new OrderManager();
            $userManager = new UserManager();

            $order = $orderManager->selectOneOrder($idInvoice);

            $result = [];
        foreach ($order as $detail) {
            $user = $userManager->selectOneById($detail['o_user_id']);
            $detail['o_user_id'] = $user;

            $result[] = $detail;
        }
            return $this->twig->render('Order/detail.html.twig', [
                'order' => $order,
                'user' => $result,
                'idInvoice' => $idInvoice,
            ]);
    }


    // CATEGORY SECTION
    // Display category listing

    public function indexCategory()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        return $this->twig->render('Category/index.html.twig', ['categories' => $categories]);
    }

    // Display category informations specified by $id

    public function showCategory(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectOneById($id);

        return $this->twig->render('Category/show.html.twig', ['category' => $category]);
    }

    // Display category edition page specified by $id

    public function editCategory(int $id): string
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category['name'] = $_POST['name'];
            $categoryManager->update($category);
            header('Location:/admin/indexCategory/');
        }

        return $this->twig->render('Category/edit.html.twig', ['category' => $category]);
    }

    // Display category creation page

    public function addCategory()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryManager = new CategoryManager();
            $category = [
                'name' => $_POST['name'],
            ];
            $id = $categoryManager->insert($category);
            header('Location:/admin/indexCategory/' . $id);
        }

        return $this->twig->render('Category/add.html.twig');
    }

    // Delete category

    public function deleteCategory(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $categoryManager = new CategoryManager();
        $categoryManager->delete($id);
        header('Location:/admin/indexCategory/');
    }

    // SIZE SECTION
    // Display size informations

    public function indexSize()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $sizeManager = new SizeManager();
        $sizes = $sizeManager->selectAll();

        return $this->twig->render('Size/index.html.twig', ['sizes' => $sizes]);
    }

    // Display size informations specified by $id

    public function showSize(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $sizeManager = new SizeManager();
        $size = $sizeManager->selectOneById($id);

        return $this->twig->render('Size/show.html.twig', ['size' => $size]);
    }

    // Display size edition page specified by $id

    public function editSize(int $id): string
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $sizeManager = new SizeManager();
        $size = $sizeManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $size['name'] = $_POST['name'];
            $sizeManager->update($size);
            header('Location:/admin/indexSize/');
        }

        return $this->twig->render('Size/edit.html.twig', ['size' => $size]);
    }


    // Display size creation page

    public function addSize()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sizeManager = new SizeManager();
            $size = [
                'name' => $_POST['name'],
            ];
            $id = $sizeManager->insert($size);
            header('Location:/admin/indexSize/' . $id);
        }

        return $this->twig->render('Size/add.html.twig');
    }

    // Handle size deletion

    public function deleteSize(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $sizeManager = new SizeManager();
        $sizeManager->delete($id);
        header('Location:/admin/indexSize/');
    }

    // MESSAGES CONTACT SECTION
    // Display contact listing

    public function contactMessage()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $contactManager = new ContactManager();
        $contacts = $contactManager->selectAll();
        return $this->twig->render('Contact/message.html.twig', [
            'contacts' => $contacts
        ]);
    }

    // Delete contact messages

    public function deleteMessage(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $contactManager = new ContactManager();
        $contactManager->delete($id);
        header('Location:/admin/contactMessage/');
    }

    // BLOG SECTION
    // Display blog listing

    public function indexBlog()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $blogManager = new BlogManager();
        $blogs = $blogManager->selectAll();

        return $this->twig->render('Blog/index.html.twig', ['blogs' => $blogs]);
    }

    // Display blog edition page specified by $id

    public function editBlog(int $id): string
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $blogManager = new BlogManager();
        $blog = $blogManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blog['title'] = $_POST['title'];
            $blog['description'] = $_POST['description'];
            $blog['picture'] = $_POST['picture'];
            $blogManager->update($blog);
            header('Location:/admin/indexBlog/');
        }

        return $this->twig->render('Blog/edit.html.twig', ['blog' => $blog]);
    }

    // Display blog creation page

    public function addBlog()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blogManager = new BlogManager();
            $blog = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'picture' => $_POST['picture'],
            ];
            $id = $blogManager->insert($blog);
            header('Location:/admin/indexBlog/' . $id);
        }

        return $this->twig->render('Blog/add.html.twig');
    }

    // Handle blog deletion

    public function deleteBlog(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $blogManager = new BlogManager();
        $blogManager->delete($id);
        header('Location:/admin/indexBlog/');
    }

    // USER SECTION
    // Display user listing

    public function indexUser()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $userManager = new UserManager();
        $users = $userManager->selectAll();

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }


    // Display user informations specified by $id

    public function showUser(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    // Display user edition page specified by $id

    public function editUser(int $id): string
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

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
            header('Location:/admin/indexUser/');
        }

        return $this->twig->render('User/edit.html.twig', [
            'user' => $user,
            'errors' => $errors
        ]);
    }

    // Display user creation page

    public function addUser()
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

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
            header('Location:/admin/indexUser/');
        }

        return $this->twig->render('User/add.html.twig', [
            'errors' => $errors
        ]);
    }

    // Handle user deletion

    public function deleteUser(int $id)
    {
        if (isset($_SESSION['user']) && !$_SESSION['user']['is_admin'] || !isset($_SESSION['user'])) {
            header('Location: /');
        }

        $userManager = new UserManager();
        $userManager->delete($id);
        header('Location:/admin/indexUser/');
    }
}

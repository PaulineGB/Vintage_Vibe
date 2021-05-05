## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create _config/db.php_ from _config/db.php.dist_ file and add your DB parameters. Don't delete the _.dist_ file, it must be kept.

```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```

4. Import `vintage_vibe.sql` in your SQL server,
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.
7. From this starter kit, create your own web application.

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command :

`git config --global core.autocrlf true`

## URLs availables

- ## URLs availables
- Cart payment [localhost:8000/cart/payment](localhost:8000/cart/payment)
- Home page at [localhost:8000/home/index](localhost:8000/home/index)
- Home shop [localhost:8000/home/shop](localhost:8000/home/shop)
- Home details [localhost:8000/home/showproduct/:id](localhost:8000/home/showproduct/2)
- Home filter33 [localhost:8000/home/shop?sizename=1](http://localhost:8000/home/shop?sizename=1)
- Home filter45 [localhost:8000/home/shop?sizename=2](http://localhost:8000/home/shop?sizename=2)
- Home categories [localhost:8000/home/shop?categoryname=2](http://localhost:8000/home/shop?categoryname=2)
- Home userAccount [localhost:8000/home/useraccount](http://localhost:8000/home/useraccount)
- Home blog [localhost:8000/home/blog](http://localhost:8000/home/blog)
- Home team [localhost:8000/home/team](http://localhost:8000/home/team)
- Home faq [localhost:8000/Home/faq](http://localhost:8000/Home/faq)
- Home terms [localhost:8000/Home/terms](http://localhost:8000/home/terms)
- Home contact [localhost:8000/Home/contact](http://localhost:8000/Home/contact)
- Security register [localhost:8000/security/register](http://localhost:8000/security/register)
- Security login [localhost:8000/security/login](http://localhost:8000/security/login)
- Home editAccount [localhost:8000/Home/editAccount/:id](http://localhost:8000/Home/editAccount/3)
- Home showInvoice [localhost:8000/Home/showInvoice/:id](http://localhost:8000/Home/showInvoice/3)
- Admin index[localhost:8000/admin/index](http://localhost:8000/admin/index)
- Admin indexProduct [localhost:8000/admin/indexProduct](http://localhost:8000/admin/indexProduct/)
- Admin addProduct [localhost:8000/admin/addProduct](http://localhost:8000/admin/addProduct)
- Admin showProduct [localhost:8000/admin/showProduct/:id](http://localhost:8000/admin/showProduct/6)
- Admin editProduct [localhost:8000/admin/editProduct/:id](http://localhost:8000/admin/editProduct/6)
- Admin indexOrder [localhost:8000/admin/indexOrder](http://localhost:8000/admin/indexOrder)
- Admin showOrder [localhost:8000/admin/showOrder/:id](http://localhost:8000/admin/showOrder/2)
- Admin indexCategory [localhost:8000/admin/indexCategory](http://localhost:8000/admin/indexCategory)
- Admin addCategory[localhost:8000/admin/addCategory](http://localhost:8000/admin/addCategory)
- Admin editCategory[localhost:8000/admin/editCategory/:id](http://localhost:8000/admin/editCategory/1)
- Admin indexSize[localhost:8000/admin/indexSize](http://localhost:8000/admin/indexSize)
- Admin indexSize show[localhost:8000/admin/indexSize/:id](http://localhost:8000/admin/indexSize/1)
- Admin addSize[localhost:8000/admin/addSize](http://localhost:8000/admin/addSize)
- Admin editSize[localhost:8000/admin/addSize/:id](http://localhost:8000/admin/addSize/1)
- Admin indexUser[localhost:8000/admin/indexUser](http://localhost:8000/admin/indexUser)
- Admin editUser[localhost:8000/admin/editUser/:id](http://localhost:8000/admin/editUser/1)
- Admin newsletter index[localhost:8000/admin/newsletter/index](http://localhost:8000/admin/newsletter/index)
- Admin contactMessage [localhost:8000/admin/contactMessage/](localhost:8000/admin/contactMessage/)
- Admin indexBlog[localhost:8000/admin/indexBlog](http://localhost:8000/admin/indexBlog)
- Admin addBlog[localhost:8000/admin/addBlog](http://localhost:8000/admin/addBlog)
- Admin editBlog[localhost:8000/admin/editBlog/:id](http://localhost:8000/admin/editBlog/1)

## How does URL routing work ?

![Simple MVC.png](https://raw.githubusercontent.com/WildCodeSchool/simple-mvc/master/Simple%20-%20MVC.png)

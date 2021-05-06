<?php

/**
 * This file dispatch routes.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routeParts = explode('/', ltrim($_SERVER['REQUEST_URI'], '/') ?: HOME_PAGE);
$controller = 'App\Controller\\' . ucfirst($routeParts[0] ?? '') . 'Controller';
$mystr = strpos($routeParts[1], '?') ? substr($routeParts[1], 0, strpos($routeParts[1], '?')) : $routeParts[1];
$method = $mystr ?? '';
$vars = array_slice($routeParts, 2);

if (class_exists($controller) && method_exists(new $controller(), $method)) {
    echo (new $controller())->$method(...$vars);
} else {
    header("HTTP/1.0 404 Not Found");
    $url = '/home/error404';
    header('Location: ' . $url);
    exit();
}

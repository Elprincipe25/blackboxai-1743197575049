<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/middleware.php';

session_start();

$request = $_SERVER['REQUEST_URI'];
$basePath = '/blog/public';

// Remove base path and query string
$route = str_replace($basePath, '', $request);
$route = strtok($route, '?');

// Simple router
switch ($route) {
    case '/':
    case '/articles':
        require __DIR__.'/articles/index.php';
        break;
    case '/articles/create':
        require __DIR__.'/articles/create.php';
        break;
    case '/articles/store':
        require __DIR__.'/articles/store.php';
        break;
    case (preg_match('/\/articles\/(\d+)/', $route, $matches) ? true : false):
        require __DIR__.'/articles/show.php';
        break;
    case (preg_match('/\/articles\/(\d+)\/edit/', $route, $matches) ? true : false):
        require __DIR__.'/articles/edit.php';
        break;
    case (preg_match('/\/articles\/(\d+)\/update/', $route, $matches) ? true : false):
        require __DIR__.'/articles/update.php';
        break;
    case (preg_match('/\/articles\/(\d+)\/delete/', $route, $matches) ? true : false):
        require __DIR__.'/articles/delete.php';
        break;
    case '/login':
        require __DIR__.'/login.php';
        break;
    case '/register':
        require __DIR__.'/register.php';
        break;
    case '/forgot-password':
        require __DIR__.'/forgot-password.php';
        break;
    case '/reset-password':
        require __DIR__.'/reset-password.php';
        break;
    default:
        http_response_code(404);
        require __DIR__.'/errors/404.php';
        break;
}
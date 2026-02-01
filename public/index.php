<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use CMS\Controllers\AuthController;
use CMS\Services\SessionService;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
 URL primjeri:
 /vjezbe/cms/public/index.php
 /vjezbe/cms/public/index.php/login
 /vjezbe/cms/public/index.php/register
*/

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// Ako j bez .htaccess, URL je tipa /vjezbe/cms/public/index.php/register
$pos = stripos($uri, 'index.php');
$route = ($pos !== false) ? substr($uri, $pos + strlen('index.php')) : $uri;

$route = '/' . ltrim($route, '/');
$route = rtrim($route, '/');
if ($route === '') {
    $route = '/';
}



$method = $_SERVER['REQUEST_METHOD'];

$auth = new AuthController();

if ($route === '/' && $method === 'GET') {
    header('Location: index.php/login');
    exit;
}

if ($route === '/login' && $method === 'GET') {
    $auth->showLogin();
    exit;
}
if ($route === '/login' && $method === 'POST') {
    $auth->login($_POST);
    exit;
}

if ($route === '/register' && $method === 'GET') {
    $auth->showRegister();
    exit;
}
if ($route === '/register' && $method === 'POST') {
    $auth->register($_POST);
    exit;
}

if ($route === '/logout') {
    $auth->logout();
    exit;
}

if ($route === '/dashboard') {
    $s = new SessionService();
    if (!$s->get('loggedIn', false)) {
        header('Location: index.php/login');
        exit;
    }

    echo "Dashboard ✅ | User ID: " . $s->get('user_id') . " | Role: " . $s->get('role');
    echo '<br><a href="index.php/logout">Logout</a>';
    exit;
}

http_response_code(404);
echo "404 - route not found: " . htmlspecialchars($route);

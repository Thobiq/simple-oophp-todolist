<?php 

// Ambil request path tanpa query string
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Lokasi base project
$location = '/simple-oophp-todolist';

// Hapus base path jika ada
$relativePath = str_replace($location, '', $request);

// Routing sederhana
switch ($relativePath) {
    case '/':
    case '':
        require "views/todolist.php";
        break;
    case '/login':
        require "views/login.php";
        break;
    case '/register':
        require "views/register.php";
        break;
    case '/install':
        require "config/install.php";
        break;
    case '/logo':
        require "assets/image/logo_web_tbq.png";
        break;
    default:
        http_response_code(404);
        echo "404 - Page Not Found";
}

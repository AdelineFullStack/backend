<?php
// On charge l'autoload de Composer pour trouver la classe Database
require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\MenuController;

// Création du routeur
$router = new Router();

//Les routes API (Format : addRoute(METHODE, URL, NOM_CLASSE, NOM_METHODE))
$router->addRoute('GET', '/api/menus', 'App\Controllers\MenuController', 'index');
$router->addRoute('GET', '/api/menu/details', 'App\Controllers\MenuController', 'show');

// On lance l'aiguillage
$router->dispatch();

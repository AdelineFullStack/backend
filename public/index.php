<?php
ob_start(); // Démarre la mise en mémoire tampon de sortie pour éviter les problèmes d'en-têtes
// backend/public/index.php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

// Route de test
$router->addRoute('GET', '/api/test', function(){
    header('Content-Type: application/json');
    echo json_encode(["message" => "Le Router fonctionne !"]);
});

// Lancer le dispatching
$router->dispatch();

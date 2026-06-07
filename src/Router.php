<?php
namespace App;
// backend/src/Router.php

class Router {
    private $routes = [];

    // Méthode pour enregistrer une route
    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    // Méthode pour analyser l'URL et exécuter la bonne logique
    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {
                // Si la route correspond, on appelle la fonction (handler)
                return call_user_func($route['handler']);
            }
        }

        // Si aucune route ne correspond : Erreur 404
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
    }
}

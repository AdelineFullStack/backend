<?php
namespace App;

class Router {
    private $routes = [];

    // Méthode pour enregistrer une route
    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    // Méthode pour analyser l'URL et exécuter la bonne logique
    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route['path'], $uri, $method)) { // Utiliser la méthode matchRoute
                // Instanciation du contrôleur
                $controller = new $route['controller']();
                return call_user_func([$controller, $route['action']]);
            }
        }

        // Si aucune route ne correspond : Erreur 404
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
    }

    private function matchRoute($routePath, $requestUri, $requestMethod) {
    return $requestUri === $routePath && $requestMethod === $requestMethod; // Assurez-vous d'utiliser $requestMethod
}


}

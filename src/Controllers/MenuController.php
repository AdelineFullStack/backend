<?php
namespace App\Controllers;

use App\Models\Menu;

class MenuController {

/*Cette méthode récupère tous les menus et les renvoie en JSON */
public function index() {
    // On crée une instance du modéle
    $menuModel = new Menu();

    // On récupère les données via la méthode getAll() qu'on a créée avant
    $menus = $menuModel->getAll();

    // On précise au nav que l'on envoie du JSON (Header)
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); // On autorise Vue.js à lire l'API

    // On transforme le tableau PHP en texte JSON et on l'affiche
    echo json_encode($menus);
   
  }
/* Récupère UN SEUL menu par son ID */
public function show() {
    // 1. On récupère l'ID passé dans l'URL (ex: /api/menu/details?id=5)
    $id = $_GET['id'] ?? null;

    // Sécurité : Si l'ID n'est pas fourni, on renvoie une erreur
    if (!$id) {
        header('content-type: application/json', true, 400);
        echo json_encode(["error" => "L'identifiant du menu est manquant."]);
        return;
    }

    $menuModel = new Menu();
    // 2. On appelle la méthode getById que nous avons ajoutée au Modèle
    $menu = $menuModel->getById($id);

    // 3. Si le menu n'existe pas en base

    if (!$menu) {
         // On récupère les menus du même thème
        $menu['similaires'] = $menuModel->getSimilar($menu['theme_id'], $id);
        
        header('Content-Type: application/json', true, 404);
        echo json_encode(["error" => "Menu introuvable."]);
        return;
    }
    // 4. On renvoie les données complètes (infos + plats)
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($menu);    
   }
}
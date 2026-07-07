<?php

namespace App\Models;

use Config\Database;
use PDO;

class Menu {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    // (Methode :`getAll`) Cette requete SQL permet d'aller chercher le nom du théme dans 
    // la table 'théme' sinon, c'est que l'id du théme qui sera afficher. 
    public function getAll() {
        $sql = "SELECT m.*, t.libelle as theme_nom 
        FROM menu m 
        LEFT JOIN theme t ON m.theme_id = t.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // NOUVELLE MÉTHODE pour la Vue Détails
    public function getById($id) {
    $db = Database::getConnection();
    
    // 1. Infos du menu
    $stmt = $db->prepare("SELECT m.*, t.libelle as theme_nom FROM menu m LEFT JOIN theme t ON m.theme_id = t.id WHERE m.id = :id");
    $stmt->execute(['id' => $id]);
    $menu = $stmt->fetch();

    if ($menu) {
        // 2. Récupérer les plats ET leurs allergènes
        $sqlPlats = "SELECT p.*, GROUP_CONCAT(a.nom SEPARATOR ', ') as allergene_list 
                     FROM plat p 
                     JOIN menu_plat mp ON p.id = mp.plat_id 
                     LEFT JOIN plat_allergene pa ON p.id = pa.plat_id 
                     LEFT JOIN allergene a ON pa.allergene_id = a.id 
                     WHERE mp.menu_id = :id 
                     GROUP BY p.id";
        
        $stmtPlats = $db->prepare($sqlPlats);
        $stmtPlats->execute(['id' => $id]);
        $menu['plats'] = $stmtPlats->fetchAll();
    }
    return $menu;
}

   public function getSimilar($theme_id, $current_menu_id) {
    $db = Database::getConnection();
    $sql = "SELECT m.*, t.libelle as theme_nom 
            FROM menu m 
            LEFT JOIN theme t ON m.theme_id = t.id 
            WHERE m.theme_id = :theme_id AND m.id != :current_id 
            LIMIT 3";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'theme_id' => $theme_id,
        'current_id' => $current_menu_id
    ]);
    return $stmt->fetchAll();
}

}
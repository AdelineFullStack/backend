<?php
// 1. On charge l'autoload de Composer pour trouver la classe Database
require_once __DIR__ . '/../vendor/autoload.php';

// 2. On indique qu'on veut utiliser la classe Database
use Config\Database;

echo "<h1>Test de connexion à MariaDB</h1>";

try {
    // 3. On tente de récupérer la connexion PDO
    $db = Database::getConnection();
    
    // 4. On exécute une petite requête SQL pour être sûr que la BDD répond
    $query = $db->query("SELECT VERSION() as version");
    $result = $query->fetch();

    echo "<p style='color: green;'>✅ Connexion réussie !</p>";
    echo "<p>Version du serveur MariaDB : <strong>" . $result['version'] . "</strong></p>";

} catch (Exception $e) {
    // 5. Si ça rate, on affiche l'erreur proprement
    echo "<p style='color: red;'>❌ Échec de la connexion.</p>";
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}

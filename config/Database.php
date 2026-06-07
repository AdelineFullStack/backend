<?php
namespace Config;

use PDO;
use PDOException;

class Database {
    // Instance unique (le Singleton)
    private static $instance = null;
    private $connection;

    // Le constructeur est PRIVÉ pour empêcher de créer plusieurs instances
    private function __construct() {
        // Paramètres de connexion correspondants à ton docker-compose.yml
        $host = 'db_sql'; // Nom du service dans Docker
        $db   = 'vite_gourmand';
        $user = 'root';
        $pass = 'root';
        $port = '3306';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lance une erreur si le SQL est mauvais
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Récupère les données sous forme de tableau associatif
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Utilise les vraies requêtes préparées (Sécurité ++)
        ];

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // En cas d'erreur, on arrête tout et on affiche le message
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // La méthode magique pour récupérer la connexion partout
    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}

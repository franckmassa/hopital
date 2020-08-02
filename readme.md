1 - Créer un fichier database.php dans le dossier models.
2 - Copier le code suivant dans le fichier database.php.

<?php

// On crée un moèle database parent
class database {

    protected $db;

    public function __construct() {
        try {
            // On initialise la base de données hospital
            $this->db = NEW PDO('mysql:host=localhost;dbname=hospital;charset=utf8', ' ', ' ');
        }
// Autrement un message d'erreur est affiché
        catch (Exception $e) {
            die($e->getMessage());
        }
    }

// On ferme la connexion
    public function __destruct() {
        $this->db = NULL;
    }

}



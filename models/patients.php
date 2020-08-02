<?php

///creation de la classe patients
class patients extends database
{

    //liste des attributs (protected= accessible dans la classe et ses héritiers , private = uniquement ds la classe, public= classe et autres(controller et view)
    public $id;
    public $lastname;
    public $firstname;
    public $birthdate;
    public $phone;
    public $mail;
    public $search;

    //méthode construct
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * La methode permet d'ajouter des patients à la liste 
     * @return type
     */
    public function addPatient()
    {
        // On écrit la requête
        $query = 'INSERT INTO `patients`(`lastname`, `firstname`, `birthdate`, `phone`, `mail`) '
            . 'VALUES (:lastname, :firstname, :birthdate, :phone, :mail)';
        // On prend l'objet PDO (db) et on prépare la requête $query
        $insertPatient = $this->db->prepare($query);
        // bindvalue permet d'attibuer une valeur string au marqueur nominatif :lastname
        $insertPatient->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        // bindvalue permet d'attibuer une valeur string au marqueur nominatif :firstname
        $insertPatient->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        // bindvalue permet d'attibuer une valeur string au marqueur nominatif :birthdate
        $insertPatient->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        // bindvalue permet d'attibuer une valeur string au marqueur nominatif :phone
        $insertPatient->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        // bindvalue permet d'attibuer une valeur string au marqueur nominatif :mail
        $insertPatient->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        // On execute la requête 
        return $insertPatient->execute();
    }

    /** 
     * Méthode getPatientsList pour récupérer le résultat de la requête pour la liste des patients
     *  Afichage d'un tableau vide en cas d'erreur, pour plus de clareté pour l'utilisateur 
     */
    public function getPatientsList()
    {
        // Tableau des données
        $result = array();
        // On récupère les données dans la variable $PDOResult
        $PDOResult = $this->db->query('SELECT `id`, `lastname`, `firstname`, `birthdate`, `phone`, `mail` FROM `patients`');
        // Si la variable $PDOResult est de type objet, on stocke toutes les données avec fetchall, dans la variable $result
        if (is_object($PDOResult)) {
            $result = $PDOResult->fetchAll(PDO::FETCH_OBJ);
        }
        // On retourne les données dans un tableau associatif array();
        return $result;
    }

    /**
     *  Méthode getProfilList pour récupérer le résultat de la requête pour le profil du patient
     *  On prépare la requête qui retourne un objet
     */
    public function getProfilById()
    {
        $PDOResult = $this->db->prepare('SELECT `id`, `lastname`, `firstname`, `birthdate`, `phone`, `mail` '
            . 'FROM `patients` '
            . 'WHERE `id` = :id'); // :id marqueur nominatif car id est une inconnue
        // bindvalue Associe une valeur à un paramètre (marqueur nominatif), this se réfère à tous les attributs de la classe
        $PDOResult->bindvalue(':id', $this->id, PDO::PARAM_INT);
        /** On execute la requête
         */
        $PDOResult->execute();
        if (is_object($PDOResult)) {
            /**
             * On utilise fetch pour la récupération d'une seule valeur
             */
            $result = $PDOResult->fetch(PDO::FETCH_OBJ);
        }
        return $result;
    }

    public function updatePatientProfil()
    {
        $query = 'UPDATE `patients` SET `lastname` = :lastname, `firstname` = :firstname, `birthdate` = :birthdate, `phone` = :phone, `mail` = :mail WHERE `id` = :id';
        $modifyPatient = $this->db->prepare($query);
        $modifyPatient->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $modifyPatient->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $modifyPatient->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $modifyPatient->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $modifyPatient->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $modifyPatient->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $modifyPatient->execute();
    }

    /**
     * Méthode pour supprimer un patients et son rendez-vous (suppression patients)
     * @return string
     */
    public function removePatient()
    {
        $remove = $this->db->prepare('DELETE FROM `patients`'
            . 'WHERE `id` =  :idRemove ');
        $remove->bindValue(':idRemove', $this->id, PDO::PARAM_INT);
        return $remove->execute();
    }

    // Déclaration de la méthode findPatientByLastname($search)
    public function findPatientByLastname($search)
    {   //Déclaration du tableau vide $findPatientList
        $findPatientList = array();
        //Préparation de la requete et intégration dans $findPatient
        $findPatient = $this->db->prepare(
            'SELECT `id`, `lastname`, `firstname`, DATE_FORMAT(`birthdate`, \'%d/%m/%Y\') AS `birthdate`, `phone`, `mail` '
                . 'FROM `patients` '
                . 'WHERE `lastname` LIKE :search OR `firstname` LIKE :search ORDER BY `lastname`'
        );
        //Récupération de la valeur de $search passée en parametre de la méthode dans la fonction bindValue() pour le filtrage, ajout des modulos
        $findPatient->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        //Si $findPatient est éxécuté
        if ($findPatient->execute()) {   //Si $findPatient est un objet
            if (is_object($findPatient)) {   //Récupération du résultat de la requete dans $findPatientList
                $findPatientList = $findPatient->fetchAll(PDO::FETCH_OBJ);
                //Sinon
            } else {
                //Attribuer FALSE a $findPatientList
                $findPatientList = FALSE;
            }
            //Sinon
        } else {
            //Attribuer FALSE a $findPatientList
            $findPatientList = FALSE;
        }
        //Retourner $findPatientList
        return $findPatientList;
    }

    // Exercice 13 (pagination)
    public function numberOfResults()
    {
        $queryResult = $this->db->query('SELECT COUNT(`id`) AS countResults FROM `patients`');
        if (is_object($queryResult)) {
            $result = $queryResult->fetch(PDO::FETCH_OBJ);
        } else {
            $result = false;
        }
        return $result;
    }

    public function getPatientsListByFive($limit, $offset)
    {
        $result = array();
        $queryResult = $this->db->prepare('SELECT `id`,`lastname`, `firstname`, `birthdate`,`phone`, `mail` '
            . 'FROM `patients` '
            . 'LIMIT :limit OFFSET :offset');
        $queryResult->bindValue(':limit', $limit, PDO::PARAM_INT);
        $queryResult->bindValue(':offset', $offset, PDO::PARAM_INT);
        if ($queryResult->execute()) {
            if (is_object($queryResult)) {
                $result = $queryResult->fetchAll(PDO::FETCH_OBJ);
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    // On ferme la db
    public function __destruct()
    {
        $this->db = NULL;
    }
}

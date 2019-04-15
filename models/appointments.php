<?php
  
//creation de la classe appointments
class appointments extends database{

//liste des attributs (protected= accessible dans la classe et ses héritiers , private = uniquement ds la classe, public= classe et autres(controller et view)
    public $id;
    public $dateHour;
    public $idPatients;

//méthode construct
    public function __construct() {
        parent::__construct();
    }

// Exercice 5
    /**
     * Méthode  addAppointment pour récupérer le résultat de la requête
     * @return type
     */
    public function addAppointment() {
        $query = 'INSERT INTO `appointments`(`dateHour`, `idPatients`) '
                . 'VALUES (:dateHour, :idPatients)';
        $insertRendezVous = $this->db->prepare($query);
        $insertRendezVous->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        $insertRendezVous->bindValue(':idPatients', $this->idPatients, PDO::PARAM_INT);
        return $insertRendezVous->execute();
    }

    /**
     * Méthode checkIfAppointmentExist pour contrôler si il y a déjà un rendez-vous de programmer
     * @return boolean 
     */
    public function checkIfAppointmentExist() {
        $query = 'SELECT COUNT(`id`) AS `count` FROM `appointments` WHERE `dateHour` = :dateHour ';
        $check = $this->db->prepare($query);
        // bindvalue donne une valeur au marqueur nominatif
        $check->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        // Si $check est vérifié, on récupère la valeur dateHour dans la variable $result avec fetch
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            // On met le résultat 0 ou 1 dans $bool 
            $bool = $result->count;
            // Sinon on retourne le résultat faux
        } else {
            $bool = FALSE;
        }
        // et on retourne le résultat
        return $bool;
    }

// Exercice 6
    /**
     * Méthode  getAppointmentsList pour récupérer le résultat de la requête
     * @return type
     */
    /*public function getAppointmentsList() {
        $result = array();
        $PDOResult = $this->db->query('SELECT `appointments`.`id`, `appointments`.`dateHour`, `appointments`.`idPatients`, `patients`.`id`, `patients`.`lastname`, `patients`.`firstname` '
                . 'FROM `appointments` INNER JOIN `patients` ON `appointments`.`id` = `patients`.`id`');
        if (is_object($PDOResult)) {
            $result = $PDOResult->fetchAll(PDO::FETCH_OBJ);
        }
        return $result;
    }*/

    /**
     * Méthode pour afficher la liste des rendez-vous (Affichage liste rendez-vous)
     * @return string*/

      public function getAppointmentsList(){
      //préparation de la requête SQL
      //Première solution avec DATE_FORMAT simple
      //$query = 'SELECT `id`, DATE_FORMAT(`dateHour`, \'Le %d/%m/%Y à %Hh%i\') AS `dateHour`, `idPatients` FROM `appointments`';
      //Seconde solution avec DATE_FORMAT éclaté
      $query = 'SELECT `id`, DATE_FORMAT(`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT (`dateHour`, \'%Hh%i\') AS `hour`, `idPatients` FROM `appointments`';
      //On appelle la requête pour la plasser dans une variable $listAppointments
      $listAppointments = $this->db->query($query);
      //Création d'un tableau $isObjectResult qui servira pour la vérification qui va suivre
      $isObjectResult = array();
      //Condition pour vérifier que la variable est bien un objet
      if (is_object($listAppointments)) {
      //On affiche tout le contenu du résulat de la requête avec fetchAll
      $isObjectResult = $listAppointments->fetchAll(PDO::FETCH_OBJ);
      }
      //On retourne le résultat
      return $isObjectResult;
      }
     
     /* CORRECTION MAXIME
     * public function getShowAppointmentsList() {
      $isObjectResult = array();
      $PDOResult = $this->db->query('SELECT `appointments`.`id`, `appointments`.`dateHour`, `patients`.`lastname`, `patients`.`firstname`, `appointments`.`idPatients` FROM `appointments` INNER JOIN `patients` ON `appointments`.`idPatients` = `patients`.`id`');
      if (is_object($PDOResult)) {
      $isObjectResult = $PDOResult->fetchAll(PDO::FETCH_OBJ);
      }
      return $isObjectResult;
      }
        */

   // exercice 7
    public function getAppointmentById() {
        $query = 'SELECT `appointments`.`id`, DATE_FORMAT(`appointments`.`dateHour`, \'%Y-%m-%d\') AS `date`, DATE_FORMAT(`appointments`.`dateHour`, \'%H:%i\') AS `hour`, `appointments`.`idPatients` '
                . 'FROM `appointments` '
                . 'WHERE `appointments`.`id` = :id';
        $AppointmentDetails = $this->db->prepare($query);
        $AppointmentDetails->bindValue(':id', $this->id, PDO::PARAM_INT);
        $AppointmentDetails->execute();
        if (is_object($AppointmentDetails)) {
            $getAppointmentsDetails = $AppointmentDetails->fetch(PDO::FETCH_OBJ);
            // fetch uniquement pour le select
        }
        return $getAppointmentsDetails;
    }
    // exercice 8
    public function updateAppointment() {
        $query = 'UPDATE `appointments` '
                . 'SET `dateHour` = :dateHour, `idPatients` = :idPatients '
                . 'WHERE `id` = :id';
        $updatePatient = $this->db->prepare($query);
        // id en dernier pour l'avoir dans le sens de la requete
        
        $updatePatient->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        $updatePatient->bindValue(':idPatients', $this->idPatients, PDO::PARAM_INT);
        $updatePatient->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $updatePatient->execute();
    }
    /**
     * Méthode getRendezVousInfo pour récupérer le résultat de la requête
     * @return type
     */
    public function getAppointmentByIdPatients() {
        $result = array();
        $appointment = $this->db->prepare('SELECT `appointments`.`id`,DATE_FORMAT(dateHour, \'%d/%m/%Y\') AS date, DATE_FORMAT (dateHour, \'%H:%i\') AS hour'
                . ' FROM `appointments` '
                . ' WHERE `idPatients` = :idPatients');
        $appointment->bindValue(':idPatients', $this->idPatients, PDO::PARAM_INT);
        if ($appointment->execute()) {
            $result = $appointment->fetchAll(PDO::FETCH_OBJ);
        }else{
            $result = FALSE;
        }
        return $result;
    }
    
    //Exercice 10 (supprime une ligne rdv)
    public function deleteAppointment() {
        $PDOResult = $this->db->prepare('DELETE FROM `appointments`
         WHERE `id` = :id');
        //bindvalue = attribut la valeur
        $PDOResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $PDOResult->execute();
    }   
}

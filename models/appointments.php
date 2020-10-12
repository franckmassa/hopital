<?php

//creation de la classe appointments
class appointments extends database
{

    //liste des attributs (protected= accessible dans la classe et ses héritiers , private = uniquement ds la classe, public= classe et autres(controller et view)
    public $id;
    public $dateHour;
    public $idPatients;

    //méthode construct
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Méthode  addAppointment pour récupérer le résultat de la requête
     * @return type
     */
    public function addAppointment()
    {
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
    public function checkIfAppointmentExist()
    {
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

    /**
     * Méthode pour obtenir la liste des rendez-vous
     *
     * @return void
     */
    public function getAppointmentsList()
    {
        $isObjectResult = array();
        $PDOResult = $this->db->query('SELECT `appointments`.`id`, DATE_FORMAT(`appointments`.`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT(`appointments`.`dateHour`, \'%H:%i\') AS `hour`, `patients`.`lastname`, `patients`.`firstname`, `appointments`.`idPatients` FROM `appointments` INNER JOIN `patients` ON `appointments`.`idPatients` = `patients`.`id`');
        if (is_object($PDOResult)) {
            $isObjectResult = $PDOResult->fetchAll(PDO::FETCH_OBJ);
        }
        return $isObjectResult;
    }

    public function getAppointmentById()
    {
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
   
    public function updateAppointment()
    {
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
     * Méthode 
     * @return type
     */
    public function getAppointmentByIdPatients()
    {
        $result = array();
        $appointment = $this->db->prepare('SELECT `appointments`.`id`,DATE_FORMAT(dateHour, \'%d/%m/%Y\') AS date, DATE_FORMAT (dateHour, \'%H:%i\') AS hour'
            . ' FROM `appointments` '
            . ' WHERE `idPatients` = :idPatients');
        $appointment->bindValue(':idPatients', $this->idPatients, PDO::PARAM_INT);
        if ($appointment->execute()) {
            $result = $appointment->fetchAll(PDO::FETCH_OBJ);
        } else {
            $result = FALSE;
        }
        return $result;
    }

    public function deleteAppointment()
    {
        $PDOResult = $this->db->prepare('DELETE FROM `appointments`
         WHERE `id` = :id');
        //bindvalue = attribut la valeur
        $PDOResult->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $PDOResult->execute();
    }

}

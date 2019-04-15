<?php
include 'models/patients.php';
include 'models/appointments.php';
/** 
 * On instancie l'objet profil
 */
$profil = new patients();

$profil->id = $_GET['id'];
/** 
 * On appelle la méthode getProfilById à la fin du code pour que l'affichage soit instantanée.
 */

//déclaration de la regex pour les noms
$regexName = '/^[A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ° \'\-]+$/';
//regex pour le numéro de téléphone (commençant obligatoirement par un 0 et contenant 10 chiffres)
// attention regex phone number
$regexPhoneNumber = '/^0[1-678][0-9]{8}/';
//regex pour la date de naissance (aaaa-mm-jj)
$regexBirthDate = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}/';
//regex pour l'adresse mail (autorisation chiffres lettres, obligation de l'@ et .)
$regexMail = '/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/';
//déclaration du tableau d'erreur
$formError = array();

if (isset($_POST['submit'])) {
    $patient = NEW patients();
    
    if (!empty($_POST['lastname'])) {
        if (preg_match($regexName, $_POST['lastname'])) {
            $patient->lastname = htmlspecialchars($_POST['lastname']);
        } else {
            $formError['lastname'] = 'La saisie de votre nom est invalide';
        }
    } else {
        $formError['lastname'] = 'Veuillez indiquer votre nom';
    }
    
    if (!empty($_POST['firstname'])) {
        if (preg_match($regexName, $_POST['firstname'])) {
            $patient->firstname = htmlspecialchars($_POST['firstname']);
        } else {
            $formError['firstname'] = 'La saisie de votre prénom est invalide';
        }
    } else {
        $formError['firstname'] = 'Veuillez indiquer votre prénom';
    }
    
    if (!empty($_POST['birthdate'])) {
        if (preg_match($regexBirthDate, $_POST['birthdate'])) {
            $patient->birthdate = htmlspecialchars($_POST['birthdate']);
        } else {
            $formError['birthdate'] = 'La saisie de votre date de naissance est invalide';
        }
    } else {
        $formError['birthdate'] = 'Veuillez indiquer votre date de naissance';
    }
    
    if (!empty($_POST['phone'])) {
        if (preg_match($regexPhoneNumber, $_POST['phone'])) {
            $patient->phone = htmlspecialchars($_POST['phone']);
        } else {
            $formError['phone'] = 'La saisie de votre numéro de téléphone est invalide';
        }
    } else {
        $formError['phone'] = 'Veuillez indiquer votre numéro de téléphone';
    }
    
     if (!empty($_POST['mail'])) {
        if (preg_match($regexMail, $_POST['mail'])) {
            $patient->mail = htmlspecialchars($_POST['mail']);
        } else {
            $formError['mail'] = 'La saisie de votre mail est invalide';
        }
    } else {
        $formError['mail'] = 'Veuillez indiquer votre mail';
    }
    
    if (count($formError) == 0){
        // Récupération de la valeur de l'id dans le paramètre de l'url
        $patient->id = $_GET['id'];
        if (!$patient->updatePatientProfil()){
            $formError['submit'] = 'Il y a eu un problème';
        }
    }
}
// On instancie (dans une variable appeler (objet) $appointment à partir de l'instance(inutilisable seule) appointments (copie de la classe appointments)
$appointment = new appointments();
$appointment->idPatients = $profil->id;
// On place le select à la fin du code pour que l'affichage soit instantanée
$profilList = $profil->getProfilById();

// On appelle la méthode getAppointmentsList
// La flèche appelée opérateur objet signifie que l'on souhaite accéder à la méthode getAppointmentsList de l'objet $appointment
$appointmentList = $appointment->getAppointmentByIdPatients();

?>
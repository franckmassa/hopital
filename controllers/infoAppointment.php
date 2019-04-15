<?php
include 'models/appointments.php';
include 'models/patients.php';

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $patient = new patients();
    $patient->id = $_GET['id'];

// nouvel objet tout en haut car modification
if (isset($_POST['submit'])) {
    $updateAppointment = new appointments();
    $updateAppointment->id = $_GET['id'];

    $formError = array();
//regex pour la date (aaaa-mm-jj)
    $regexDate = '/^((19|20)[0-9]{2})-(0[1-9]|1[012])-(0[1-9]|([1-2][0-9])|3[01])$/';
//regex pour l'heure (16:30)
    $regexHour = '/^([01]?[0-9]|2[0-3]):[0-5][0-9]/';

    if (!empty($_POST['dateApp'])) {
        if (preg_match($regexDate, $_POST['dateApp'])) {
            $date = $_POST['dateApp'];
        } else {
            $formError['dateApp'] = 'La date est invalide';
        }
    } else {
        $formError['dateApp'] = 'La date est obligatoire';
    }

    if (!empty($_POST['hourApp'])) {
        if (preg_match($regexHour, $_POST['hourApp'])) {
            $hour = $_POST['hourApp'];
        } else {
            $formError['hourApp'] = 'L\'heure est invalide';
        }
    } else {
        $formError['hourApp'] = 'L\'heure est obligatoire';
    }


    if (!empty($_POST['patient'])) {
        if (is_numeric($_POST['patient'])) {
            $updateAppointment->idPatients = $_POST['patient'];
        } else {
            $formError['patient'] = 'Le patient est invalide';
        }
    } else {
        $formError['patient'] = 'Le patient est obligatoire';
    }

    if (count($formError) == 0) {
        $updateAppointment->dateHour = $date . ' ' . $hour;
        $updateAppointment->updateAppointment();
    }
}

$appointment = new appointments();
$appointment->id = $_GET['id'];
$showAppointment = $appointment->getAppointmentById();
// renvoyer sur une autre page pour eviter les erreurs
if ($showAppointment == false){
    header('Location: ajout-rendezvous.php');
    exit;
}
$patient = new patients();
$patientsList = $patient->getPatientsList();
}
?>
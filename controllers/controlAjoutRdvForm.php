<?php
include 'models/appointments.php';
// Liste des regex
$patient = NEW patients();
$patientsList = $patient->getPatientsList();
$hour = '00:00';
$date = '1900-01-01';
//regex pour date (aaaa-mm-jj)
$regexDate = '/^((19|20)[0-9]{2})-(0[1-9]|1[012])-(0[1-9]|([1-2][0-9])|3[01])$/';
//regex pour l'heure (16:30)
$regexHour = '/^([01]?[0-9]|2[0-3]):[0-5][0-9]/';
//déclaration du tableau d'erreur
$formError = array();

// Si on a submit, on instancie l'objet $appointment
if (isset($_POST['submit'])) {
    $appointment = NEW appointments();
    if (!empty($_POST['dateApp'])) {
        if (preg_match($regexDate, $_POST['dateApp'])) {
            $date = htmlspecialchars($_POST['dateApp']);
        } else {
            $formError['dateApp'] = 'la date de votre rendez-vous est invalide';
        }
    } else {
        $formError['dateApp'] = 'Veuillez indiquer la date de votre rendez-vous';
    }

    if (!empty($_POST['hourApp'])) {
        if (preg_match($regexHour, $_POST['hourApp'])) {
            $hour = htmlspecialchars($_POST['hourApp']);
        } else {
            $formError['hourApp'] = 'l\'heure de votre rendez-vous est invalide';
        }
    } else {
        $formError['hourApp'] = 'Veuillez indiquer l\'heure de votre rendez-vous';
    }

    if (!empty($_POST['patients'])) {
        if (!is_nan($_POST['patients'])) {
            $appointment->idPatients = htmlspecialchars($_POST['patients']);
        } else {
            $formError['patients'] = 'le patient que vous avez choisie n\'est pas valide';
        }
    } else {
        $formError['patients'] = 'le patient que vous avez choisie n\'existe pas';
    }

    if (count($formError) == 0) {
        $appointment->dateHour = $date . ' ' . $hour;
        $check = $appointment->checkIfAppointmentExist();
        if ($check === '0') {
            if (!$appointment->addAppointment()) {
                $formError['submit'] = 'Il y a eu un problème';
            }
        } elseif ($check === FALSE) {
            $formError['submit'] = 'Il y a eu un problème';
        }
         else {
            $formError['submit'] = 'le rendez-vous est déjà pris';
        }
    }
}
<?php

include 'models/appointments.php';

if (isset($_GET['idrdv'])) {
    $deleteAppointment = NEW appointments();
    $deleteAppointment->id = $_GET['idrdv'];
    $deleteAppointmentResult = $deleteAppointment->deleteAppointment();
    if ($deleteAppointmentResult == false) {
        $deleteError = 'le rendez-vous n\'a pas pu être supprimé';
    }
}

/* On instancie (dans une variable appeler (objet) $appointment à partir de l'instance(inutilisable seule) appointments (copie de la classe appointments) */
$appointment = new appointments();
/*On appelle la méthode getAppointmentsList
La flèche appelée opérateur objet signifie que l'on souhaite accéder à la méthode getAppointmentsList de l'objet $appointment*/
$appointmentList = $appointment->getAppointmentsList();



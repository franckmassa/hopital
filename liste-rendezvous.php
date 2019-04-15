<?php
include 'models/database.php';
include 'controllers/appointmentListCtl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <title>Liste des rendez-vous</title>    
    </head>
    <body>
        <?php include 'controllers/controllerNavbar2.php'; ?>


        <?php if (isset($deleteError)) { ?>
            <p> <?= $deleteError ?> </p>
        <?php } ?>
        <div class="container">
            <div class="row">
                <H1 class="col-md-12 text-center text-uppercase text-muted font-weight-bold">Liste des rendez-vous</H1>
            </div>
            <div class="row">
                <table class="col-md-12 bg-white">
                    <thead>
                    <th colspan="12">Liste des rendez-vous</th>
                    <tr>
                        <th>Identifiant Patient</th>
                        <th>RDV</th>
                        <th>Suppression</th>
                        <th>Info</th>      
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointmentList as $appointmentDetail) { ?>
                            <tr>
                                <td><?= $appointmentDetail->idPatients ?></td>
                                <td><?= $appointmentDetail->date . ' ' . $appointmentDetail->hour ?></td>
                                <!-- On ajoute un lien qui redirige vers la page ajout-rendezvous.php
                                     On rajoute le paramètre id dans l'url et on echo la valeur nominative de l'id 
                                après ? le mot id doit être  dans le get du controleur ajout-rendezvous.php -->
                                <td> <a href="liste-rendezvous.php?idrdv=<?= $appointmentDetail->id ?>" class="btn btn-danger" role="button" aria-pressed="true"><i class="far fa-trash-alt"></i></a></td>                                 
                                <td> <a href="rendezvous.php?id=<?= $appointmentDetail->idPatients ?>" class="btn btn-secondary" role="button" aria-pressed="true">+ d'infos</a> </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                <a href="ajout-rendezvous.php" class="btn btn-primary btn-lg active w-100" role="button" aria-pressed="true">Nouveau rendez-vous</a>
            </div>
        </div>
    </body>
</html>

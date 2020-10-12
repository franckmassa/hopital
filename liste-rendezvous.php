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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Liste des rendez-vous</title>
</head>

<body class="container">
    <?php include 'navbar2.php'; ?>

<div class="container">

    <?php if (isset($deleteError)) { ?>
        <p> <?= $deleteError ?> </p>
    <?php } ?>

    <div class="row justify-content-center">
        <h1 class="text-center col-md-12 mt-3 mb-3">Liste des rendez-vous</h1>
        <table class="col-md-12 table table-hover">
            <thead>
                <tr class="table-light">
                    <th>Identifiant Patient</th>
                    <th>Identité</th>
                    <th>RDV</th>
                    <th>Suppression</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointmentList as $appointmentDetail) { ?>
                    <tr class="table-light">
                        <td><?= $appointmentDetail->idPatients ?></td>
                        <td><?= $appointmentDetail->firstname . ' ' . $appointmentDetail->lastname ?></td>
                        <td><?= $appointmentDetail->date . ' à ' . $appointmentDetail->hour ?></td>
                        <!-- On ajoute un lien qui redirige vers la page ajout-rendezvous.php
                                On rajoute le paramètre id dans l'url et on echo la valeur nominative de l'id 
                                après ? le mot id doit être  dans le get du controleur ajout-rendezvous.php -->
                        <td> <a href="liste-rendezvous.php?idrdv=<?= $appointmentDetail->id ?>" class="btn btn-danger" role="button" aria-pressed="true" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce rendez-vous ?'));"><i class="far fa-trash-alt"></i></a></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        
            <a href="ajout-rendezvous.php" class="btn btn-primary btn-lg active w-100">Ajouter un rendez-vous</a>
        
    </div>
</div>
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>

</html>
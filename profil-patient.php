<?php
include 'models/database.php';
include 'controllers/profil-patientCtl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Profil des patients</title>
</head>

<body class="container">
    <?php include 'navbar2.php'; ?>

    <div class="row justify-content-center">
        <h1 class="text-center col-md-12 mt-3 mb-3">Profil patient</h1>
    </div>
        <!-- Tableau pour récupérer le profil complet d'un patient -->
        <table class="col-md-12 table table-hover">
            <thead>
                <tr class="table-active">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Numéro de téléphone</th>
                    <th>Email</th>
                    <th>Identifiant</th>
                </tr>
            </thead>
            <tbody>
                <!-- On affiche toutes les informations d'un patients en appelant la variable $profilList 
                        qui contient la méthode  getProfilById dans la page controller profil-patientCtl.php) -->
                <tr class="table-light">
                    <td><?= $profilList->lastname ?></td>
                    <td><?= $profilList->firstname ?></td>
                    <td><?= $profilList->birthdate ?></td>
                    <td><?= $profilList->phone ?></td>
                    <td><?= $profilList->mail ?></td>
                    <td><?= $profilList->id ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php foreach ($appointmentList as $appointmentDetails) { ?>
        <tr>
            <td><?= $appointmentDetails->date ?></td>
            <td><?= $appointmentDetails->hour ?></td>
            <td><a href="rendezvous.php?id=<?= $appointmentDetails->id ?>" title="Modification du rendez-vous.">Modifier</a></td>
        </tr>
    <?php } ?>

    <div class="offset-2 col-md-8 mt-3">
        <form action="#" method="POST">
            <div class="form-group">
                <label for="lastname">Nom</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" value="<?= $profilList->lastname ?>" />
                <?php if (isset($formError['lastname'])) { ?>
                    <p class="text-danger"><?= isset($formError['lastname']) ? $formError['lastname'] : '' ?></p>
                <?php } ?>
                <label for="firstname">Prénom</label>
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" value="<?= $profilList->firstname ?>" />
                <?php if (isset($formError['firstname'])) { ?>
                    <p class="text-danger"><?= isset($formError['firstname']) ? $formError['firstname'] : '' ?></p>
                <?php } ?>
                <label for="birthDate">Date de naissance</label>
                <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?= $profilList->birthdate ?>" />
                <?php if (isset($formError['birthdate'])) { ?>
                    <p class="text-danger"><?= isset($formError['birthdate']) ? $formError['birthdate'] : '' ?></p>
                <?php } ?>
                <label for="mail">Adresse mail</label>
                <input type="text" class="form-control" name="mail" id="mail" placeholder="Adresse mail" value="<?= $profilList->mail ?>" />
                <?php if (isset($formError['mail'])) { ?>
                    <p class="text-danger"><?= isset($formError['mail']) ? $formError['mail'] : '' ?></p>
                <?php } ?>
                <label for="phone">Téléphone</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Téléphone" value="<?= $profilList->phone ?>" />
                <?php if (isset($formError['mail'])) { ?>
                    <p class="text-danger"><?= isset($formError['phone']) ? $formError['phone'] : '' ?></p>
                <?php } ?>
                <input type="submit" name="submit" id="submit" value="Valider" class="btn btn-primary btn-lg active w-100 mt-3" />
            </div>
        </form>
        <p class="text-danger"><?= isset($formError['submit']) ? $formError['submit'] : '' ?></p>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>
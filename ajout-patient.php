<?php
include 'models/database.php';
include 'controllers/addPatientCtl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <title>Ajout de patient</title>
    </head>
    <body id="addPatientView">
        <?php include 'controllers/controllerNavbar2.php'; ?>
        <!-- si les champs sont remplis et corrects, afficher les variables -->
        <?php if (isset($_POST['submit']) && (count($formError) === 0)) { ?> 
            <p id="ok">Les données ont été enregistrées</p>
            <p id="ok"><a href="ajout-patient.php" title="lien vers l'ajout de patient"><button type="button" class="btn btn-dark">AJOUTER UN NOUVEAU PATIENT</button></a></p>
        <?php } else { ?>   
            <div class="container">
                <div class="row">
                    <H1 class="col-md-12 text-center text-uppercase text-muted font-weight-bold">Ajout d'un patient</H1>
                </div>
                <div class="row">
                    <div id="formBox" class="offset-2 col-8 offset-2 ">
                        <form action="#" method="POST">
                            <div class="form-group add ">
                                <label for="lastname">Nom</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" <?= isset($lastname) ? 'value="' . $lastname . '"' : '' ?>/>
                                <?php if (isset($formError['lastname'])) { ?>
                                    <p class="text-danger"><?= $formError['lastname']; ?></p>
                                <?php } ?>
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" <?= isset($firstname) ? 'value="' . $firstname . '"' : '' ?>/>
                                <?php if (isset($formError['firstname'])) { ?>
                                    <p class="text-danger"><?= isset($formError['firstname']) ? $formError['firstname'] : '' ?></p>
                                <?php } ?>
                                <label for="birthdate">Date de naissance</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate"<?= isset($birthdate) ? 'value="' . $birthdate . '"' : '' ?>/>
                                <?php if (isset($formError['birthdate'])) { ?>
                                    <p class="text-danger"><?= isset($formError['birthdate']) ? $formError['birthdate'] : '' ?></p>
                                <?php } ?>
                                <label for="mail">Adresse mail</label>
                                <input type="text" class="form-control" name="mail" id="mail" placeholder="Adresse mail" <?= isset($mail) ? 'value="' . $mail . '"' : '' ?>/>
                                <?php if (isset($formError['mail'])) { ?>
                                    <p class="text-danger"><?= isset($formError['mail']) ? $formError['mail'] : '' ?></p>
                                <?php } ?>
                                <label for="phone">Téléphone</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Téléphone" <?= isset($phone) ? 'value="' . $phone . '"' : '' ?>/>
                                <?php if (isset($formError['mail'])) { ?>
                                    <p class="text-danger"><?= isset($formError['phone']) ? $formError['phone'] : '' ?></p>
                                <?php } ?>
                                <input type="submit" name="submit" id="submit" value="VALIDATION"/>
                            </div> 
                        </form>
                        <p class="text-danger"><?= isset($formError['submit']) ? $formError['submit'] : '' ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </body>
</html>

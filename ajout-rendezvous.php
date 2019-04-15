<?php
include 'models/database.php';
include 'models/patients.php';
include 'controllers/controlAjoutRdvForm.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css" />
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <title>Creation d'un rendez-vous</title>
    </head>
    <body class="patient">
        <?php include 'controllers/controllerNavbar2.php'; ?> 
        <?php if (isset($_POST['submit']) && (count($formError) === 0)) { ?>
            <p class="paragraphe">Votre rendez-vous a bien été enregistré.</p>
        <?php } else { ?>
            <div class="container">
                <H1 class="col-md-12 text-center text-uppercase text-muted font-weight-bold">Ajout d'un rendez-vous</H1>
                <div class="row">
                    <div class="form offset-2 col-8 offset-2">
                        <form action="ajout-rendezvous.php" method="POST">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect">Patients</label>
                                <select name="patients" class="custom-select" id="inputGroupSelect">
                                    <option selected disabled>veuillez choisir un patient---</option>
                                    <?php foreach ($patientsList as $patientsDetail) { ?>
                                        <option value="<?= $patientsDetail->id ?>"><?= $patientsDetail->firstname . ' ' . $patientsDetail->lastname ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label for="dateApp">date</label>
                            <input class="form-control" id="dateApp" type="date" name="dateApp"/>
                            <?php if (isset($formError['dateApp'])) { ?>
                                <p class="text-danger"><?= isset($formError['dateApp']) ? $formError['dateApp'] : '' ?></p>
                            <?php } ?>
                            <label for="hourApp">Heure</label>
                            <input class="form-control" id="hourApp" type="time" name="hourApp"/>
                            <?php if (isset($formError['hourApp'])) { ?>
                                <p class="text-danger"><?= isset($formError['hourApp']) ? $formError['hourApp'] : '' ?></p>
                            <?php } ?>
                            <input type="submit" name="submit" value="Envoyer !" />
                        </form>
                        <a href="ajout-patient.php">ajout de patient</a>
                    </div>
                </div>
            </div>
            <?php
        }
        if (isset($formError['submit'])) {
            ?>
            <p><?= $formError['submit'] ?></p>
        <?php } ?>
    </body>
</html>
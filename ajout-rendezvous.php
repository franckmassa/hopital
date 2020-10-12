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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Creation d'un rendez-vous</title>
</head>

<body class="container">
    <?php include 'navbar2.php'; ?>
        <div class="row justify-content-center">
            <h1 class="text-center col-md-12 mt-3 mb-3">Ajouter un rendez-vous</h1>
        </div>
    <?php if (isset($_POST['submit']) && (count($formError) === 0)) { ?>
        <p class="paragraphe">Votre rendez-vous a bien été enregistré.</p>
    <?php } else { ?>
        <div class="container-fluid">
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
                        <input class="form-control" id="dateApp" type="date" name="dateApp" />
                        <?php if (isset($formError['dateApp'])) { ?>
                            <p class="text-danger"><?= isset($formError['dateApp']) ? $formError['dateApp'] : '' ?></p>
                        <?php } ?>
                        <label for="hourApp">Heure</label>
                        <input class="form-control" id="hourApp" type="time" name="hourApp" />
                        <?php if (isset($formError['hourApp'])) { ?>
                            <p class="text-danger"><?= isset($formError['hourApp']) ? $formError['hourApp'] : '' ?></p>
                        <?php } ?>
                        <input type="submit" name="submit" value="Valider" class="btn btn-primary btn-lg active w-100 mt-3"/>
                    </form>
                    <div class="mt-3">
                        <a href="ajout-patient.php" class="btn btn-dark btn-lg active w-100">Ajouter un patient</a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    if (isset($formError['submit'])) {
    ?>
        <p><?= $formError['submit'] ?></p>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>
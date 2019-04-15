<?php
include 'models/database.php';
include 'controllers/infoAppointment.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="assets/css/style.css" />
        <title>Liste des rendez-vous</title>
    </head>
    <body>
        <h1 class="paragraphe">Rendez-vous patient</h1>
        <?php if (isset($_POST['submit']) && (count($formError) === 0)) { ?>
            <p class="paragraphe">Votre rendez-vous a bien été enregistré.</p>
        <?php } else { ?>
            <div class="container">
                <div class="row">
                    <div class="form offset-2 col-8 offset-2">
                        <form action="rendezvous.php?id=<?= $appointment->id ?>" method="POST">
                            <div class="input-group-prepend">
                            </div>
                            <label for="dateApp">date</label>
                            <input class="form-control" id="dateApp" type="date" name="dateApp" value="<?= $showAppointment->date ?>"/>
                            <?php if (isset($formError['dateApp'])) { ?>
                                <p class="text-danger"><?= isset($formError['dateApp']) ? $formError['dateApp'] : '' ?></p>
                            <?php } ?>
                            <label for="hourApp">Heure</label>
                            <input class="form-control" id="hourApp" type="time" name="hourApp" value="<?= $showAppointment->hour ?>"/>
                            <?php if (isset($formError['hourApp'])) { ?>
                                <p class="text-danger"><?= isset($formError['hourApp']) ? $formError['hourApp'] : '' ?></p>
                            <?php } ?>
                            <select name="patient">
                                <option selected disabled>Veuillez selectionner un patient</option>
                                <?php
                                foreach ($patientsList as $patientDetails) {
                                    ?>
                                <option value="<?= $patientDetails->id ?>" <?= $patientDetails->id == $showAppointment->idPatients ? 'selected' : '' ?>><?= $patientDetails->lastname . ' ' . $patientDetails->firstname ?></option>
                                    <?php
                                }
                                ?>
                            </select>
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

<?php

function actionReservation($twig, $db) {
    $form = array();
    $reservation = new Reservation($db);
    if (isset($_GET['idRes'])) {
        $exec = $reservation->delete($_GET['idRes']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Réservation supprimé avec succès';
        }
    }
    if (isset($_GET['idTri'])) {
        if ($_GET['idTri'] == 1) {
            $reservation = new Reservation($db);
            $liste = $reservation->selectOrderByIdRes();
        } else if ($_GET['idTri'] == 2) {
            $reservation = new Reservation($db);
            $liste = $reservation->selectOrderByTitre();
        } else if ($_GET['idTri'] == 3) {
            $reservation = new Reservation($db);
            $liste = $reservation->selectOrderByUti();
        } else if ($_GET['idTri'] == 4) {
            $reservation = new Reservation($db);
            $liste = $reservation->selectOrderByDateRes();
        } else if ($_GET['idTri'] == NULL) {
            $reservation = new Reservation($db);
            $liste = $reservation->select();
        }
    } else {
        $liste = $reservation->select();
    }
    echo $twig->render('reservation.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionMesReservation($twig, $db) {
    $form = array();
    if (isset($_GET['idU'])) {
        $reservation = new Reservation($db);
        $idU = $_GET['idU'];
        $form['idUti'] = $idU;
        $mesReservations = $reservation->selectMesReservations($_GET['idU']);
        if ($mesReservations != null) {
            $form['reservation'] = $mesReservations;
        } else {
            $form['valide'] = false;
        }
    } else {
        $form['valide'] = false;
        $form['message'] = 'Utilisateur non renseigné';
    }
    if (isset($_POST['btSupprimer'])) {
        $limite = 10;
        $livre = new Livre($db);
        $idLivre = $_POST['idLivre'];
        $unLivre = $livre->selectNbLivre($idLivre);
        $testLivreRes = $unLivre['nbLivreDispo'];
        $testNbLivre = $testLivreRes + 1;
        if ($testNbLivre > $limite) {
            $form['valide'] = true;
            $form['message'] = 'Votre livre a été retiré des réservations avec succès';
            $idLivre = $_POST['idLivre'];
            $unLivre = $livre->selectNbLivre($idLivre);
            $idDispo = 1;
            $nbLivreRestant = $unLivre['nbLivreDispo'];
            $nbLivre = $nbLivreRestant + 1;
            $idRes = $_POST['idRes'];
            $exec = $livre->replace($nbLivre, $idLivre);
            $exec = $livre->replaceDispo($idDispo, $idLivre);
            $exec = $reservation->delete($idRes);
        } else if ($testNbLivre <= $limite & $testNbLivre != 0) {
            $form['valide'] = true;
            $form['message'] = 'Votre livre a été retiré des réservations avec succès';
            $idLivre = $_POST['idLivre'];
            $unLivre = $livre->selectNbLivre($idLivre);
            $idDispo = 2;
            $nbLivreRestant = $unLivre['nbLivreDispo'];
            $nbLivre = $nbLivreRestant + 1;
            $idRes = $_POST['idRes'];
            $exec = $livre->replace($nbLivre, $idLivre);
            $exec = $livre->replaceDispo($idDispo, $idLivre);
            $exec = $reservation->delete($idRes);
        } else if ($testNbLivre == 0) {
            $form['valide'] = true;
            $form['message'] = 'Votre livre a été retiré des réservations avec succès';
            $idLivre = $_POST['idLivre'];
            $unLivre = $livre->selectNbLivre($idLivre);
            $idDispo = 3;
            $nbLivreRestant = $unLivre['nbLivreDispo'];
            $nbLivre = $nbLivreRestant + 1;
            $idRes = $_POST['idRes'];
            $exec = $livre->replace($nbLivre, $idLivre);
            $exec = $livre->replaceDispo($idDispo, $idLivre);
            $exec = $reservation->delete($idRes);
        }
    }

    $reservation = new Reservation($db);
    $liste = $reservation->select();
    $form['mesRes'] = $liste;
    echo $twig->render('mesReservations.html.twig', array('form' => $form));
}

?>

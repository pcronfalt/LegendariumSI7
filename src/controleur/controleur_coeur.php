<?php

function actionMesCoupsCoeurs($twig, $db) {
    $form = array();
    if (isset($_GET['idU'])) {
        $coeur = new Coeur($db);
        $idU = $_GET['idU'];
        $form['idUti'] = $idU;
        $mesCoeurs = $coeur->selectMesCc($_GET['idU']);
        if ($mesCoeurs != null) {
            $form['coeur'] = $mesCoeurs;
        } else {
            $form['valide'] = false;
        }
    } else {
        $form['valide'] = false;
        $form['message'] = 'Utilisateur non renseigné';
    }
    if (isset($_POST['btSupprimer'])) {
        $form['valide'] = true;
        $form['message'] = 'Votre livre a été retiré des coups de coeurs avec succès';
        $idLivre = $_POST['idLivre'];
        $idCc = $_POST['idCc'];
        $exec = $coeur->delete($idCc);
    }
    $coeur = new Coeur($db);
    $liste = $coeur->select();
    $form['mesCc'] = $liste;
    echo $twig->render('mesCoupsCoeurs.html.twig', array('form' => $form));
}

?>

<?php

function actionAccueil($twig, $db) {
    $form = array();
    $actualite = new Actualite($db);
    $r = $actualite->selectCount();
    $nb = $r['nb'];
    $form['nbActu'] = $nb;
    $liste = $actualite->select();
    echo $twig->render('index.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionRedirection($twig) {
    echo $twig->render('redirection.html.twig', array());
}

function actionApropos($twig) {
    $form = array();
    echo $twig->render('apropos.html.twig', array('form' => $form));
}

function actionConnexion($twig, $db) {
    $form = array();
    if (isset($_POST['btConnecter'])) {
        $form['valide'] = true;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $utilisateur = new Utilisateur($db);
        $unUti = $utilisateur->connect($email);
        if ($unUti != null) {
            if (!password_verify($password, $unUti['mdp'])) {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            } else {
                $_SESSION['login'] = $email;
                $_SESSION['role'] = $unUti['idRole'];
                $_SESSION['idUtilisateur'] = $unUti['idUtilisateur'];
                $_SESSION['nom'] = $unUti['nom'];
                $_SESSION['prenom'] = $unUti['prenom'];
                $_SESSION['pseudoJdr'] = $unUti['pseudoJdr'];
                $_SESSION['jeuP'] = $unUti['jdrPartic'];
                $_SESSION['date'] = $unUti['dateNaiss'];
                header("Location:index.php");
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    echo $twig->render('connexion.html.twig', array('form' => $form));
}

function actionMentionLegale($twig) {
    echo $twig->render('mentionlegale.html.twig', array());
}

function actionDeconnexion($twig) {
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionInscrire($twig, $db) {
    $form = array();
    if (isset($_POST['btInscrire'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $nom = $_POST['Nom'];
        $prenom = $_POST['Prenom'];
        $role = 2;
        $dateNaiss = $_POST['dateNaiss'];



        $form['valide'] = true;

        if ($password != $password2) {
            $form['valide'] = false;
            $form['message'] = "Les mot de passe sont différents";
        } else {
            $utilisateur = new Utilisateur($db);
            $exec = $utilisateur->insert($email, password_hash($password, PASSWORD_DEFAULT), $role, $nom, $prenom, $dateNaiss);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
            }
        }
        $form['email'] = $email;
        $form['role'] = $role;
    }
    echo $twig->render('inscrire.html.twig', array('form' => $form));
}

function actionMaintenance($twig) {

    echo $twig->render('maintenance.html.twig', array());
}

function actionEvent($twig, $db) {
    $form = array();
    if (isset($_GET['idActu'])) {
        $actualite = new Actualite($db);
        $unActu = $actualite->selectById($_GET['idActu']);
        if ($unActu != null) {
            $form['valide'] = true;
            $form['actu'] = $unActu;
        } else {
            $form['valide'] = false;
            $form['message'] = 'Actualité incorrect';
        }
    }
    $liste = $actualite->select();
    echo $twig->render('event.html.twig', array('form' => $form, 'liste' => $liste));
}

?>

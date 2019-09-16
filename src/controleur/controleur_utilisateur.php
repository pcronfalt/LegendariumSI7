<?php

function actionUtilisateur($twig, $db) {
    $form = array();
    $utilisateur = new Utilisateur($db);
    $limite = 5;
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $r = $utilisateur->selectCount();
    $nb = $r['nb'];
    $form['nbpages'] = ceil($nb / $limite);
    $liste = $utilisateur->selectLimit($inf, $limite);
    echo $twig->render('utilisateur.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionGestionCompte($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        $form['message'] = 'Utilisateur non précisé';
    }
    $utilisateur = new Utilisateur($db);
    $unUtilisateur = $utilisateur->connect($_SESSION['login']);
    if ($unUtilisateur != null) {
        $_SESSION['login'] = $unUtilisateur['email'];
        $_SESSION['role'] = $unUtilisateur['idRole'];
        $_SESSION['idUtilisateur'] = $unUtilisateur['idUtilisateur'];
        $_SESSION['nom'] = $unUtilisateur['nom'];
        $_SESSION['prenom'] = $unUtilisateur['prenom'];
        $_SESSION['pseudoJdr'] = $unUtilisateur['pseudoJdr'];
        $_SESSION['jeuP'] = $unUtilisateur['jdrPartic'];
    }
    echo $twig->render('gestionCompte.html.twig', array('form' => $form));
}

function actionModifEmail($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        if (isset($_POST['btModifier'])) {
            $email = $_POST['email'];
            $email2 = $_POST['email2'];
            $utilisateur = new Utilisateur($db);
            $unUtilisateur = $utilisateur->selectByEmail($email);
            if ($_POST['email'] != $_POST['email2']) {
                $form['valide'] = false;
                $form['message'] = "Les email sont différents";
            } elseif ($email = $unUtilisateur) {
                $form['valide3'] = false;
                $form['message'] = 'L\'email existe déjà';
            } else {
                $utilisateur = new Utilisateur($db);
                $email = $_POST['email'];
                $idUtilisateur = $_POST['idUtilisateur'];
                $exec = $utilisateur->updateEmail($email, $idUtilisateur);
                $unUtilisateur = $utilisateur->connectId($_SESSION['idUtilisateur']);
                if ($unUtilisateur != null) {
                    $_SESSION['login'] = $unUtilisateur['email'];
                    $_SESSION['role'] = $unUtilisateur['idRole'];
                    $_SESSION['idUtilisateur'] = $unUtilisateur['idUtilisateur'];
                    $_SESSION['nom'] = $unUtilisateur['nom'];
                    $_SESSION['prenom'] = $unUtilisateur['prenom'];
                    $_SESSION['pseudoJdr'] = $unUtilisateur['pseudoJdr'];
                    $_SESSION['jeuP'] = $unUtilisateur['jdrPartic'];
                }
                $form['valide2'] = true;
                $form['message'] = "Modification réussie !";
            }
        } else {
            $form['message'] = 'Utilisateur non précisé';
        }
    }
    echo $twig->render('modifEmail.html.twig', array('form' => $form));
}

function actionModifMdp($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        if (isset($_POST['btModifier'])) {
            $mdp = $_POST['mdp'];
            $mdp2 = $_POST['mdp2'];
            if ($mdp != $mdp2) {
                $form['valide'] = false;
                $form['message'] = "Les mots de passes sont différents";
            } else {
                $form['valide'] = true;
                $form['message'] = "Modification reussi";
                $utilisateur = new Utilisateur($db);
                $mdp = $_POST['mdp'];
                $idUtilisateur = $_POST['idUtilisateur'];
                $exec = $utilisateur->updateMdp(password_hash($mdp, PASSWORD_DEFAULT), $idUtilisateur);
            }
        } else {
            $form['message'] = 'Utilisateur non précisé';
        }
    }
    echo $twig->render('modifMdp.html.twig', array('form' => $form));
}

function actionModifNom($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        if (isset($_POST['btModifier'])) {
            $form['valide'] = true;
            $form['message'] = "Modification reussi !";
            $utilisateur = new Utilisateur($db);
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $idUtilisateur = $_POST['idUtilisateur'];
            $exec = $utilisateur->updateNom($nom, $prenom, $idUtilisateur);
        } else {
            $form['message'] = 'Utilisateur non précisé';
        }
    }
    echo $twig->render('modifNom.html.twig', array('form' => $form));
}

function actionModifRole($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $role = new Role($db);
            $form['utilisateur'] = $unUtilisateur;
            $form['role'] = $role->select();
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    }
    if (isset($_POST['btModifierR'])) {
        $utilisateur = new Utilisateur($db);
        $idRole = $_POST['idRole'];
        $email = $_POST['email'];
        $exec = $utilisateur->updateRole($email, $idRole);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }
    echo $twig->render('role-modif.html.twig', array('form' => $form));
}

?>

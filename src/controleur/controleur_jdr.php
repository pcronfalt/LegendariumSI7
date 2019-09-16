<?php

function actionIndexJdr($twig, $db) {
    $form = array();
    $utilisateur = new Utilisateur($db);
    $user = $_SESSION['date'];
    $zelda = new DateTime($user);
    $now = new DateTime();
    $diff = $now->diff($zelda);
    $age = $diff->y;
    $form['age'] = $age;
    if (isset($_POST['btInscrire'])) {
        $email = $_POST['email'];
        $password = $_POST['mdp'];
        $unUtilisateur = $utilisateur->connect($email);
        if ($unUtilisateur != null) {
            if (!password_verify($password, $unUtilisateur['mdp'])) {
                $form['valide'] = false;
                $form['message'] = 'Mot de passe incorrect';
            } else {
                $pseudo = $_POST['pseudo'];
                $exec = $utilisateur->insertJdr($pseudo, $email);
                if (!$exec) {
                    $form['valide'] = false;
                    $form['message'] = 'Échec de l\'inscription';
                } else {
                    $form['valide'] = true;
                    $form['message'] = 'Inscription réussie';
                }
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Utilisateur incorrect';
        }
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

    echo $twig->render('indexJdr.html.twig', array('form' => $form));
}

function actionIndexMj($twig, $db) {
    $form = array();
    $user = $_SESSION['date'];
    $zelda = new DateTime($user);
    $now = new DateTime();
    $diff = $now->diff($zelda);
    $age = $diff->y;
    $form['age'] = $age;
    if (isset($_GET['mj'])) {
        $jdr = new Jdr($db);
        $mesJdr = $jdr->selectByMj($_GET['mj']);
        $mj = $_GET['mj'];
        $form['mj'] = $mj;
        if ($mesJdr != null) {
            $form['mesJdr'] = $mesJdr;
        } else {
            $form['valide'] = false;
        }
        if (isset($_GET['idJdr'])) {
            $unJdr = $jdr->selectById($_GET['idJdr']);
            $form['unJdr'] = $unJdr;
        }
    } else {
        $form['valide'] = false;
        $form['message'] = 'Utilisateur non renseigné';
    }
    if (isset($_POST['btSupp'])) {
        $idJ = $_POST['idJ'];
        $idG = $_POST['idG'];
        $jdr = new Jdr($db);
        $exec = $jdr->delete($idJ);
        $jeu = new Jeu($db);
        $exec = $jeu->delete($idG);
        if (!$exec) {
            $form['valide4'] = false;
            $form['message'] = 'Erreur de suppression';
        } else {
            $form['valide4'] = true;
            $form['message'] = 'Suppression réussi !';
        }
    }
    $jdr = new Jdr($db);
    $liste = $jdr->select();
    $form['jdr'] = $liste;
    $utilisateur = new Utilisateur($db);
    $liste = $utilisateur->select();
    echo $twig->render('indexMj.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionIndexJ($twig, $db) {
    $form = array();
    $jdr = new Jdr($db);
    if (isset($_GET['idJdr'])) {
        $unJdr = $jdr->selectById($_GET['idJdr']);
        if ($unJdr != null) {
            $form['leJdr'] = $unJdr;
        } else {
            $form['valide'] = false;
            $form['message'] = 'Livre inconnu';
        }
    }
    if (isset($_POST['btInsc'])) {
        $user = $_SESSION['date'];
        $zelda = new DateTime($user);
        $now = new DateTime();
        $diff = $now->diff($zelda);
        $age = $diff->y;
        if ($age < 16) {
            $form['valide4'] = false;
            $form['message'] = 'L\'âge minimum pour participer au JDR est de 16 ans.';
        } else {
            $idJ = $_POST['idJeu'];
            $nbJoueur = $jdr->selectNbJoueur($idJ);
            $nbJoueurRes = $nbJoueur['nbJoueur'];
            $nbJ = $nbJoueurRes + 1;
            $idUti = $_SESSION['idUtilisateur'];
            $exec = $jdr->update($nbJ, $idJ);
            $utilisateur = new Utilisateur($db);
            $exec = $utilisateur->updateJeu($idJ, $idUti);
            if (!$exec) {
                $form['valide2'] = false;
                $form['message'] = 'Erreur d\'inscription';
            } else {
                $form['valide2'] = true;
                $form['message'] = 'Inscription réussie !';
            }
        }
    }
    if (isset($_POST['btDesin'])) {
        $idJ = $_POST['idJeu'];
        $nbJoueur = $jdr->selectNbJoueur($idJ);
        $nbJoueurRes = $nbJoueur['nbJoueur'];
        $nbJ = $nbJoueurRes - 1;
        $idUti = $_SESSION['idUtilisateur'];
        $exec = $jdr->update($nbJ, $idJ);
        $utilisateur = new Utilisateur($db);
        $exec = $utilisateur->updateJeuDes($idUti);
        if (!$exec) {
            $form['valide3'] = false;
            $form['message'] = 'Erreur lors de la désinscription';
        } else {
            $form['valide3'] = true;
            $form['message'] = 'Désinscription réussie !';
        }
    }

    $liste = $jdr->select();
    $form['jdr'] = $liste;
    if ($_SESSION) {
        $liste = $jdr->selectById($_SESSION['jeuP']);
        $form['jeuP'] = $liste;
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
    }
    echo $twig->render('indexJ.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionCreaJdr($twig, $db) {
    $form = array();
    $user = $_SESSION['date'];
    $zelda = new DateTime($user);
    $now = new DateTime();
    $diff = $now->diff($zelda);
    $age = $diff->y;
    $form['age'] = $age;
    if (isset($_POST['btCr'])) {
        $nom = $_POST['nomJeu'];
        $duree = $_POST['dureeSess'];
        $desc = $_POST['descJeu'];
        $regle = $_POST['regleJeu'];
        $illustration = NULL;
        if (isset($_FILES['illustration'])) {
            if (!empty($_FILES['illustration']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '../web/images/';
                if (!in_array(substr(strrchr($_FILES['illustration']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['illustration']['tmp_name']) && (filesize($_FILES['illustration']['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $illustration = basename($_FILES['illustration']['name']);
                        // enlever les accents              
                        $illustration = strtr($illustration, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $illustration = preg_replace('/([^.a-z0-9]+)/i', '_', $illustration);
                        // copie du fichier

                        move_uploaded_file($_FILES['illustration']['tmp_name'], $dest_dossier . $illustration);
                    }
                }
            }
        }
        $telMj = $_POST['telMj'];
        $syno = $_POST['syno'];
        $fournis = $_POST['fournis'];
        $date = $_POST['date'];
        $email = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $jeu = new Jeu($db);
        $exec = $jeu->insert($nom, $duree, $desc, $regle, $illustration);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Echec d\'ajout, votre image fait plus de 500ko';
        } else {
            $r = $jeu->selectIdjeu();
            $id = $r['nb'];
            $jdr = new Jdr($db);
            $exec = $jdr->insert($pseudo, $email, $telMj, $syno, $fournis, $date, $id);
            $form['valide'] = true;
            $form['message'] = 'Ajout réussi';
        }
    }
    echo $twig->render('creaJdr.html.twig', array('form' => $form));
}

function actionJdrA($twig, $db) {
    $form = array();
    $jdr = new Jdr($db);
    if (isset($_GET['id'])) {
        $unJdr = $jdr->selectById($_GET['id']);
        if ($unJdr != null) {
            $form['valide'] = true;
            $form['jdr'] = $unJdr;
        } else {
            $form['valide'] = false;
            $form['message'] = 'Livre inconnu';
        }
    }
    if (isset($_GET['idJdr'])) {
        if (isset($_GET['valider'])) {
            if ($_GET['valider'] == 1) {
                $id = $_GET['idJdr'];
                $jdr->valideById($id);
            } else {
                $jdr->refuseById($_GET['idJdr']);
            }
        }
    }
    $liste = $jdr->select();
    $utilisateur = new Utilisateur($db);
    $form['uti'] = $utilisateur->select();
    ;
    echo $twig->render('jdrA.html.twig', array('form' => $form, 'liste' => $liste));
}

?>
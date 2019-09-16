<?php

function actionActualite($twig, $db) {
    $form = array();
    $actualite = new Actualite($db);

    if (isset($_POST['btSupprimer'])) {
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ($cocher as $idActu) {
            $exec = $actualite->delete($idActu);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table produit';
            }
        }
    }
    if (isset($_GET['idActu'])) {
        $exec = $actualite->delete($_GET['idActu']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table produit';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Produit supprimé avec succès';
        }
    }

    if (isset($_POST['btAjouterA'])) {
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $date = $_POST['date'];
        $photo = NULL;
        if (isset($_FILES['photo'])) {
            if (!empty($_FILES['photo']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '../web/images/';
                if (!in_array(substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo']
                                    ['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $photo = basename($_FILES['photo']['name']);
                        // enlever les accents              
                        $photo = strtr($photo, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        // copie du fichier
                        move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier . $photo);
                    }
                }
            } else {
                $photo = $_POST['photoBd'];
            }
        }
        $exec = $actualite->insert($titre, $contenu, $date, $photo);
    }
    $liste = $actualite->select();
    echo $twig->render('actualite.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionModifActualite($twig, $db) {
    $form = array();
    if (isset($_GET['idActu'])) {
        $actualite = new Actualite($db);
        $unActualite = $actualite->selectById($_GET['idActu']);
        if ($unActualite != null) {
            $form['valide'] = true;
            $form['actualite'] = $unActualite;
            $form['message'] = 'Ouais';
        } else {
            $form['valide'] = false;
            $form['message'] = 'Actualité incorrect';
        }
    }
    if (isset($_POST['btModifier'])) {
        $actualite = new Actualite($db);
        $idActu = $_POST['idActu'];
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $date = $_POST['date'];
        $photo = NULL;
        if (isset($_FILES['photo'])) {
            if (!empty($_FILES['photo']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '../web/images/';
                if (!in_array(substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo']
                                    ['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $photo = basename($_FILES['photo']['name']);
                        // enlever les accents              
                        $photo = strtr($photo, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        // copie du fichier
                        move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier . $photo);
                    }
                }
            } else {
                $photo = $_POST['photoBd'];
            }
        }
        $exec = $actualite->update($idActu, $titre, $contenu, $date, $photo);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    echo $twig->render('actu-modif.html.twig', array('form' => $form));
}
?>


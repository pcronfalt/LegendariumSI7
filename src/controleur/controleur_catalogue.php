<?php

function actionCatalogue($twig, $db) {
    $form = array();
    $form['valide'] = true;
    $livre = new Livre($db);
    $genre = new Genre($db);
    $liste = $genre->select();
    $form['genre'] = $liste;
    if (isset($_GET['idTri'])) {
        $form['numTri'] = $_GET['idTri'];
        $limite = 3;
        if (!isset($_GET['nopage'])) {
            $inf = 0;
            $nopage = 0;
        } else {
            $nopage = $_GET['nopage'];
            $inf = $nopage * $limite;
        }
        $r = $livre->selectCount();
        $nb = $r['nb'];
        $form['nbpages'] = ceil($nb / $limite); //affichage 3 livres par page

        if ($_GET['idTri'] == 1) {
            $livre = new Livre($db);
            $liste = $livre->selectOrderByTitre($inf, $limite);
        } else if ($_GET['idTri'] == 2) {
            $livre = new Livre($db);
            $liste = $livre->selectOrderByDateSortie($inf, $limite);
        } else if ($_GET['idTri'] == 3) {
            $livre = new Livre($db);
            $liste = $livre->selectOrderByPrixD($inf, $limite);
        } else if ($_GET['idTri'] == 4) {
            $livre = new Livre($db);
            $liste = $livre->selectOrderByPrixC($inf, $limite);
        } else if ($_GET['idTri'] == 5) {
            $livre = new Livre($db);
            $liste = $livre->selectOrderByDispo($inf, $limite);
        } else if ($_GET['idTri'] == NULL) {
            $livre = new Livre($db);
            $liste = $livre->selectLimit($inf, $limite);
        }//permet de trier les livre du catalogue 
    } else if (isset($_GET['idG'])) {
        $livre = new Livre($db);
        $idG = $_GET['idG'];
        $limite = 3;
        if (!isset($_GET['nopage'])) {
            $inf = 0;
            $nopage = 0;
        } else {
            $nopage = $_GET['nopage'];
            $inf = $nopage * $limite;
        }
        $r = $livre->selectCountGenre($idG);
        $nb = $r['nb'];
        $form['nbpages'] = ceil($nb / $limite);
        $form['idG'] = $idG;
        if ($nb == 0) {
            $form['valide'] = false;
        } else {
            $liste = $livre->selectByGenre($inf, $limite, $idG);
        }
    } else {
        $limite = 3;
        if (!isset($_GET['nopage'])) {
            $inf = 0;
            $nopage = 0;
        } else {
            $nopage = $_GET['nopage'];
            $inf = $nopage * $limite;
        }
        $r = $livre->selectCount();
        $nb = $r['nb'];
        $form['nbpages'] = ceil($nb / $limite);
        $liste = $livre->selectLimit($inf, $limite);
    }//permet de trier par genre(avec pagination)
    if (isset($_POST['btSearch'])) {
        $livre = new Livre($db);
        $search = $_POST['search'];
        $liste = $livre->search($search);
        if (!$liste) {
            $form['valide'] = false;
        } else {
            $form['valide'] = true;
        }
    }//rechercher un livre par rapport a son nom
    echo $twig->render('catalogue.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionCatalogueA($twig, $db) {
    $form = array();
    $livre = new Livre($db);
    if (isset($_POST['btSupprimer'])) {
        if (isset($_POST['cocher'])) {
            $cocher = $_POST['cocher'];
            $form['valide'] = true;
            $form['message'] = 'Les livres ont correctement été supprimés.';
            foreach ($cocher as $id) {
                $exec = $livre->delete($id);
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression. Aucune case chochée.';
        }
    }
    if (isset($_GET['idLivre'])) {
        $exec = $livre->delete($_GET['idLivre']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table livre';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Livre supprimé avec succès';
        }
    }//permet de supprimer livre du catalogue

    $limite = 5;
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $r = $livre->selectCount();
    $nb = $r['nb'];
    $form['nbpages'] = ceil($nb / $limite);
    //limite de l'affichage de la gestion du catalogue
    $livre = new Livre($db);
    $liste = $livre->select();
    $form['livre'] = $liste;
    $auteur = new Auteur($db);
    $liste = $auteur->select();
    $form['auteur'] = $liste;
    $genre = new Genre($db);
    $liste = $genre->select();
    $form['genre'] = $liste;
    $editeur = new Editeur($db);
    $liste = $editeur->select();
    $form['editeur'] = $liste;
    $categorie = new Categorie($db);
    $liste = $categorie->select();
    $form['categorie'] = $liste;
    if (isset($_POST['btAjouter'])) {
        $titre = $_POST['titre'];
        $idGenre = $_POST['idGenre'];
        $isbn = $_POST['isbn'];
        $dateSortie = $_POST['dateSortie'];
        $resume = $_POST['resume'];
        $couverture = NULL;
        if (isset($_FILES['couverture'])) {
            if (!empty($_FILES['couverture']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '../web/images/';
                if (!in_array(substr(strrchr($_FILES['couverture']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['couverture']['tmp_name']) && (filesize($_FILES['couverture']['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $couverture = basename($_FILES['couverture']['name']);
                        // enlever les accents              
                        $couverture = strtr($couverture, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $couverture = preg_replace('/([^.a-z0-9]+)/i', '_', $couverture);
                        // copie du fichier
                        move_uploaded_file($_FILES['couverture']['tmp_name'], $dest_dossier . $couverture);
                    }
                }
            } else {
                $couverture = $_POST['couvertureBd'];
            }
        }
        $prix = $_POST['prix'];
        $idAuteur = $_POST['idAuteur'];
        $idEditeur = $_POST['idEditeur'];
        $idCat = $_POST['idCat'];
        $nbLivreDispo = $_POST['nbLivreDispo'];
        $limite = 10;
        if ($nbLivreDispo > $limite) {
            $idDispo = 1;
        } else if ($nbLivreDispo <= 10 & $nbLivreDispo != 0) {
            $idDispo = 2;
        } else if ($nbLivreDispo == 0) {
            $idDispo = 3;
        }
        $exec = $livre->insert($titre, $idGenre, $isbn, $dateSortie, $resume, $couverture, $prix, $idAuteur, $idEditeur, $idCat, $nbLivreDispo, $idDispo);
    }
    $liste = $livre->selectLimit($inf, $limite);
    echo $twig->render('catalogueA.html.twig', array('form' => $form, 'liste' => $liste));
}

//permet d'ajouter un livre au catalogue

function actionModifCatalogue($twig, $db) {
    $form = array();
    if (isset($_GET['idLivre'])) {
        $livre = new Livre($db);
        $unLivre = $livre->selectById($_GET['idLivre']);
        if ($unLivre != null) {
            $form['valide'] = true;
            $form['livre'] = $unLivre;
        } else {
            $form['valide'] = false;
            $form['message'] = 'Livre incorrect';
        }
    }
    $auteur = new Auteur($db);
    $liste = $auteur->select();
    $form['auteur'] = $liste;
    $genre = new Genre($db);
    $liste = $genre->select();
    $form['genre'] = $liste;
    $editeur = new Editeur($db);
    $liste = $editeur->select();
    $form['editeur'] = $liste;
    $categorie = new Categorie($db);
    $liste = $categorie->select();
    $form['categorie'] = $liste;
    $dispo = new Disponibilite($db);
    $liste = $dispo->select();
    $form['dispo'] = $liste;
    $livre = new Livre($db);
    $liste = $livre->select();
    $form['couverture'] = $liste;
    if (isset($_POST['btModifier'])) {
        $livre = new Livre($db);
        $idLivre = $_POST['idLivre'];
        $titre = $_POST['titre'];
        $idGenre = $_POST['idGenre'];
        $idAuteur = $_POST['idAuteur'];
        $isbn = $_POST['isbn'];
        $dateSortie = $_POST['dateSortie'];
        $resume = $_POST['resume'];
        $couverture = NULL;
        if (isset($_FILES['couverture'])) {
            if (!empty($_FILES['couverture']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '../web/images/';
                if (!in_array(substr(strrchr($_FILES['couverture']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['couverture']['tmp_name']) && (filesize($_FILES['couverture']['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $couverture = basename($_FILES['couverture']['name']);
                        // enlever les accents              
                        $couverture = strtr($couverture, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $couverture = preg_replace('/([^.a-z0-9]+)/i', '_', $couverture);
                        // copie du fichier
                        move_uploaded_file($_FILES['couverture']['tmp_name'], $dest_dossier . $couverture);
                    }
                }
            } else {
                $couverture = $_POST['couvertureBd'];
            }
        }
        $prix = $_POST['prix'];
        $idEditeur = $_POST['idEditeur'];
        $idCat = $_POST['idCat'];
        $nbLivreDispo = $_POST['nbLivreDispo'];
        $limite = 10;
        if ($nbLivreDispo > $limite) {
            $idDispo = 1;
        } else if ($nbLivreDispo <= 10 & $nbLivreDispo != 0) {
            $idDispo = 2;
        } else if ($nbLivreDispo == 0) {
            $idDispo = 3;
        }
        $exec = $livre->update($idLivre, $titre, $idGenre, $isbn, $dateSortie, $resume, $couverture, $prix, $idAuteur, $idEditeur, $idCat, $nbLivreDispo, $idDispo);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }
    echo $twig->render('catalogue-modif.html.twig', array('form' => $form));
}

//permet de modifier le catalogue

function actionLivreSelec($twig, $db) {
    $form = array();
    if (isset($_GET['idLivre'])) {
        $livre = new Livre($db);
        $unLivre = $livre->selectById($_GET['idLivre']);
        if ($unLivre != null) {
            $form['valide'] = true;
            $form['livre'] = $unLivre;
            $desLivres = $livre->selectMotcle($_GET['idLivre']);
            $form['desLivres'] = $desLivres;
        } else {
            $form['valide'] = false;
            $form['message'] = 'Livre inconnu';
        }
    } else {
        $form['valide'] = false;
        $form['message'] = 'Vous n\'avez pas sélectionné de livre';
    }//recuperer les informations du livre quand on clique dessus
    $reservation = new Reservation($db);
    $coeur = new Coeur($db);
    $form['valide'] = NULL;
    if (isset($_POST['btCc'])) {
        $idLivre = $_POST['idLivre'];
        $idUtilisateur = $_SESSION["idUtilisateur"];
        $exec = $coeur->insert($idLivre, $idUtilisateur);
        if (!$exec) {
            $form['valide'] = false;
        } else {
            $form['valide'] = true;
            $form['message'] = 'Votre coups de coeur a été ajouté';
        }
    }//ajout coup coeur
    if (isset($_POST['btReserver'])) {
        $livre = new Livre($db);
        $idLivre = $_POST['idLivre'];
        $liste = $livre ->selectById($idLivre);
        $disp = $liste['idDispo'];
        if ($disp == 3) {
            $form['valide'] = false;
            $form['message'] = 'CASSE TOI TOM';
        } else {
            $limite = 10;
            $livre = new Livre($db);
            $idLivre = $_POST['idLivre'];
            $unLivre = $livre->selectNbLivre($idLivre);
            $testLivreRes = $unLivre['nbLivreDispo'];
            $testNbLivre = $testLivreRes - 1;
            if ($testNbLivre > $limite) {
                $idLivre = $_POST['idLivre'];
                $idUtilisateur = $_SESSION['idUtilisateur'];
                $date = date("Y-m-d");
                $idDispo = 1;
                $unLivre = $livre->selectNbLivre($idLivre);
                $nbLivreRestant = $unLivre['nbLivreDispo'];
                $nbLivre = $nbLivreRestant - 1;
                $exec = $livre->replaceDispo($idDispo, $idLivre);
                $exec = $livre->replace($nbLivre, $idLivre);
                $exec = $reservation->insert($idLivre, $idUtilisateur, $date);
                if (!$exec) {
                    $form['valide'] = false;
                } else {
                    $form['valide'] = true;
                    $form['message'] = 'Votre réservation a été prise en compte';
                }
            } else if ($testNbLivre <= $limite & $testNbLivre != 0) {
                $idLivre = $_POST['idLivre'];
                $idUtilisateur = $_SESSION['idUtilisateur'];
                $date = date("Y-m-d");
                $unLivre = $livre->selectNbLivre($idLivre);
                $idDispo = 2;
                $nbLivreRestant = $unLivre['nbLivreDispo'];
                $nbLivre = $nbLivreRestant - 1;
                $exec = $livre->replace($nbLivre, $idLivre);
                $exec = $livre->replaceDispo($idDispo, $idLivre);
                $exec = $reservation->insert($idLivre, $idUtilisateur, $date);
                if (!$exec) {
                    $form['valide'] = false;
                } else {
                    $form['valide'] = true;
                    $form['message'] = 'Votre réservation a été prise en compte';
                }
            } else if ($testNbLivre == 0) {
                $idLivre = $_POST['idLivre'];
                $idUtilisateur = $_SESSION['idUtilisateur'];
                $date = date("Y-m-d");
                $unLivre = $livre->selectNbLivre($idLivre);
                $dispoS = $unLivre['idDispo'];
                $idDispo = 3;
                $nbLivreRestant = $unLivre['nbLivreDispo'];
                $nbLivre = $nbLivreRestant - 1;
                $exec = $livre->replace($nbLivre, $idLivre);
                $exec = $livre->replaceDispo($idDispo, $idLivre);
                $exec = $reservation->insert($idLivre, $idUtilisateur, $date);
                if (!$exec) {
                    $form['valide'] = false;
                } else {
                    $form['valide'] = true;
                    $form['message'] = 'Votre réservation a été prise en compte';
                }
            }
        }
    }//ajout reservation
    echo $twig->render('livreSelec.html.twig', array('form' => $form));
}

?>
<?php
function actionCategorieA($twig, $db) {
    $form = array();
    $categorie = new Categorie($db);
    if (isset($_POST['btSupprimer'])) {
            if (isset($_POST['cocher'])) {
                $cocher = $_POST['cocher'];
                $form['valide'] = true;
                $form['message'] = 'Les catégories ont correctement étaient supprimés.';
                foreach ($cocher as $idCat) {
                    $exec = $categorie->delete($idCat);
                }
            }
            else {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression. Aucune case chochée.';
            }
    }
    if (isset($_GET['idCat'])) {
        $exec = $categorie->delete($_GET['idCat']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table genre';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Catégorie supprimé avec succès';
        }
    }
    if (isset($_POST['btAjouter'])) {
        $libelleC = $_POST['libelleC'];
        $exec = $categorie->insert($libelleC);
    }
    $limite=5;
    if(!isset($_GET['nopage'])){   
        $inf=0;   
        $nopage=0;  
        }  
        else{  
            $nopage=$_GET['nopage'];  
            $inf=$nopage * $limite; 
            }
    $r = $categorie->selectCount(); 
    $nb = $r['nb'];
    $form['nbpages'] = ceil($nb/$limite);
    $liste = $categorie->selectLimit($inf,$limite); 
    echo $twig->render('categorieA.html.twig', array('form' => $form, 'liste' => $liste));
}
function actionModifCategorie($twig, $db) {
    $form = array();
    if (isset($_GET['idCat'])) {
        $categorie = new Categorie($db);
        $unCategorie = $categorie->selectById($_GET['idCat']);
        if ($unCategorie != null) {
            $form['valide']=true;
            $form['categorie'] = $unCategorie;
            $form['message'] = 'Ouais';
        } else {
            $form['valide']=false;
            $form['message'] = 'Categorie incorrect';
        }
    }
    if (isset($_POST['btModifier'])) {
        $categorie = new Categorie($db);
        $idCat = $_POST['idCat'];
        $libelleC = $_POST['libelleC'];
        $exec = $categorie->update($idCat, $libelleC);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    echo $twig->render('categorie-modif.html.twig', array('form' => $form));
}
?>

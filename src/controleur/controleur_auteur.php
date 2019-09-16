<?php
function actionAuteurA($twig, $db) {
    $form = array();
    $auteur = new Auteur($db);
    if (isset($_POST['btSupprimer'])) {
            if (isset($_POST['cocher'])) {
                $cocher = $_POST['cocher'];
                $form['valide'] = true;
                $form['message'] = 'Les auteurs ont correctement étaient supprimés.';
                foreach ($cocher as $id) {
                    $exec = $auteur->delete($id);
                }
            }
            else {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression. Aucune case chochée.';
            }
    }
    if (isset($_GET['idAuteur'])) {
        $exec = $auteur->delete($_GET['idAuteur']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table auteur';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Auteur supprimé avec succès';
        }
    }
    if (isset($_POST['btAjouter'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $biographie = $_POST['biographie'];
        $exec = $auteur->insert($prenom, $nom, $biographie);
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
    $r = $auteur->selectCount(); 
    $nb = $r['nb'];
    $form['nbpages'] = ceil($nb/$limite);
    $liste = $auteur->selectLimit($inf,$limite); 
    echo $twig->render('auteurA.html.twig', array('form' => $form, 'liste' => $liste));
}
function actionModifAuteur($twig, $db) {
    $form = array();
    if (isset($_GET['idAuteur'])) {
        $auteur = new Auteur($db);
        $unAuteur = $auteur->selectById($_GET['idAuteur']);
        if ($unAuteur != null) {
            $form['valide']=true;
            $form['auteur'] = $unAuteur;
        } else {
            $form['valide']=false;
            $form['message'] = 'Livre incorrect';
        }
    }
    if (isset($_POST['btModifier'])) {
        $auteur = new Auteur($db);
        $idAuteur = $_POST['idAuteur'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $biographie = $_POST['biographie'];
        $exec = $auteur->update($idAuteur, $prenom, $nom, $biographie);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    echo $twig->render('auteur-modif.html.twig', array('form' => $form));
}
?>

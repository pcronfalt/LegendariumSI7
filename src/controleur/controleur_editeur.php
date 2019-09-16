<?php
function actionEditeurA($twig, $db) {
    $form = array();
    $editeur = new Editeur($db);
    if (isset($_POST['btSupprimer'])) {
            if (isset($_POST['cocher'])) {
                $cocher = $_POST['cocher'];
                $form['valide'] = true;
                $form['message'] = 'Les éditeurs ont correctement étaient supprimés.';
                foreach ($cocher as $idEditeur) {
                    $exec = $editeur->delete($idEditeur);
                }
            }
            else {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression. Aucune case chochée.';
            }
    }
    if (isset($_GET['idEditeur'])) {
        $exec = $editeur->delete($_GET['idEditeur']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Editeur supprimé avec succès';
        }
    }
    if (isset($_POST['btAjouter'])) {
        $libelleE = $_POST['libelleE'];
        $exec = $editeur->insert($libelleE);
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
    $r = $editeur->selectCount(); 
    $nb = $r['nb'];
    $form['nbpages'] = ceil($nb/$limite);
    $liste = $editeur->selectLimit($inf,$limite); 
    echo $twig->render('editeurA.html.twig', array('form' => $form, 'liste' => $liste));
}
function actionModifEditeur($twig, $db) {
    $form = array();
    if (isset($_GET['idEditeur'])) {
        $editeur = new Editeur($db);
        $unEditeur = $editeur->selectById($_GET['idEditeur']);
        if ($unEditeur != null) {
            $form['valide']=true;
            $form['editeur'] = $unEditeur;
            $form['message'] = 'Ouais';
        } else {
            $form['valide']=false;
            $form['message'] = 'Livre incorrect';
        }
    }
    if (isset($_POST['btModifier'])) {
        $editeur = new Editeur($db);
        $idEditeur = $_POST['idEditeur'];
        $libelleE = $_POST['libelleE'];
        $exec = $editeur->update($idEditeur, $libelleE);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    echo $twig->render('editeur-modif.html.twig', array('form' => $form));
}
?>


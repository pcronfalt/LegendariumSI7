<?php
function actionGenreA($twig, $db) {
    $form = array();
    $genre = new Genre($db);
    if (isset($_POST['btSupprimer'])) {
            if (isset($_POST['cocher'])) {
                $cocher = $_POST['cocher'];
                $form['valide'] = true;
                $form['message'] = 'Les genres ont correctement étaient supprimés.';
                foreach ($cocher as $id) {
                    $exec = $genre->delete($id);
                }
            }
            else {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression. Aucune case chochée.';
            }
    }
    if (isset($_GET['idGenre'])) {
        $exec = $genre->delete($_GET['idGenre']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table genre';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Genre supprimé avec succès';
        }
    }
    if (isset($_POST['btAjouter'])) {
        $libelleG = $_POST['libelleG'];
        $exec = $genre->insert($libelleG);
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
    $r = $genre->selectCount(); 
    $nb = $r['nb'];
    $form['nbpages'] = ceil($nb/$limite);
    $liste = $genre->selectLimit($inf,$limite); 
    echo $twig->render('genreA.html.twig', array('form' => $form, 'liste' => $liste));
}
function actionModifGenre($twig, $db) {
    $form = array();
    if (isset($_GET['idGenre'])) {
        $genre = new Genre($db);
        $unGenre = $genre->selectById($_GET['idGenre']);
        if ($unGenre != null) {
            $form['valide']=true;
            $form['genre'] = $unGenre;
        } else {
            $form['valide']=false;
            $form['message'] = 'Livre incorrect';
        }
    }
    if (isset($_POST['btModifier'])) {
        $genre = new Genre($db);
        $idGenre = $_POST['idGenre'];
        $libelleG = $_POST['libelleG'];
        $exec = $genre->update($idGenre, $libelleG);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    echo $twig->render('genre-modif.html.twig', array('form' => $form));
}
?>



<?php
function actionAdministration($twig){
echo $twig->render('administration.html.twig', array());
 }
 ###################################################################
function actionAdminutilisateur($twig, $db){
  $form = array();
  $utilisateur = new Utilisateur($db);
  $liste = $utilisateur->select();
echo $twig->render('adminutilisateur.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdminlivre($twig, $db){
  $form = array();
  $livre = new Livre($db);
  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$livre->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table livre';
   }
   }
   }
  if(isset($_GET['id'])){
 $exec=$livre->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table L=livre';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Livre supprimé avec succès';
 }
 }
  $liste = $livre->select();
echo $twig->render('adminlivre.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdmincollection($twig, $db){
  $form = array();
  $collection = new Catalogue($db);
  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$collection->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table collection';
   }
   }
   }
  if(isset($_GET['id'])){
 $exec=$collection->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table collection';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Collection supprimé avec succès';
 }
 }
  $liste = $collection->select();
echo $twig->render('admincollection.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdmingenre($twig, $db){
  $form = array();
  $genre = new Genre($db);
  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$genre->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table genre';
   }
   }
   }
  if(isset($_GET['id'])){
 $exec=$genre->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table genre';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Genre supprimé avec succès';
 }
 }
  $liste = $genre->select();
echo $twig->render('admingenre.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdminauteur($twig, $db){
  $form = array();
  $auteur = new Auteur($db);
  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$auteur->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table auteur';
   }
   }
   }

  if(isset($_GET['id'])){
 $exec=$auteur->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table auteur';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Auteur supprimé avec succès';
 }
 }
  $liste = $auteur->select();
echo $twig->render('adminauteur.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdminediteur($twig, $db){
  $form = array();
  $editeur = new Editeur($db);

  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$editeur->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table editeur';
   }
   }
   }
  if(isset($_GET['id'])){
 $exec=$editeur->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table editeur';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Editeur supprimé avec succès';
 }
 }
  $liste = $editeur->select();
echo $twig->render('adminediteur.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdmindisponibilite($twig, $db){
  $form = array();
  $disponibilite = new Disponibilite($db);
  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$disponibilite->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table disponibilité';
   }
   }
   }
  if(isset($_GET['id'])){
 $exec=$disponibilite->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table disponibilite';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Disponibilite supprimé avec succès';
 }
 }
  $liste = $disponibilite->select();
echo $twig->render('admindisponibilite.html.twig', array('form'=>$form,'liste'=>$liste));
}
###################################################################
function actionAdminevent($twig, $db){
  $form = array();
  $event = new Event($db);
  if(isset($_POST['btSupprimer'])){
   $cocher = $_POST['cocher'];
   $form['valide'] = true;
   foreach ( $cocher as $id){
   $exec=$event->delete($id);
   if (!$exec){
   $form['valide'] = false;
   $form['message'] = 'Problème de suppression dans la table event';
   }
   }
   }
  if(isset($_GET['id'])){
 $exec=$event->delete($_GET['id']);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de suppression dans la table event';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Event supprimé avec succès';
 }
 }
  $liste = $event->select();
echo $twig->render('adminevent.html.twig', array('form'=>$form,'liste'=>$liste));
}

#######################################
function actionAjoutauteur($twig, $db){
  $form = array();
  $auteur = new Auteur($db);
  if (isset($_POST['btAjouter'])){
 $nomauteur = $_POST['inputNom'];
 $prenomauteur = $_POST['inputPrenom'];
 $biographieauteur = $_POST['inputBiographie'];
 $form['valide'] = true;

 $exec = $auteur->insert($nomauteur,$prenomauteur,$biographieauteur);
 if (!$exec){
 $form['messagev'] = 'test valid';
 $form['messagef'] = 'Problème ';
 }
 }

  $liste = $auteur->select();
echo $twig->render('adminajoutauteur.html.twig', array('form'=>$form,'liste'=>$liste));
}
function actionAjoutediteur($twig, $db){
  $form = array();
  $editeur = new Editeur($db);
  if (isset($_POST['btAjouter'])){
 $nomediteur = $_POST['inputNom'];

 $form['valide'] = true;

 $exec = $editeur->insert($nomediteur);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème ';
 }
 }

  $liste = $editeur->select();
echo $twig->render('adminajoutediteur.html.twig', array('form'=>$form,'liste'=>$liste));
}
function actionAjoutdisponibilite($twig, $db){
  $form = array();
  $disponibilite = new Disponibilite($db);
  if (isset($_POST['btAjouter'])){
 $libelle = $_POST['inputLibelle'];

 $form['valide'] = true;

 $exec = $disponibilite->insert($libelle);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème ';
 }
 }
  $liste = $disponibilite->select();
echo $twig->render('adminajoutdisponibilite.html.twig', array('form'=>$form,'liste'=>$liste));
}
function actionAjoutcollection($twig, $db){
  $form = array();
  $collection = new Catalogue($db);
  if (isset($_POST['btAjouter'])){
 $libellecollection = $_POST['inputLibellecollection'];

 $form['valide'] = true;

 $exec = $collection->insert($libellecollection);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème ';
 }
 }

  $liste = $collection->select();
echo $twig->render('adminajoutcollection.html.twig', array('form'=>$form,'liste'=>$liste));
}
function actionAjoutgenre($twig, $db){
  $form = array();
  $genre = new Genre($db);
  if (isset($_POST['btAjouter'])){
 $libellegenre = $_POST['inputLibellegenre'];

 $form['valide'] = true;

 $exec = $genre->insert($libellegenre);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème ';
 }
 }

  $liste = $genre->select();
echo $twig->render('adminajoutgenre.html.twig', array('form'=>$form,'liste'=>$liste));
}
function actionAjoutlivre($twig, $db){
  $form = array();
  $livre = new Livre($db);
  $genre = new Genre($db);
  $collection = new Catalogue($db);
  $disponibilite = new Disponibilite($db);
  $auteur = new Auteur($db);
  $editeur = new Editeur($db);
  if (isset($_POST['btAjouter'])){
 $couverture = $_POST['inputCouverture'];
 $titre = $_POST['inputTitre'];
 $idauteur = $_POST['inputIdauteur'];
 $idediteur = $_POST['inputIdediteur'];
 $datelivre = $_POST['inputDatelivre'];
 $isbn = $_POST['inputIsbn'];
 $prix = $_POST['inputPrix'];
 $iddisponibilite = $_POST['inputIddisponibilite'];
 $idcollection = $_POST['inputIdcollection'];
 $idgenre = $_POST['inputIdgenre'];
$idcoupdecoeur = $_POST['inputIdgenre'];
 $form['valide'] = true;

 $exec = $livre->insert($couverture,$titre,$idauteur,$idediteur,$datelivre,$isbn,$prix,$iddisponibilite,$idcollection,$idgenre);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème ';
 }
 }

  $liste = $livre->select();
  $listeg = $genre->select();
  $listec = $collection->select();
  $listed = $disponibilite->select();
  $listea = $auteur->select();
  $listee = $editeur->select();
  $listecdc = $coupdecoeur->select();
echo $twig->render('adminajoutlivre.html.twig', array('form'=>$form,'liste'=>$liste,'listeg'=>$listeg,'listec'=>$listec,'listed'=>$listed,'listea'=>$listea,'listee'=>$listee,'listecdc'=>$listecdc));
}
function actionAjoutevent($twig, $db){
  $form = array();
  $event = new Event($db);
  if (isset($_POST['btAjouter'])){
 $titre = $_POST['inputTitre'];
 $information = $_POST['inputInformation'];
 $illustration = $_POST['inputIllustration'];
 $form['valide'] = true;

 $exec = $event->insert($titre,$information,$illustration);
 if (!$exec){
 $form['messagev'] = 'test valid';
 $form['messagef'] = 'Problème ';
 }
 }

  $liste = $event->select();
echo $twig->render('adminajoutevent.html.twig', array('form'=>$form,'liste'=>$liste));
}
#########################################################################"
function actionModifcollection($twig, $db){
  $form = array();
  if(isset($_GET['id'])){
  $collection = new Catalogue($db);
  $unCollection = $collection->selectById($_GET['id']);
  if ($unCollection!=null){$form['collection'] = $unCollection;}
  else{$form['message'] = 'libelle incorrect';}
  }
  else{
  if (isset($_POST['btModifier'])){
  $collection = new Catalogue($db);
  $libellecollection = $_POST['inputLibellecollection'];
  $idcollection = $_POST['idcollection'];

  $form['valide'] = true;
  $form['message'] = 'Modification réussie';
 $exec=$collection->update($libellecollection,$idcollection);
  if(!$exec){
  $form['valide'] = false;
  $form['message'] = 'Échec de la modification';
  }
  }
   }
 $liste = $collection->select();
 echo $twig->render('adminmodifcollection.html.twig', array('form'=>$form,'liste'=>$liste));
 }
 function actionModifauteur($twig, $db){
   $form = array();
   if(isset($_GET['id'])){
       $auteur = new Auteur($db);

   $unAuteur = $auteur->selectById($_GET['id']);

   if ($unAuteur!=null){

   $form['auteur'] = $unAuteur;

   }
   else{
   $form['message'] = 'libelle incorrect';
   }
   }
    else{
   if (isset($_POST['btModifier'])){
    $auteur = new Auteur($db);
    $inputNom = $_POST['inputNom'];
    $inputPrenom = $_POST['inputPrenom'];
    $inputBiographie = $_POST['inputBiographie'];
    $idauteur = $_POST['idauteur'];

   $form['valide'] = true;
   $form['message'] = 'Modification réussie ';
   $exec=$auteur->update($inputNom,$inputPrenom,$inputBiographie,$idauteur);
   if(!$exec){
   $form['valide'] = false;
   $form['message'] = 'Échec de la modification';
   }

   }
    }
  $liste = $auteur->select();
  echo $twig->render('adminmodifauteur.html.twig', array('form'=>$form,'liste'=>$liste));
  }
  function actionModifgenre($twig, $db){
    $form = array();
    if(isset($_GET['id'])){
    $genre = new Genre($db);
    $unGenre = $genre->selectById($_GET['id']);
    if ($unGenre!=null){$form['genre'] = $unGenre;}
    else{$form['message'] = 'libelle incorrect';}
    }
    else{
    if (isset($_POST['btModifier'])){
    $genre = new Genre($db);
    $libellegenre = $_POST['inputLibellegenre'];
    $idgenre = $_POST['idgenre'];

    $form['valide'] = true;
    $form['message'] = 'Modification réussie';
   $exec=$genre->update($libellegenre,$idgenre);
    if(!$exec){
    $form['valide'] = false;
    $form['message'] = 'Échec de la modification';
    }
    }
     }
   $liste = $genre->select();
   echo $twig->render('adminmodifgenre.html.twig', array('form'=>$form,'liste'=>$liste));
   }
   function actionModifediteur($twig, $db){
     $form = array();
     if(isset($_GET['id'])){
     $editeur = new Editeur($db);
     $unEditeur = $editeur->selectById($_GET['id']);
     if ($unEditeur!=null){$form['editeur'] = $unEditeur;}
     else{$form['message'] = 'libelle incorrect';}
     }
     else{
     if (isset($_POST['btModifier'])){
     $editeur = new Editeur($db);
     $nomediteur = $_POST['inputNomediteur'];
     $idediteur = $_POST['idediteur'];

     $form['valide'] = true;
     $form['message'] = 'Modification réussie';
    $exec=$editeur->update($nomediteur,$idediteur);
     if(!$exec){
     $form['valide'] = false;
     $form['message'] = 'Échec de la modification';
     }
     }
      }
    $liste = $editeur->select();
    echo $twig->render('adminmodifediteur.html.twig', array('form'=>$form,'liste'=>$liste));
    }
    function actionModifdisponibilite($twig, $db){
      $form = array();
      if(isset($_GET['id'])){
      $disponibilite = new Disponibilite($db);
      $unDisponibilite = $disponibilite->selectById($_GET['id']);
      if ($unDisponibilite!=null){$form['disponibilite'] = $unDisponibilite;}
      else{$form['message'] = 'libelle incorrect';}
      }
      else{
      if (isset($_POST['btModifier'])){
      $disponibilite = new Disponibilite($db);
      $libelledisponibilite = $_POST['inputLibelledisponibilite'];
      $iddisponibilite = $_POST['iddisponibilite'];

      $form['valide'] = true;
      $form['message'] = 'Modification réussie';
     $exec=$disponibilite->update($libelledisponibilite,$iddisponibilite);
      if(!$exec){
      $form['valide'] = false;
      $form['message'] = 'Échec de la modification';
      }
      }
       }
     $liste = $disponibilite->select();
     echo $twig->render('adminmodifdisponibilite.html.twig', array('form'=>$form,'liste'=>$liste));
     }
     function actionModifevent($twig, $db){
       $form = array();
       if(isset($_GET['id'])){
           $event = new Event($db);

       $unEvent = $event->selectById($_GET['id']);

       if ($unEvent!=null){

       $form['event'] = $unEvent;

       }
       else{
       $form['message'] = 'libelle incorrect';
       }
       }
        else{
       if (isset($_POST['btModifier'])){
        $event = new Event($db);
        $titre = $_POST['inputTitre'];
        $information = $_POST['inputInformation'];
        $illustration = $_POST['inputIllustration'];
        $id = $_POST['id'];

       $form['valide'] = true;
       $form['message'] = 'Modification réussie ';
       $exec=$event->update($titre,$information,$illustration,$id);
       if(!$exec){
       $form['valide'] = false;
       $form['message'] = 'Échec de la modification';
       }

       }
        }
      $liste = $event->select();
      echo $twig->render('adminmodifevent.html.twig', array('form'=>$form,'liste'=>$liste));
      }
      function actionModiflivre($twig, $db){
        $form = array();
        if(isset($_GET['id'])){
            $livre = new Livre($db);

        $unLivre = $livre->selectById($_GET['id']);

        if ($unLivre!=null){

        $form['livre'] = $unLivre;

        }
        else{
        $form['message'] = 'libelle incorrect';
        }
        }
         else{
        if (isset($_POST['btModifier'])){
         $livre = new Livre($db);
         $couverture = $_POST['inputCouverture'];
         $titre = $_POST['inputTitre'];
         $idauteur = $_POST['inputAuteur'];
         $idediteur = $_POST['inputEditeur'];
         $datelivre = $_POST['inputDatelivre'];
         $isbn = $_POST['inputIsbn'];
         $prix = $_POST['inputPrix'];
         $idcollection = $_POST['inputCollection'];
         $idgenre = $_POST['inputGenre'];
         $iddisponibilite = $_POST['inputDisponibilite'];
         $idcoupdecoeur = $_POST['inputCoupdecoeur'];
         $resume = $_POST['inputResume'];
         $id = $_POST['id'];

        $form['valide'] = true;
        $form['message'] = 'Modification réussie ';
        $exec=$livre->update($couverture,$titre,$idauteur,$idediteur,$datelivre,$isbn,$prix,$iddisponibilite,$idcollection,$idgenre,$id);
        if(!$exec){
        $form['valide'] = false;
        $form['message'] = 'Échec de la modification';
        }

        }
         }
       $liste = $livre->select();
       echo $twig->render('adminmodiflivre.html.twig', array('form'=>$form,'liste'=>$liste));
     }
 ?>

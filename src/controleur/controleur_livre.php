<?php
function actionLivre($twig,$db){
$form = array();

  $event = new Event($db);
  $listeevent = $event->select();
  $livre = new Livre($db);
  $liste = $livre->select();
  $unLivre = $livre->selectById($_GET['id']);
  $auteur = new Auteur($db);
  $unAuteur = $auteur->selectById($unLivre['idauteur']);
  $editeur = new Editeur($db);
  $unEditeur = $editeur->selectById($unLivre['idediteur']);
  if ($unLivre!=null){

  $form['livre'] = $unLivre;
  $form['auteur'] = $unAuteur;
  $form['editeur'] = $unEditeur;
  }
  else{
  $form['message'] = 'libelle incorrect';
  }
 echo $twig->render('livre.html.twig', array('form'=>$form,'liste'=>$liste,'listeevent'=>$listeevent,));
 }

 ?>

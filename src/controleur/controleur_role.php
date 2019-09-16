<?php
 function actionRole($twig, $db){
 $form = array();
 $role = new Role($db);
 
  if (isset($_POST['btAjouter'])){
 $inputLibelle = $_POST['inputLibelle'];
 $form['valide'] = true;

 $exec = $role->insert($inputLibelle);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème ';
 }

 }
 
 
 $liste = $role->select();
 echo $twig->render('role.html.twig', array('form'=>$form,'liste'=>$liste));
 }
?>


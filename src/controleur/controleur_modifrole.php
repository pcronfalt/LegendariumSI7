<?php

function actionModifrole($twig, $db){
$form = array();

 if(isset($_GET['id'])){
     $role = new Role($db);

 $unRole = $role->selectById($_GET['id']);
 
 if ($unRole!=null){

 $form['role'] = $unRole;

 }
 else{
 $form['message'] = 'libelle incorrect';
 }
 }
  else{
 if (isset($_POST['btModifier'])){
        $role = new Role($db);
 $inputLibelle = $_POST['inputLibelle'];
 $id = $_POST['id'];

 $form['valide'] = true;
 $form['message'] = 'Modification réussie';
$exec=$role->update($inputLibelle,$id);
 if(!$exec){
 $form['valide'] = false;
 $form['message'] = 'Échec de la modification';
 }

 }
  }
$liste = $role->select();
 echo $twig->render('role-modif.html.twig', array('form'=>$form,'liste'=>$liste));
 
}

?>
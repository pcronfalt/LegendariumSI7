<?php

function actionModiftype($twig, $db){
$form = array();

 if(isset($_GET['id'])){
     $type = new Type($db);

 $unType = $type->selectById($_GET['id']);
 
 if ($unType!=null){

 $form['type'] = $unType;

 }
 else{
 $form['message'] = 'libelle incorrect';
 }
 }
  else{
 if (isset($_POST['btModifier'])){
        $type = new Type($db);
 $inputLibelle = $_POST['inputLibelle'];
 $id = $_POST['id'];

 $form['valide'] = true;
 $form['message'] = 'Modification réussie';
$exec=$type->update($inputLibelle,$id);
 if(!$exec){
 $form['valide'] = false;
 $form['message'] = 'Échec de la modification';
 }

 }
  }
$liste = $type->select();
 echo $twig->render('type-modif.html.twig', array('form'=>$form,'liste'=>$liste));
 
}

?>
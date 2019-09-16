
<?php
function actionType($twig, $db){
 $form = array();
  $type = new Type($db);
  if (isset($_POST['btAjouter'])){
 $inputLibelle = $_POST['inputLibelle'];
 $form['valide'] = true;

 $exec = $type->insert($inputLibelle);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème de je sais pas quoi ici ';
 }

 }
  
 $liste = $type->select();

 echo $twig->render('type.html.twig', array('form'=>$form,'liste'=>$liste));
}
?>
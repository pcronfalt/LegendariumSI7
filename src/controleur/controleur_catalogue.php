
<?php
function actionCatalogue($twig, $db){
 $form = array();



 $event = new Event($db);
 $listeevent = $event->select();
 $livre = new Livre($db);
 $liste = $livre->select();
 $catalogue = new Catalogue($db);
 $listecatalogue = $catalogue->select();

 echo $twig->render('catalogue.html.twig', array('form'=>$form,'liste'=>$liste,'listeevent'=>$listeevent,'listecatalogue'=>$listecatalogue));
}
?>

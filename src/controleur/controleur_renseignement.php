
<?php
 function actionRenseignement($twig,$db){
   $form = array();
   $event = new Event($db);
   $listeevent = $event->select();
    echo $twig->render('renseignement.html.twig', array('form'=>$form,'listeevent'=>$listeevent));
   }

?>

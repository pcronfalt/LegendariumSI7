<?php
 function actionContact($twig,$db){
 $form = array();
 $event = new Event($db);
 $listeevent = $event->select();
    echo $twig->render('contact.html.twig', array('form'=>$form,'listeevent'=>$listeevent));
   }

?>

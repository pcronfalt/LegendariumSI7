
<?php
function actioncollection($twig, $db){

  $form = array();
  $livre = new Livre($db);
  $liste = $livre->select();
  $event = new Event($db);
  $listeevent = $event->select();
  $limite=5;
  if(!isset($_GET['nopage'])){
    $inf=0;
    $nopage=0;
  }
  else{
    $nopage=$_GET['nopage'];
    $inf=$nopage * $limite;
  }
  $r = $livre->selectCount();
  $nb = $r['nb'];
  $liste = $livre->selectLimit($inf,$limite);
  $form['nbpages'] = ceil($nb/$limite);

 echo $twig->render('collection.html.twig', array('form'=>$form,'liste'=>$liste,'listeevent'=>$listeevent));

 }
?>

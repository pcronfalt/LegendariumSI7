<?php
function actionAccueil($twig, $db){
  $form = array();
  $livre = new Livre($db);
  $liste = $livre->select();
  $event = new Event($db);
  $listeevent = $event->select();
 echo $twig->render('index.html.twig', array('form'=>$form,'liste'=>$liste,'listeevent'=>$listeevent));
 }





function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function actionConnexion($twig, $db){

 $form = array();

 if (isset($_POST['btConnecter'])){
      $form['valide'] = true;
 $inputEmail = $_POST['inputEmail'];
 $inputPassword = $_POST['inputPassword'];
 $utilisateur = new Utilisateur($db);
 $unUtilisateur = $utilisateur->connect($inputEmail);
 if ($unUtilisateur!=null){
 if(!password_verify($inputPassword,$unUtilisateur['mdp'])){
 $form['valide'] = false;
 $form['message'] = 'Login ou mot de passe incorrect';
 }
 else{
 $_SESSION['login'] = $inputEmail;
 $_SESSION['role'] = $unUtilisateur['idRole'];
 header("Location:index.php");

 }
 }
 else{
 $form['valide'] = false;
 $form['message'] = 'Login ou mot de passe incorrect';

 }
 }
 echo $twig->render('connexion.html.twig', array('form'=>$form));

}





function actionDeconnexion($twig){
 session_unset();
 session_destroy();

 header("Location:index.php");
}

function actionPropos($twig){
 echo $twig->render('propos.html.twig', array());
}

function actionProfil($twig,$db){
 $form = array();

  $event = new Event($db);
  $listeevent = $event->select();
 echo $twig->render('profil.html.twig', array('form'=>$form, 'listeevent'=>$listeevent));
}





function actionMentionslegales($twig, $db){
  $form = array();
  $event = new Event($db);
  $listeevent = $event->select();
 echo $twig->render('mentionslegales.html.twig', array('form'=>$form, 'listeevent'=>$listeevent));
}

function actionMaintenance($twig){
 echo $twig->render('maintenance.html.twig', array());
}

function actionInscrire($twig, $db){
 $form = array();
 if (isset($_POST['btInscrire'])){
 $inputEmail = $_POST['inputEmail'];
 $inputPassword = $_POST['inputPassword'];
 $inputPassword2 =$_POST['inputPassword2'];
 $nom = $_POST['nom'];
 $prenom =$_POST['prenom'];
 $role = $_POST['role'];
 $form['valide'] = true;
 if ($inputPassword!=$inputPassword2){
 $form['valide'] = false;
 $form['message'] = 'Les mots de passe sont différents';
 }
 else{
 $utilisateur = new Utilisateur($db);
 $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword,PASSWORD_DEFAULT),$nom, $prenom, $role);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
 }
 }
 $form['email'] = $inputEmail;
 $form['role'] = $role;
 }

 echo $twig->render('inscrire.html.twig', array('form'=>$form));
}





?>


<?php
function actionModifuser($twig, $db){
  $form = array();
 if(isset($_GET['email'])){
 $utilisateur = new Utilisateur($db);
 $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
 if ($unUtilisateur!=null){

 $form['utilisateur'] = $unUtilisateur;
 $role = new Role($db);
 $liste = $role->select();
 $form['role']=$liste;
 
 
 }
 else{
 $form['message'] = 'Utilisateur incorrect';
 }
 }
  else{
 if(isset($_POST['btModifier'])){
 $utilisateur = new Utilisateur($db);
  $inputPassword = $_POST['inputPassword'];
 $inputPassword2 =$_POST['inputPassword2'];
 $nom = $_POST['nom'];
 $prenom = $_POST['prenom'];
 $role = $_POST['role'];
 $email = $_POST['email'];
 if ($inputPassword!=$inputPassword2){
 $form['valide'] = false;
 $form['message'] = 'Les mots de passe sont différents';
 }
  else{

 $exec=$utilisateur->update(password_hash($inputPassword,PASSWORD_DEFAULT),$email, $role, $nom, $prenom);
 if(!$exec){
 $form['valide'] = false;
 $form['message'] = 'Échec de la modification';
 }
 else{
 $form['valide'] = true;
 $form['message'] = 'Modification réussie';
 }
 }

 }
 else{
 $form['message'] = 'Utilisateur non précisé';
 }
 }
 echo $twig->render('utilisateur-modif.html.twig', array('form'=>$form));
}

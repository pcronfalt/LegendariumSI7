<?php
function getPage($db){

 $lesPages['accueil'] = "actionAccueil;0";
 $lesPages['connexion'] = "actionConnexion;0";
 $lesPages['mentions'] = "actionMentionslegales;0";
 $lesPages['inscrire'] = "actionInscrire;0";
 $lesPages['maintenance'] = "actionMaintenance;0";
 $lesPages['profil'] = "actionProfil;0";
 $lesPages['deconnexion'] = "actionDeconnexion;0" ;
 $lesPages['catalogue'] = "actionCatalogue;0" ;
 $lesPages['renseignement'] = "actionRenseignement;0" ;
 $lesPages['contact'] = "actionContact;0" ;
 $lesPages['livre'] = "actionLivre;0" ;
 $lesPages['collection'] = "actioncollection;0" ;
 #######################################################
 $lesPages['administration'] = "actionAdministration;1" ;
 $lesPages['adminutilisateur'] = "actionAdminutilisateur;1" ;
 $lesPages['adminlivre'] = "actionAdminlivre;1" ;
 $lesPages['admincollection'] = "actionAdmincollection;1" ;
 $lesPages['admingenre'] = "actionAdmingenre;1" ;
 $lesPages['adminauteur'] = "actionAdminauteur;1" ;
 $lesPages['adminediteur'] = "actionAdminediteur;1" ;
 $lesPages['admindisponibilite'] = "actionAdmindisponibilite;1" ;
 $lesPages['adminevent'] = "actionAdminevent;1" ;
 #######################################################
 $lesPages['ajoutauteur'] = "actionAjoutauteur;1" ;
 $lesPages['ajoutediteur'] = "actionAjoutediteur;1" ;
 $lesPages['ajoutdisponibilite'] = "actionAjoutdisponibilite;1" ;
 $lesPages['ajoutcollection'] = "actionAjoutcollection;1" ;
 $lesPages['ajoutgenre'] = "actionAjoutgenre;1" ;
 $lesPages['ajoutlivre'] = "actionAjoutlivre;1" ;
 $lesPages['ajoutevent'] = "actionAjoutevent;1" ;
 #######################################################
 $lesPages['modifcollection'] = "actionModifcollection;1" ;
 $lesPages['modifauteur'] = "actionModifauteur;1" ;
 $lesPages['modifgenre'] = "actionModifgenre;1" ;
 $lesPages['modifediteur'] = "actionModifediteur;1" ;
 $lesPages['modifdisponibilite'] = "actionModifdisponibilite;1" ;
 $lesPages['modifevent'] = "actionModifevent;1" ;
 #######################################################

if ($db!=null){
 if(isset($_GET['page'])){
 // Nous mettons dans la variable $page, la valeur qui a été passée dans le lien
 $page = $_GET['page']; }
 else{
 // S'il n'y a rien en mémoire, nous lui donnons la valeur « accueil » afin de lui afficher une page
 //par défaut
 $page = 'accueil';
 }
 if (!isset($lesPages[$page])){
 // Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
 $page = 'accueil';
 }

$explose = explode(";",$lesPages[$page]) ; // Nous découpons la ligne du tableau sur le
//caractère « ; » Le résultat est stocké dans le tableau $explose
$role = $explose[1] ; // Le rôle est dans la 2ème partie du tableau $explose
if ($role != 0){ // Si mon rôle nécessite une vérification
 if(isset($_SESSION['login'])){ // Si je me suis authentifié
 if(isset($_SESSION['role'])){ // Si j’ai bien un rôle
 if($role!=$_SESSION['role']){ // Si mon rôle ne correspond pas à celui qui est nécessaire
// $contenu = 'actionAccueil'; // Je le redirige vers l’accueil, car il n’a pas le bon rôle
 }
 else{
 $contenu = $explose[0]; // Je récupère le nom du contrôleur, car il a le bon rôle
 }
 }
 else{
 $contenu = 'actionAccueil';
 }
 }
 else{
 $contenu = 'actionAccueil'; // Page d’accueil, car il n’est pas authentifié
 }
 }else{
 $contenu = $explose[0]; // Je récupère le contrôleur, car il n’a pas besoin d’avoir un rôle
 }
}
else{
 // Si $db est null
 $contenu = 'actionMaintenance';
}
// La fonction envoie le contenu
return $contenu;
}

?>

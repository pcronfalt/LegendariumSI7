<?php

function getPage($db) {
    $lesPages['accueil'] = "actionAccueil;0";
    $lesPages['redirection'] = "actionRedirection;0";
    $lesPages['connexion'] = "actionConnexion;0";
    $lesPages['mention'] = "actionMentionLegale;0";
    $lesPages['inscrire'] = "actionInscrire;0";
    $lesPages['deconnexion'] = "actionDeconnexion;0";
    $lesPages['maintenance'] = "actionMaintenance;0";
    $lesPages['apropos'] = "actionApropos;0";
    $lesPages['utilisateur'] = "actionUtilisateur;1";
    $lesPages['modif'] = "actionModifUtilisateur;0";
    $lesPages['modifRole'] = "actionModifRole;0";
    $lesPages['catalogue'] = "actionCatalogue;0";
    $lesPages['catalogueA'] = "actionCatalogueA;1";
    $lesPages['modifCatalogue'] = "actionModifCatalogue;1";
    $lesPages['auteurA'] = "actionAuteurA;1";
    $lesPages['modifAuteur'] = "actionModifAuteur;1";
    $lesPages['genreA'] = "actionGenreA;1";
    $lesPages['modifGenre'] = "actionModifGenre;1";
    $lesPages['editeurA'] = "actionEditeurA;1";
    $lesPages['modifEditeur'] = "actionModifEditeur;1";
    $lesPages['categorieA'] = "actionCategorieA;1";
    $lesPages['modifCategorie'] = "actionModifCategorie;1";
    $lesPages['gestionCompte'] = "actionGestionCompte;0";
    $lesPages['modifEmail'] = "actionModifEmail;0";
    $lesPages['modifMdp'] = "actionModifMdp;0";
    $lesPages['actualiteA'] = "actionActualite;1";
    $lesPages['modifActualite'] = "actionModifActualite;1";
    $lesPages['modifNom'] = "actionModifNom;0";
    $lesPages['livreSelec'] = "actionLivreSelec;0";
    $lesPages['event'] = "actionEvent;0";
    $lesPages['reservationA'] = "actionReservation;1";
    $lesPages['mesReservations'] = "actionMesReservation;0";
    $lesPages['mesCoupsCoeurs'] = "actionMesCoupsCoeurs;0";
    $lesPages['indexJdr'] = "actionIndexJdr;0";
    $lesPages['indexMj'] = "actionIndexMj;0";
    $lesPages['creaJdr'] = "actionCreaJdr;0";
    $lesPages['jdrA'] = "actionJdrA;1";
    $lesPages['indexJ'] = "actionIndexJ;0";
    if ($db != null) {


        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 'accueil';
        }
        if (!isset($lesPages[$page])) {
            $page = 'accueil';
        }

        $explose = explode(";", $lesPages[$page]);

        $role = $explose[1]; // Le rôle est dans la 2ème partie du tableau $explose

        if ($role != 0) { // Si mon rôle nécessite une vérification
            if (isset($_SESSION['login'])) {  // Si je me suis authentifié
                if (isset($_SESSION['role'])) {  // Si j’ai bien un rôle  
                    if ($role != $_SESSION['role']) { // Si mon rôle ne correspond pas à celui qui est nécessaire 
                           $contenu = 'actionRedirection';  // Je le redirige vers l’accueil, car il n’a pas le bon rôle
                    } else {
                        $contenu = $explose[0];  // Je récupère le nom du contrôleur, car il a le bon rôle
                    }
                } else {
                    $contenu = 'actionRedirection';
                }
            } else {
                $contenu = 'actionRedirection';  // Page d’accueil, car il n’est pas authentifié
            }
        } else {
            $contenu = $explose[0]; //  Je récupère le contrôleur, car il n’a pas besoin d’avoir un rôle
        }
    } else {
        // Si $db est null
        $contenu = 'actionRedirection';
    } 
// La fonction envoie le contenu
    return $contenu;
}

?>
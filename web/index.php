<?php
session_start();
/* initialisation des fichiers TWIG */
require_once '../src/lib/vendor/autoload.php';
require_once '../src/modele/_classes.php';
require_once '../src/config/routing.php';
require_once '../src/controleur/_controleur.php';
require_once '../src/config/parametres.php';
require_once '../src/app/connexion.php';
$loader = new Twig_Loader_Filesystem('../src/vue/');
$twig = new Twig_Environment($loader, array());
$twig->addGlobal('session', $_SESSION);
$db = connect($config);
$contenu = getPage($db);
$contenu($twig,$db);
?>

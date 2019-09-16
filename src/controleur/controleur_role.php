<?php

function actionRole($twig, $db) {
    $form = array();
    $role = new Role($db);

    if (isset($_POST['btAjouter'])) {
        $libelleRole = $_POST['libelleRole'];
        $exec = $role->insert($libelleRole);
    }
    $liste = $role->select();
    echo $twig->render('role.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionModifRole($twig, $db) {
    $form = array();

    if (isset($_GET['idRole'])) {
        $role = new Role($db);
        $unRole = $role->selectById($_GET['idRole']);
        if ($unRole != null) {
            $form['role'] = $unRole;
        } else {
            $form['message'] = 'Role incorrect';
        }
    }
    if (isset($_POST['btModifierR'])) {
        $role = new Role($db);
        $idRole = $_POST['idRole'];
        $libelleRole = $_POST['libelleRole'];

        $exec = $role->update($idRole, $libelleRole);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    echo $twig->render('role-modif.html.twig', array('form' => $form));
}

?>
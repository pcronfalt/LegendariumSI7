<?php

class Coeur {
    
    private $db;    
    private $select;
    private $delete;
    private $insert;
    private $selectMesCc;

    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * "
                . "from coeur c, livre l, utilisateur u, genre g, categorie ca, disponibilite d, auteur a "
                . "where c.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=ca.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and c.idU=u.idUtilisateur "
                ); 
        $this->selectMesCc = $db->prepare("select * "
                . "from coeur c, livre l, utilisateur u, genre g, categorie ca, disponibilite d, auteur a "
                . "where c.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=ca.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and c.idU=u.idUtilisateur "
                . "and idU=:idU "); 
        $this->insert = $db->prepare("insert into coeur(idLivre, idU) values (:idLivre, :idUtilisateur)");
        $this->delete = $db->prepare("delete from coeur where idCc=:idCc");
    }
    
    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    public function delete($idCc) {
        $r = true;
        $this->delete->execute(array(':idCc' => $idCc));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }
    public function insert($idLivre, $idUtilisateur) { // Étape 3
        $t = true;
        $this->insert->execute(array(':idLivre' => $idLivre, ':idUtilisateur' => $idUtilisateur));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }
    public function selectMesCc($idU) {
        $this->selectMesCc->execute(array(':idU' => $idU));
        if ($this->selectMesCc->errorCode() != 0) {
            print_r($this->selectMesCc->errorInfo());
        }
        return $this->selectMesCc->fetch();
    }
}
?>


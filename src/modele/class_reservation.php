<?php

class Reservation {
    
    private $db;    
    private $select;
    private $delete;
    private $insert;
    private $selectMesReservations;
    private $selectOrderByIdRes;
    private $selectOrderByTitre;
    private $selectOrderByUti;
    private $selectOrderByDateRes;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * "
                . "from reservation r, livre l, utilisateur u, genre g, categorie c, disponibilite d, auteur a "
                . "where r.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=c.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and r.idU=u.idUtilisateur "); 
        $this->selectMesReservations = $db->prepare("select * "
                . "from reservation r, livre l, utilisateur u, genre g, categorie c, disponibilite d, auteur a "
                . "where r.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=c.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and r.idU=u.idUtilisateur "
                . "and idU=:idU "); 
        $this->insert = $db->prepare("insert into reservation(idLivre, idU, dateRes) values (:idLivre, :idUtilisateur, :dateRes)");
        $this->delete = $db->prepare("delete from reservation where idRes=:idRes");
        $this->selectOrderByIdRes = $db->prepare("select * "
                . "from reservation r, livre l, utilisateur u, genre g, categorie c, disponibilite d, auteur a "
                . "where r.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=c.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and r.idU=u.idUtilisateur "
                . "order by idRes");
        $this->selectOrderByTitre = $db->prepare("select * "
                . "from reservation r, livre l, utilisateur u, genre g, categorie c, disponibilite d, auteur a "
                . "where r.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=c.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and r.idU=u.idUtilisateur "
                . "order by titre");
        $this->selectOrderByUti = $db->prepare("select * "
                . "from reservation r, livre l, utilisateur u, genre g, categorie c, disponibilite d, auteur a "
                . "where r.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=c.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and r.idU=u.idUtilisateur "
                . "order by prenom"); 
        $this->selectOrderByDateRes = $db->prepare("select * "
                . "from reservation r, livre l, utilisateur u, genre g, categorie c, disponibilite d, auteur a "
                . "where r.idLivre=l.idLivre "
                . "and l.idGenre=g.idGenre "
                . "and l.idCat=c.idCat "
                . "and l.idDispo=d.idDispo "
                . "and l.idAuteur=a.idAuteur "
                . "and r.idU=u.idUtilisateur "
                . "order by dateRes"); 
    }
    
    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    public function delete($idRes) {
        $r = true;
        $this->delete->execute(array(':idRes' => $idRes));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }
    public function insert($idLivre, $idUtilisateur, $date) { // Étape 3
        $t = true;
        $this->insert->execute(array(':idLivre' => $idLivre, ':idUtilisateur' => $idUtilisateur, ':dateRes' => $date));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }
    public function selectMesReservations($idU) {
        $this->selectMesReservations->execute(array(':idU' => $idU));
        if ($this->selectMesReservations->errorCode() != 0) {
            print_r($this->selectMesReservations->errorInfo());
        }
        return $this->selectMesReservations->fetch();
    }
    public function selectOrderByIdRes() {
        $liste = $this->selectOrderByIdRes->execute();
        if ($this->selectOrderByIdRes->errorCode() != 0) {
            print_r($this->selectOrderByIdRes->errorInfo());
        }
        return $this->selectOrderByIdRes->fetchAll();
    }
    public function selectOrderByTitre() {
        $liste = $this->selectOrderByTitre->execute();
        if ($this->selectOrderByTitre->errorCode() != 0) {
            print_r($this->selectOrderByTitre->errorInfo());
        }
        return $this->selectOrderByTitre->fetchAll();
    }
    public function selectOrderByUti() {
        $liste = $this->selectOrderByUti->execute();
        if ($this->selectOrderByUti->errorCode() != 0) {
            print_r($this->selectOrderByUti->errorInfo());
        }
        return $this->selectOrderByUti->fetchAll();
    }public function selectOrderByDateRes() {
        $liste = $this->selectOrderByDateRes->execute();
        if ($this->selectOrderByDateRes->errorCode() != 0) {
            print_r($this->selectOrderByDateRes->errorInfo());
        }
        return $this->selectOrderByDateRes->fetchAll();
    }
    
}
?>



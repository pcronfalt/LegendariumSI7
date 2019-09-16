<?php

class Jdr {

    private $select;
    private $db;
    private $insert;
    private $update;
    private $delete;
    private $selectByMj;
    private $refuseById;
    private $valideById;
    private $selectById;
    private $selectNbJoueur;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from jdr j, jeu g where j.idJeu = g.idJeu");
        $this->selectById = $db->prepare("select * from jdr j, jeu g where j.idJeu = g.idJeu and idJdr=:id");
        $this->insert = $db->prepare("insert into jdr(mj, emailMj, telMj, synopsis, fournisMj, dateJdr, idJeu) values (:mj, :emailMj, :telMj, :synopsis, :fournisMj, :dateJdr, :idJeu)");
        $this->delete = $db->prepare("delete from jdr where idJdr=:idJ");
        $this->update = $db->prepare("update jdr set nbJoueur=:nbJ where idJeu=:idJ");
        $this->valideById = $db->prepare("update jdr set valide=1 where idJdr=:id");
        $this->refuseById = $db->prepare("update jdr set valide=0 where idJdr=:id");
        $this->selectByMj = $db->prepare("select * from jdr j, jeu g where j.idJeu = g.idJeu and mj=:mj");
        $this->selectNbJoueur = $db->prepare("select * from jdr where idJeu=:idJ");
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectById($id) {
        $this->selectById->execute(array(':id' => $id));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }
     public function delete($idJ) {
        $r = true;
        $this->delete->execute(array(':idJ' => $idJ));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }
    public function insert($pseudo, $email, $telMj, $syno, $fournis, $date, $id) { // Étape 3
        $t = true;
        $this->insert->execute(array(':mj' => $pseudo, ':emailMj' => $email, ':telMj' => $telMj, ':synopsis' => $syno, ':fournisMj' => $fournis, ':dateJdr' => $date, ':idJeu' => $id));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }
    
    public function update($nbJ, $idJ) {
        $r = true;
        $this->update->execute(array(':nbJ' => $nbJ, ':idJ' => $idJ));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }
    public function valideById($id) {
        $r = true;
        $this->valideById->execute(array(':id' => $id));
        if ($this->valideById->errorCode() != 0) {
            print_r($this->valideById->errorInfo());
            $r = false;
        }
        return $r;
    }
      public function refuseById($id) {
        $r = true;
        $this->refuseById->execute(array(':id' => $id));
        if ($this->refuseById->errorCode() != 0) {
            print_r($this->refuseById->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectByMj($mj) {
        $this->selectByMj->execute(array(':mj' => $mj));
        if ($this->selectByMj->errorCode() != 0) {
            print_r($this->selectByMj->errorInfo());
        }
        return $this->selectByMj->fetch();
    }
    public function selectNbJoueur($idJ) {
        $nbJoueur = $this->selectNbJoueur->execute(array(':idJ' => $idJ));
        if ($this->selectNbJoueur->errorCode() != 0) {
            print_r($this->selectNbJoueur->errorInfo());
        }
        return $this->selectNbJoueur->fetch();
    }

}

?>
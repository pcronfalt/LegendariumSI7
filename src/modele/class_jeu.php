<?php
class Jeu {
    private $select;
    private $selectIdjeu;
    private $db;
    private $insert;
    private $selectByMj;
    private $delete;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from jeu j");
        $this->selectIdjeu = $db->prepare("select max(idJeu) as nb from jeu");
        $this->insert = $db->prepare("insert into jeu(nomJeu, dureeSess, descriptionJeu, regleJeu, illustration) values (:nomJeu, :dureeSess, :description, :regleJeu, :illustration)");
        $this->selectByMj = $db->prepare("select * from jdr j, jeu g where j.idJeu = g.idJeu and mj=:mj");
        $this->delete = $db->prepare("delete from jeu where idJeu=:idG");
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    public function delete($idG) {
        $r = true;
        $this->delete->execute(array(':idG' => $idG));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }
    public function selectIdjeu() {
        $this->selectIdjeu->execute(); 
        if ($this->selectIdjeu->errorCode()!=0){
            print_r($this->selectIdjeu->errorInfo()); 
        }       
        return $this->selectIdjeu->fetch();  
    }

    public function insert($nom, $duree, $desc, $regle, $illustration) { // Étape 3
        $t = true;
        $this->insert->execute(array(':nomJeu' => $nom, ':dureeSess' => $duree, ':description' => $desc, ':regleJeu' => $regle, ':illustration' => $illustration));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }

    public function selectByMj($mj) {
        $this->selectByMj->execute(array(':mj' => $mj));
        if ($this->selectByMj->errorCode() != 0) {
            print_r($this->selectByMj->errorInfo());
        }
        return $this->selectByMj->fetch();
    }
}

<?php

class Actualite {

    private $select;
    private $db;
    private $insert;
    private $update;
    private $selectById;
    private $selectCount;
    private $delete;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into actualite (titre,contenu,date,photo) values (:titre,:contenu,:date,:photo)");
        $this->select = $db->prepare("select * from actualite a");
        $this->update = $db->prepare("update actualite set idActu=:idActu, titre=:titre, contenu=:contenu, date=:date, photo=:photo where idActu=:idActu");
        $this->selectById = $db->prepare("select titre,contenu,DATE_FORMAT(date, \"%d-%m-%Y\") as date,photo from actualite where idActu=:idActu ");
        $this->selectCount =$db->prepare("select count(*) as nb from actualite");
        $this->delete = $db->prepare("delete from actualite where idActu=:idActu");
    }

    public function insert($titre, $contenu, $date, $photo) { // Étape 3
        $p = true;
        $this->insert->execute(array(':titre' => $titre, ':contenu' => $contenu, ':date' => $date, ':photo' => $photo));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $p = false;
        }
        return $p;
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    public function selectCount() { 
        $this->selectCount->execute(); 
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo()); 
        }       
        return $this->selectCount->fetch();  
    }
    public function update($idActu, $titre, $contenu, $date, $photo) {
        $r = true;
        $this->update->execute(array(':idActu' => $idActu, ':titre' => $titre, ':contenu' => $contenu, ':date' => $date, ':photo' => $photo));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idActu) {
        $this->selectById->execute(array(':idActu' => $idActu));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function delete($idActu) {
        $r = true;
        $this->delete->execute(array(':idActu' => $idActu));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

}

?>

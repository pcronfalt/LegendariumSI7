<?php

class Genre {

    private $select;
    private $insert;
    private $db;
    private $update;
    private $selectById;
    private $delete;
    private $selectLimit;
    private $selectCount;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into genre(libelleG) values (:libelleG)");
        $this->select = $db->prepare("select * from genre g");
        $this->update = $db->prepare("update genre set libelleG=:libelleG where idGenre=:idGenre");
        $this->selectById = $db->prepare("select * from genre where idGenre=:idGenre ");
        $this->delete = $db->prepare("delete from genre where idGenre=:idGenre");
        $this->selectLimit = $db->prepare("select * from genre g limit :inf, :limite");
        $this->selectCount =$db->prepare("select count(*) as nb from genre");
    }

    public function insert($libelleG) { // Étape 3
        $t = true;
        $this->insert->execute(array(':libelleG' => $libelleG));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function update($idGenre, $libelleG) {
        $r = true;
        $this->update->execute(array(':idGenre' => $idGenre,':libelleG' => $libelleG));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idGenre) {
        $this->selectById->execute(array(':idGenre' => $idGenre));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function delete($idGenre) {
        $r = true;
        $this->delete->execute(array(':idGenre' => $idGenre));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }
     public function selectLimit($inf, $limite) {        
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();        
        if ($this->selectLimit->errorCode()!=0){   
            print_r($this->selectLimit->errorInfo());         
        }        
        return $this->selectLimit->fetchAll(); 
    }
    public function selectCount() { 
        $this->selectCount->execute(); 
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo()); 
        }       
        return $this->selectCount->fetch();  
    }

}

?>


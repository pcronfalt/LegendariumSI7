<?php

class Role {

    private $select;
    private $db;
    private $insert;
    private $update;
    private $selectById;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select  * from role r");
        $this->insert = $db->prepare("insert into role(libelleRole) values (:libelleRole)");
        $this->update = $db->prepare("update role set libelleRole=:libelleRole where idRole=:idRole");
        $this->selectById = $db->prepare("select * from role where idRole=:idRole ");
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($libelleRole) { // Étape 3
        $t = true;
        $this->insert->execute(array(':libelleRole' => $libelleRole));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $t = false;
        }
        return $t;
    }

    public function update($idRole, $libelleRole) {
        $r = true;
        $this->update->execute(array(':idRole' => $idRole, ':libelleRole' => $libelleRole));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idRole) {
        $this->selectById->execute(array(':idRole' => $idRole));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

}

?>
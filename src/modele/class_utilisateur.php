<?php

class Utilisateur {

    private $db;
    private $insert;
    private $insertJdr;
    private $connect;
    private $connectId;
    private $select;
    private $selectByEmail;
    private $updateEmail;
    private $updateMdp;
    private $updateNom;
    private $updateRole;
    private $updateJeu;
    private $selectLimit;
    private $selectCount;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into utilisateur(email, mdp, nom, prenom, idRole,dateNaiss) values (:email, :mdp, :nom, :prenom, :role,:dateNaiss)");
        $this->insertJdr = $db->prepare("update utilisateur set pseudoJdr=:pseudo where email=:email");
        $this->connect = $db->prepare("select * from utilisateur where email=:email");
        $this->connectId = $db->prepare("select * from utilisateur where idUtilisateur=:idUti");
        $this->select = $db->prepare("select * from utilisateur u, role r where u.idRole=r.idRole");
        $this->selectByEmail = $db->prepare("select * from utilisateur u where email=:email");
        $this->updateEmail = $db->prepare("update utilisateur set email=:email where idUtilisateur=:idUtilisateur");
        $this->updateMdp = $db->prepare("update utilisateur set mdp=:mdp where idUtilisateur=:idUtilisateur");
        $this->updateNom = $db->prepare("update utilisateur set nom=:nom , prenom=:prenom where idUtilisateur=:idUtilisateur");
        $this->updateRole = $db->prepare("update utilisateur set idRole=:idRole where email=:email");
        $this->updateJeu = $db->prepare("update utilisateur set jdrPartic=:idJ where idUtilisateur=:idUti");
        $this->updateJeuDes = $db->prepare("update utilisateur set jdrPartic=NULL where idUtilisateur=:idUti");
        $this->selectLimit = $db->prepare("select * from utilisateur u, role r where u.idRole=r.idRole limit :inf, :limite");
        $this->selectCount = $db->prepare("select count(*) as nb from utilisateur");
    }

    public function insert($email, $mdp, $role, $nom, $prenom, $dateNaiss) { // Étape 3
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':dateNaiss' => $dateNaiss));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function insertJdr($pseudo, $email) {
        $r = true;
        $this->insertJdr->execute(array(':pseudo' => $pseudo, ':email' => $email));
        if ($this->insertJdr->errorCode() != 0) {
            print_r($this->insertJdr->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function connect($email) {
        $unUtilisateur = $this->connect->execute(array(':email' => $email));
        if ($this->connect->errorCode() != 0) {
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    public function connectId($idUti) {
        $unUti = $this->connectId->execute(array(':idUti' => $idUti));
        if ($this->connectId->errorCode() != 0) {
            print_r($this->connectId->errorInfo());
        }
        return $this->connectId->fetch();
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectByEmail($email) {
        $this->selectByEmail->execute(array(':email' => $email));
        if ($this->selectByEmail->errorCode() != 0) {
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetch();
    }

    public function updateEmail($email, $idUtilisateur) {
        $r = true;
        $this->updateEmail->execute(array(':email' => $email, ':idUtilisateur' => $idUtilisateur));
        if ($this->updateEmail->errorCode() != 0) {
            print_r($this->updateEmail->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateMdp($mdp, $idUtilisateur) {
        $r = true;
        $this->updateMdp->execute(array(':mdp' => $mdp, ':idUtilisateur' => $idUtilisateur));
        if ($this->updateMdp->errorCode() != 0) {
            print_r($this->updateMdp->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateNom($nom, $prenom, $idUtilisateur) {
        $r = true;
        $this->updateNom->execute(array(':nom' => $nom, ':prenom' => $prenom, ':idUtilisateur' => $idUtilisateur));
        if ($this->updateNom->errorCode() != 0) {
            print_r($this->updateNom->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateRole($email, $idRole) {
        $r = true;
        $this->updateRole->execute(array(':email' => $email, ':idRole' => $idRole));
        if ($this->updateRole->errorCode() != 0) {
            print_r($this->updateRole->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateJeu($idJ, $idUti) {
        $r = true;
        $this->updateJeu->execute(array(':idJ' => $idJ, ':idUti' => $idUti));
        if ($this->updateJeu->errorCode() != 0) {
            print_r($this->updateJeu->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateJeuDes($idUti) {
        $r = true;
        $this->updateJeuDes->execute(array(':idUti' => $idUti));
        if ($this->updateJeuDes->errorCode() != 0) {
            print_r($this->updateJeuDes->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectLimit($inf, $limite) {
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode() != 0) {
            print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }

    public function selectCount() {
        $this->selectCount->execute();
        if ($this->selectCount->errorCode() != 0) {
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    }

}

?>
<?php
class Utilisateur{

 private $db;
 private $insert;
 private $connect;
 private $select;
 private $selectByEmail;
 private $update;



 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("insert into utilisateur(email, mdp, nom, prenom, idRole) values(:email, :mdp, :nom, :prenom, :role)");
 $this->connect = $db->prepare("select email, idRole, mdp from utilisateur where email=:email");
 $this->select = $db->prepare("select  id, email, idRole, nom, prenom, r.libelle as libellerole from utilisateur u, role r where u.idRole = r.id order by nom");
 $this->selectByEmail = $db->prepare("select email, nom, prenom, idRole from utilisateur where email=:email");
 $this->update = $db->prepare("update  utilisateur  set  mdp=:mdp, nom=:nom,  prenom=:prenom,  idRole=:role where email=:email");

 }


 public function insert($inputEmail, $inputPassword, $nom, $prenom,$role){
 $r = true;
 $this->insert->execute(array(':email'=>$inputEmail, ':mdp'=>$inputPassword, ':nom'=>$nom, ':prenom'=>$prenom, ':role'=>$role));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }

 public function connect($inputEmail){

 $unUtilisateur = $this->connect->execute(array(':email'=>$inputEmail));
 if ($this->connect->errorCode()!=0){
 print_r($this->connect->errorInfo());
 }
 return $this->connect->fetch();
 }

  public function select(){
 $liste = $this->select->execute();
 if ($this->select->errorCode()!=0){
 print_r($this->select->errorInfo());
 }
 return $this->select->fetchAll();
 }

 public function selectByEmail($email){
 $this->selectByEmail->execute(array(':email'=>$email));
 if ($this->selectByEmail->errorCode()!=0){
 print_r($this->selectByEmail->errorInfo());
 }
 return $this->selectByEmail->fetch();
 }

 public function update($mdp ,$email, $role, $nom, $prenom){
        $r = true;
        $this->update->execute(array(':mdp'=>$mdp,':email'=>$email, ':role'=>$role, ':nom'=>$nom, ':prenom'=>$prenom));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());
             $r=false;
        }
        return $r;
    }


}
?>

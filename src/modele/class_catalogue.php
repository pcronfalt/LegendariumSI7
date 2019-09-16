<?php

class Livre {

    private $select;
    private $selectMotcle;
    private $db;
    private $insert;
    private $replace;
    private $replaceDispo;
    private $selectNbLivre;
    private $update;
    private $selectById;
    private $delete;
    private $selectLimit;
    private $selectByGenre;
    private $selectCount;
    private $selectCountGenre;
    private $selectOrderByTitre;
    private $selectOrderByPrixC;
    private $selectOrderByPrixD;
    private $selectOrderByDispo;
    private $selectOrderByDateSortie;
    private $search;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into livre(titre, isbn, dateSortie, resume, couverture, prix, idAuteur, idGenre, idEditeur, idCat, idDispo, nbLivreDispo) "
                                   . "values (:titre, :isbn, :dateSortie, :resume, :couverture,:prix, :idAuteur, :idGenre, :idEditeur, :idCat, :idDispo, :nbLivreDispo)");
        //ajouter les donnees dans le bd
        $this->replace = $db->prepare("update livre "
                                   . "set nbLivreDispo=:nbLivre "
                                   . "where idLivre=:idLivre");
        
        $this->replaceDispo = $db->prepare("update livre "
                                   . "set idDispo=:idDispo "
                                   . "where idLivre=:idLivre");
        //met a jour la disponnibilité
        $this->select = $db->prepare("select * "
                                   . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                   . "where l.idAuteur=a.idAuteur "
                                   . "and l.idGenre=g.idGenre "
                                   . "and l.idEditeur=e.idEditeur "
                                   . "and l.idCat=c.idCat "
                                   . "and l.idDispo=d.idDispo ");
        //selectionne tout les donnees
        $this->selectMotcle = $db->prepare("select * "
                                   . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                   . "where l.idAuteur=a.idAuteur "
                                   . "and l.idGenre=g.idGenre "
                                   . "and l.idEditeur=e.idEditeur "
                                   . "and l.idCat=c.idCat "
                                   . "and l.idDispo=d.idDispo "
                                   . "and not idLivre=:idLivre");
        //selectionne tout les donnees qui conresponde aux mots cles
        $this->selectNbLivre = $db->prepare("select * from livre where idLivre=:idLivre");
        
        $this->update = $db->prepare("update livre "
                                   . "set titre=:titre, "
                                   . "isbn=:isbn, "
                                   . "dateSortie=:dateSortie,"
                                   . "resume=:resume, "
                                   . "couverture=:couverture,"
                                   . "prix=:prix, "
                                   . "idAuteur=:idAuteur, "
                                   . "idGenre=:idGenre, "
                                   . "idEditeur=:idEditeur, "
                                   . "idCat=:idCat, "
                                   . "idDispo=:idDispo, "
                                   . "nbLivreDispo=:nbLivreDispo "
                                   . "where idLivre=:idLivre");
         //met a jour toutes les donnees
        $this->selectById = $db->prepare("select * "
                                       . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                       . "where idLivre=:idLivre "
                                       . "and l.idAuteur=a.idAuteur "
                                       . "and l.idGenre=g.idGenre "
                                       . "and l.idEditeur=e.idEditeur "
                                       . "and l.idCat=c.idCat "
                                       . "and l.idDispo=d.idDispo ");
        //selectionne une ligne de la bd
        $this->delete = $db->prepare("delete from livre "
                                   . "where idLivre=:idLivre");
        //supprime une ligne de la bd livre
        $this->selectLimit = $db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "order by idLivre DESC "
                                        . "limit :inf, :limite ");
                                        
        $this->selectCount =$db->prepare("select count(*) as nb from livre");
        //pagination
        $this->selectByGenre =$db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "and l.idGenre=:idG "
                                        . "limit :inf, :limite");
        
        $this->selectCountGenre =$db->prepare("select count(*) as nb from livre where idGenre=:idG");
        
        $this->selectOrderByTitre =$db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "order by titre "
                                        . "limit :inf, :limite");
        
        $this->selectOrderByPrixC =$db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "order by prix "
                                        . "limit :inf, :limite");
        
        $this->selectOrderByPrixD =$db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "order by prix DESC "
                                        . "limit :inf, :limite");
        
        $this->selectOrderByDispo =$db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "order by libelleD "
                                        . "limit :inf, :limite");
        $this->selectOrderByDateSortie =$db->prepare("select * "
                                        . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                        . "where l.idAuteur=a.idAuteur "
                                        . "and l.idGenre=g.idGenre "
                                        . "and l.idEditeur=e.idEditeur "
                                        . "and l.idCat=c.idCat "
                                        . "and l.idDispo=d.idDispo "
                                        . "order by idLivre "
                                        . "limit :inf, :limite");
        //trier
        $this->search =$db->prepare("select * "
                                   . "from livre l, auteur a, genre g, editeur e, categorie c, disponibilite d "
                                   . "where l.idAuteur=a.idAuteur "
                                   . "and l.idGenre=g.idGenre "
                                   . "and l.idEditeur=e.idEditeur "
                                   . "and l.idCat=c.idCat "
                                   . "and l.idDispo=d.idDispo "
                                   . "and titre like :search"
                                   );
        //rechercher
    }

    public function insert($titre, $idGenre, $isbn, $dateSortie, $resume, $couverture, $prix, $idAuteur, $idEditeur, $idCat, $nbLivreDispo, $idDispo) { // Étape 3
        $p = true;
        $this->insert->execute(array(':titre' => $titre, ':idGenre' => $idGenre, ':isbn' => $isbn, ':dateSortie' => $dateSortie, ':resume' => $resume, ':couverture' => $couverture, ':prix' => $prix, ':idAuteur' => $idAuteur, ':idEditeur' => $idEditeur, ':idCat' => $idCat, ':nbLivreDispo' => $nbLivreDispo, ':idDispo' => $idDispo));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $p = false;
        }
        return $p;
    }
    
    public function replace($nbLivre, $idLivre) { // Étape 3
        $p = true;
        $this->replace->execute(array(':nbLivre' => $nbLivre, ':idLivre' => $idLivre ));
        if ($this->replace->errorCode() != 0) {
            print_r($this->replace->errorInfo());
            $p = false;
        }
        return $p;
    }
    public function replaceDispo($idDispo, $idLivre) { // Étape 3
        $p = true;
        $this->replaceDispo->execute(array(':idDispo' => $idDispo, ':idLivre' => $idLivre));
        if ($this->replaceDispo->errorCode() != 0) {
            print_r($this->replaceDispo->errorInfo());
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
    public function selectMotcle($idLivre) {
        $desLivres = $this->selectMotcle->execute(array(':idLivre' => $idLivre));
        if ($this->selectMotcle->errorCode() != 0) {
            print_r($this->selectMotcle->errorInfo());
        }
        return $this->selectMotcle->fetchAll();
    }

    public function update($idLivre, $titre, $idGenre, $isbn, $dateSortie, $resume, $couverture, $prix, $idAuteur, $idEditeur, $idCat, $nbLivreDispo, $idDispo) {
        $r = true;
        $this->update->execute(array(':idLivre' => $idLivre, ':titre' => $titre, ':idGenre' => $idGenre, ':isbn' => $isbn, ':dateSortie' => $dateSortie, ':resume' => $resume, ':couverture' => $couverture, ':prix' => $prix, ':idAuteur' => $idAuteur, ':idEditeur' => $idEditeur, ':idCat' => $idCat, ':nbLivreDispo' => $nbLivreDispo, ':idDispo' => $idDispo));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectById($idLivre) {
        $this->selectById->execute(array(':idLivre' => $idLivre));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function delete($idLivre) {
        $r = true;
        $this->delete->execute(array(':idLivre' => $idLivre));
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
    public function selectByGenre($inf, $limite, $idG) {
        $this->selectByGenre->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectByGenre->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectByGenre->bindParam(':idG', $idG, PDO::PARAM_INT);
        $this->selectByGenre->execute();
        if ($this->selectByGenre->errorCode() != 0) {
            print_r($this->selectByGenre->errorInfo());
        }
        return $this->selectByGenre->fetchAll();
    }
     public function selectCountGenre($idG) { 
        $this->selectCountGenre->execute(array(':idG' => $idG)); 
        if ($this->selectCountGenre->errorCode()!=0){
            print_r($this->selectCountGenre->errorInfo()); 
        }       
        return $this->selectCountGenre->fetch();  
    }
    public function selectOrderByTitre($inf, $limite) {        
        $this->selectOrderByTitre->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectOrderByTitre->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectOrderByTitre->execute();        
        if ($this->selectOrderByTitre->errorCode()!=0){   
            print_r($this->selectOrderByTitre->errorInfo());         
        }        
        return $this->selectOrderByTitre->fetchAll(); 
    }
    public function selectOrderByPrixC($inf, $limite) {        
        $this->selectOrderByPrixC->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectOrderByPrixC->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectOrderByPrixC->execute();        
        if ($this->selectOrderByPrixC->errorCode()!=0){   
            print_r($this->selectOrderByPrixC->errorInfo());         
        }        
        return $this->selectOrderByPrixC->fetchAll(); 
    }
    public function selectOrderByPrixD($inf, $limite) {        
        $this->selectOrderByPrixD->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectOrderByPrixD->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectOrderByPrixD->execute();        
        if ($this->selectOrderByPrixD->errorCode()!=0){   
            print_r($this->selectOrderByPrixD->errorInfo());         
        }        
        return $this->selectOrderByPrixD->fetchAll(); 
    }
    public function selectOrderByDispo($inf, $limite) {        
        $this->selectOrderByDispo->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectOrderByDispo->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectOrderByDispo->execute();        
        if ($this->selectOrderByDispo->errorCode()!=0){   
            print_r($this->selectOrderByDispo->errorInfo());         
        }        
        return $this->selectOrderByDispo->fetchAll(); 
    }
    public function selectOrderByDateSortie($inf, $limite) {        
        $this->selectOrderByDateSortie->bindParam(':inf', $inf, PDO::PARAM_INT);        
        $this->selectOrderByDateSortie->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectOrderByDateSortie->execute();        
        if ($this->selectOrderByDateSortie->errorCode()!=0){   
            print_r($this->selectOrderByDateSortie->errorInfo());         
        }        
        return $this->selectOrderByDateSortie->fetchAll(); 
    }
     public function search($search) {
       $liste = $this->search->execute(array(':search' => '%'.$search.'%'));
        if ($this->search->errorCode() != 0) {
            print_r($this->search->errorInfo());
        }
        return $this->search->fetchAll();
    }
     public function selectNbLivre($idLivre) {
        $unLivre = $this->selectNbLivre->execute(array(':idLivre' => $idLivre));
        if ($this->selectNbLivre->errorCode() != 0) {
            print_r($this->selectNbLivre->errorInfo());
        }
        return $this->selectNbLivre->fetch();
    }
    
}
?>
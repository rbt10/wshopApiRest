<?php

class Magasin
{
    // Connexion
    private $connexion;
    private $table = "magasin";

    // propriétes de notre table
    public $id;
    public $libelle;
    public $ville;
    public $adresse;
    public $codepostal;
    public $phone;


    /**
     * constructeur pour la connexion à la base des données
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * création d'un Magasin
     * @return bool
     */
    public function create(){

        // Ecriture de la requête SQL en y insérant le libelle de la table
        $sql = "INSERT INTO " . $this->table . " SET libelle=:libelle, ville=:ville, adresse=:adresse, codepostal=:codepostal, phone=:phone";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->libelle=htmlspecialchars(strip_tags($this->libelle));
        $this->ville=htmlspecialchars(strip_tags($this->ville));
        $this->adresse=htmlspecialchars(strip_tags($this->adresse));
        $this->codepostal=htmlspecialchars(strip_tags($this->codepostal));
        $this->phone=htmlspecialchars(strip_tags($this->phone));

        // Ajout des données protégées
        $query->bindParam(":libelle", $this->libelle);
        $query->bindParam(":ville", $this->ville);
        $query->bindParam(":adresse", $this->adresse);
        $query->bindParam(":codepostal", $this->codepostal);
        $query->bindParam(":phone", $this->phone);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Affichage tous les magasins
     * @return mixed
     */
    public function readAll(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table;

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }


    /**
     * Afficher un magasin
     * @return void
     */
    public function read(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table ." LIMIT 0,1";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->libelle = $row['libelle'];
        $this->ville = $row['ville'];
        $this->adesse = $row['adesse'];
        $this->codepostal = $row['codepostal'];
        $this->phone = $row['phone'];
    }


    /**
     * Supprimer le magasin en fonction de l'identifiant
     * @return bool
     */
    public function delete(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        if($query->execute()){
            return true;
        }

        return false;
    }

    /**
     * Mise à jour du Magasin en fonction de l'identifiant
     *
     * @return bool
     */
    public function update(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET libelle = :libelle, ville = :ville, adesse = :adesse, codepostal = :codepostal, phone = :phone WHERE id = :id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->libelle=htmlspecialchars(strip_tags($this->libelle));
        $this->ville=htmlspecialchars(strip_tags($this->ville));
        $this->adresse=htmlspecialchars(strip_tags($this->adresse));
        $this->codepostal=htmlspecialchars(strip_tags($this->codepostal));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // On attache les variables
        $query->bindParam(':libelle', $this->libelle);
        $query->bindParam(':ville', $this->ville);
        $query->bindParam(':adresse', $this->adresse);
        $query->bindParam(':codepostal', $this->codepostal);
        $query->bindParam(':phone', $this->phone);
        $query->bindParam(':id', $this->id);

        // On exécute
        if($query->execute()){
            return true;
        }

        return false;
    }
}
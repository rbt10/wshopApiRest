<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    include_once 'config/Database.php';
    include_once 'model/Magasin.php';

    // intancier la bdd
    $database = new Database();
    $db = $database->getConnection();

    //instancier notre classe magasin

    $magasin = new Magasin($db);

    // récupération des données

    $resultat =  $magasin->readAll();

    if($resultat->rowCount() > 0){
        // j'initialise le tableau

        $lesMagasins =[];
        $lesMagasins['magasin'] = [];

        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
            extract($ligne);

            $tabProduits = [
                "id" => $id,
                "libelle" => $libelle,
                "ville" => $ville,
                "adresse" => $adresse,
                "codePostal" => $codePostal,
                "phone" => $phone
            ];

            $lesMagasins['magasin'] = $tabProduits;
        }
        // envoie de la reponse et on encode le tableau en  json

        http_response_code(200);
        echo json_encode($lesMagasins);

    }
}else{

    // gestion des erreur
    http_response_code(405);
    echo json_encode(["message" => "la methode n'est pas autorisée"]);
}
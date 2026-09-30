<?php

require "./classes/thematique.php";
require "./classes/thematiques_repository.php";
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');


if($_SERVER["REQUEST_METHOD"]==="POST"){
    $data = json_decode(file_get_contents("php://input"),true);
    $thematique=new Thematique(
        
        $data["nom_thematique"],
        $data["description_thematique"]
        
    );
    $repository=new ThematiqueRepository(__DIR__ . "/data/thematiques.json");

    $repository->create($thematique);
    echo json_encode($thematique);

}
if($_SERVER["REQUEST_METHOD"]==="GET"){
    $repository=new ThematiqueRepository(__DIR__ . "/data/thematiques.json");

    $thematiques= $repository->getAll();
    $result=[];

    foreach($thematiques as $thematiqueObj){
        $result[]=[
            "id_thematique"=>$thematiqueObj->getId(),
            "nom_thematique"=>$thematiqueObj->getNom(),
            "description_thematique"=>$thematiqueObj->getDescription()
        ];
    }
    echo json_encode($result);

}





?>



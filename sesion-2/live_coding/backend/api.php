<?php
require_once __DIR__ . "/classes/thematique.php";
require_once __DIR__ . "/classes/thematiqueRepository.php";

header('content-type: application/json');


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $data=json_decode(file_get_contents("php://input"),true);
    $thematique=new Thematique(
        $data["nom_thematique"],
        $data["description_thematique"],
       
    );
    $respository=new ThematiqueRepository(__DIR__ . "/data/thematiques.json");
    $respository->create($thematique);
    echo json_encode($thematique);
   
};

if($_SERVER["REQUEST_METHOD"]=="GET"){
    $repository=new ThematiqueRepository(__DIR__ . "/data/thematiques.json");
    $thematiques=$repository->getAll();
    $result=[];
    foreach($thematiques as $thematique){
        $result[]=[
         "id_thematique"=>$thematique->getId(),
         "nom_thematique"=>$thematique->getNom(),
         "description_thematique"=>$thematique->getDescription(),
        ];
    };
    echo json_encode($result );


}

?>
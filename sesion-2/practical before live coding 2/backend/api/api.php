<?php
require_once __DIR__ . "/../classes/ThematiqueRepo.php";


header("Content-Type: application/json");


if($_SERVER['REQUEST_METHOD']=="GET"){
    $repository=new ThematiqueRepo();
    $thematiques=$repository->getAll();

    $result=[];

    foreach($thematiques as $thematique){
        $result[]=[
            "id"=>$thematique->getId(),
            "name"=>$thematique->getName(),
            "description"=>$thematique->getDescreption()
        ];
    }
   echo  json_encode($result);
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $jsonData=file_get_contents("php://input");
    $data=json_decode($jsonData,true);

    $thematique=new Thematique(
        $data["name"],
        $data["description"]

    );
    $repository=new ThematiqueRepo();
    $repository->create($thematique);
    echo json_encode($thematique);
    
}

?>
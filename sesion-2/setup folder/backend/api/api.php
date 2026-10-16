<?php

use Dom\Text;

require_once __DIR__ . "/../classes/ThematiqueRepo.php";


header("Content-type: application/json");


if($_SERVER["REQUEST_METHOD"]=="GET"){
    $repository=new ThematiqueRepo;
    $data=$repository->getAll();  //objects array 
    $result=[];
    foreach ($data as $thematique){
        $result[]=[
            "name"=>$thematique->getName(),
            "description"=>$thematique->getDescreption(),
            "id"=>$thematique->getId()

        ];
    };
    echo json_encode($result);


}
if($_SERVER["REQUEST_METHOD"]=="POST"){
     $jsonData=file_get_contents("php://input");
     $data=json_decode($jsonData,true);
     $thematique=new Thematique(
        $data["name"],
        $data["description"]
     );
     $repository=new ThematiqueRepo;
     $repository->create($thematique);
     echo json_encode($thematique);
}

?>

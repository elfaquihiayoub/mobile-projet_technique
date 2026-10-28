<?php
    require_once __DIR__ . "/../../classes/gestionThematique.php";

    header("Content-Type: application/json");

    class ControllerThematique{
        public function listAll(){
            $gestionThematique=new GestionThematique();
            $thematiques=$gestionThematique->getAll();
            $result=[];
            foreach($thematiques as $thematique){
                $result[]=[
                    "id"=>$thematique->getId(),
                    "name"=>$thematique->getName(),
                    "description"=>$thematique->getDescription()
                ];
            
            }
            echo json_encode($result);
        }

        public function createThematique(){
            $jsonData=file_get_contents("php://input");
            $data=json_decode($jsonData,true);
            $gestionThematique=new GestionThematique();
            $thematique=new Thematique($data["name"],$data["description"]);
            $gestionThematique->create($thematique);
            echo json_encode($thematique);

            
        }
    }

    // get o post
    $controller=new ControllerThematique();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $controller->createThematique();
    }else{
        $controller->listAll();
    }


?>
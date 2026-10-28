<?php
    require_once "Thematique.php";

    class GestionThematique{
        private static $dataFile= __DIR__ . "/../data/thematique.json";

        public function getAll(){
            $jsonData=file_get_contents(self::$dataFile);
            $data=json_decode($jsonData,true);
            $thematiques=[];
            foreach($data as $item){
                $thematique=new Thematique($item["name"],$item["description"],$item["id"]);
                $thematiques[]=$thematique;
            }
            return $thematiques;
        }

        
        public function create(Thematique $thematique){
             $jsonData=file_get_contents(self::$dataFile);
             $data=json_decode($jsonData,true);
             $id=count($data)+1;
             $data[]=[
                 "id"=>$id,
                "name"=>$thematique->getName(),
                "description"=>$thematique->getDescription()

             ];
             $jsonData=json_encode($data,JSON_PRETTY_PRINT);
             file_put_contents(self::$dataFile,$jsonData);
        }
    }




?>
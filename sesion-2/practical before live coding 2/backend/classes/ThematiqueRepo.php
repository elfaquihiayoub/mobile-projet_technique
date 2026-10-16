<?php

require_once __DIR__ . "/Thematique.php";
class ThematiqueRepo{
    private static $dataFile=__DIR__ . "/../data/thematique.json";

    public function getAll(){
        $jsonData=file_get_contents(self::$dataFile);
        $data=json_decode($jsonData,true) ?? [];
        $thematiques=[];
        foreach($data as $item){
            $thematique=new Thematique(
                $item["name"],
                $item["description"],
                $item["id"]
            );
            $thematiques[]=$thematique;
        };
        return $thematiques ;
    }

    public function create(Thematique $thematique){
        $jsonData=file_get_contents(self::$dataFile);
        $data=json_decode($jsonData,true);
        $id=count($data)+1;
        $data[]=[
            "name"=>$thematique->getName(),
            "description"=>$thematique->getDescreption(),
            "id"=>$id
        ];
        $jsonData=json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents(self::$dataFile,$jsonData);
        return $thematique;
    }



}


?>
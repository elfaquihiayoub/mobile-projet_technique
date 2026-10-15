<?php
require_once __DIR__ . "/categorie.php";
    class gestionCategorie{

    private static $dataFile= __DIR__ . "/../data/categorie.json";


    public function getAll(){
        $jsonData=file_get_contents(self::$dataFile);
        $data=json_decode($jsonData,true);
        $categories=[];
        foreach($data as $item){
            $categorie=new Categorie(
                $item['id'],
                $item['name'],
                $item['descreption']
            );
            $categories[]=$categorie;
            

        }
        return $categories; }


    public function create(Categorie $Categorie){
         $jsonData=file_get_contents(self::$dataFile);
        $data=json_decode($jsonData,true);
        $id=count($data);
        $data[]=[
            "id"=>$id,
            "name"=>$Categorie->getName(),
            "descreption"=>$Categorie->getDescreption()

        ];

        $jsonData=json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents(self::$dataFile,$jsonData);
        return $Categorie;
    }
    public function delete(int $id){

        $jsonData=file_get_contents(self::$dataFile);
        $data=json_decode($jsonData,true);
        $filterdData=array_filter($data,function($item) use ($id){
            return $item["id"]!=$id;

        });
        $data=array_values($filterdData);
        $jsonData=json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents(self::$dataFile,$jsonData);
    }

    public function update(Categorie $Categorie){
        $jsonData=file_get_contents(self::$dataFile);
        $data=json_decode($jsonData,true);
        foreach($data as &$item){
            if($item["id"]==$Categorie->getId()){
                $item["name"]=$Categorie->getName();
                $item["descreption"]=$Categorie->getDescreption();
                
            }
        }
        unset($item);
        $jsonData=json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents(self::$dataFile,$jsonData);
        return $Categorie;

    }



    }

?>
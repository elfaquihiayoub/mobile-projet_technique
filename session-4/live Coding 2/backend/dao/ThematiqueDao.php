<?php
require __DIR__ . "/../classes/Thematique.php";

class ThematiqueDao
{
    private $dataFile;
  

    public function __construct()
    {
        $this->dataFile = __DIR__ . "/../data/thematique.json";
    }
    public function readData()
    {
        $jsonData = file_get_contents($this->dataFile);
        if ($jsonData === false) {
            throw new RuntimeException(" no such data to get , file path incorrect ");
        }
        $data = json_decode($jsonData, true);
        if (!is_array($data)) {
            throw new RuntimeException("data is not at the exact format");
        }
        return $data;
    }


    public function getAll()
    {
        $data = $this->readData();
        $thematiques = [];
        foreach ($data as $item) {
            $thematiques[] = new Thematique($item["name"], $item["description"], $item["id"]);
        }
        return $thematiques;
    }
    public function create(Thematique $thematique)
    {
        $data = $this->readData();
        $id = count($data) + 1;
        $data[] = [
            "id" => $id,
            "name" => $thematique->getName(),
            "description" => $thematique->getDescription()
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        if($jsonData==false){
            throw new RuntimeException("error in data corruption");
        }
        if(file_put_contents($this->dataFile,$jsonData)==false){
            throw new RuntimeException("error at writing data , contact the support or something like that ");
        }
    }
}

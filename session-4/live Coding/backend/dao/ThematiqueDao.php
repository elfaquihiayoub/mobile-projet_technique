<?php
require_once __DIR__ . "/../classes/Thematique.php";
class ThematiqueDao
{
    private string $datafile;
    public function __construct()
    {
        $this->datafile = __DIR__ . "/../data/thematique.json";
    }

    public function readData():array
    {
        $jsondata = file_get_contents($this->datafile);
        if ($jsondata == false) {
            throw new RuntimeException("enable to read data from file");
        }
        $data = json_decode($jsondata, true);
        if (!is_array($data)) {
            throw new RuntimeException("the data is not in format json");
        }

        return $data;
    }

    public function getAll():array
    {
        $data = $this->readData();
        $thematiques = [];
        foreach ($data as $item) {
            $thematiques[] = new Thematique($item["name"], $item["description"], $item["id"]);
        }
        return $thematiques;
    }
    public function create(Thematique $thematique):void
    {
        $data = $this->readData();
        $id=count($data);
        $data[]=[
            "id"=>$id,
            "name"=>$thematique->getName(),
            "description"=>$thematique->getDescription(),
        ];
        $jsonData=json_encode($data,JSON_PRETTY_PRINT);
        if($jsonData===false){
            throw new RuntimeException("enable to encode data to formate json");
        }
        if(file_put_contents($this->datafile,$jsonData)===false){
             throw new RuntimeException("enable to save data");
        }

        
    }
}

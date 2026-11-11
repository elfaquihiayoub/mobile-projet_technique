<?php
require_once __DIR__ . "/../classes/Thematique.php";

class ThematiqueDao
{
    private $datafile;
    public function __construct()
    {
        $this->datafile = __DIR__ . "/../data/thematique.json";
    }

    public function readData(): array
    {
        $jsondata = file_get_contents($this->datafile);
        if ($jsondata === false) {
            throw new RuntimeException("no such data to get");
        }
        $data = json_decode($jsondata, true);
        if (!is_array($data)) {
            throw new RuntimeException("the data is not forma json");
        }
        return $data;
    }
    public function getAll(): array
    {
        $data = $this->readData();
        $thematiques = [];
        foreach ($data as $item) {
            $thematiques[] = 
                new Thematique($item["name"], $item["description"], $item["id"])
            ;
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
        $jsondata = json_encode($data, JSON_PRETTY_PRINT);
        if ($jsondata == false) {
            throw new RuntimeException("the data is not forma json");
        }
        if (file_put_contents($this->datafile, $jsondata) === false) {
            throw new RuntimeException("error in encoding ");
        };
    }
}

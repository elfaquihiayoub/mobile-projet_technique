<?php
require_once __DIR__ . "/../classes/Thematique.php";

class ThematiqueDao
{
    private string $dataFile;

    public function __construct()
    {
        $this->dataFile = __DIR__ . "/../data/thematique.json";
    }

    public function getAll(): array
    {
        $data = $this->readData();
        $thematiques = [];

        foreach ($data as $item) {
            $thematiques[] = new Thematique(
                $item["name"],
                $item["description"],
                $item["id"]
            );
        }

        return $thematiques;
    }

    public function create(Thematique $thematique): void
    {
        $data = $this->readData();
        $id = count($data) + 1;
        $data[] = [
            "id" => $id,
            "name" => $thematique->getName(),
            "description" => $thematique->getDescription(),
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            throw new RuntimeException("Unable to encode thematique data.");
        }

        if (file_put_contents($this->dataFile, $jsonData) === false) {
            throw new RuntimeException("Unable to save thematique data.");
        }
    }

    private function readData(): array
    {
        $jsonData = file_get_contents($this->dataFile);
        if ($jsonData === false) {
            throw new RuntimeException("Unable to read thematique data.");
        }

        $data = json_decode($jsonData, true);
        if (!is_array($data)) {
            throw new UnexpectedValueException("Thematique data must be a JSON array.");
        }

        return $data;
    }
}
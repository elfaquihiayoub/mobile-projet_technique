<?php
require_once __DIR__ . "/Thematique.php";
require_once __DIR__ . "/BaseService.php";

class GestionThematique extends BaseService
{
    private static $dataFile = __DIR__ . "/../data/thematique.json";

    public function getAll(): array
    {
        $data = $this->readJsonFile(self::$dataFile);
        $thematiques = [];

        foreach ($data as $item) {
            if (
                !is_array($item)
                || !isset($item["id"], $item["name"], $item["description"])
                || !is_int($item["id"])
                || !is_string($item["name"])
                || !is_string($item["description"])
            ) {
                throw new DataStorageException("Le fichier des thématiques contient des données invalides.");
            }

            $thematiques[] = new Thematique($item["name"], $item["description"], $item["id"]);
        }

        return $thematiques;
    }


    public function create(Thematique $thematique): void
    {
        $name = trim($thematique->getName());

        if (strlen($name) < 3) {
            throw new ValidationException("Le nom doit contenir au moins 3 caractères.");
        }

        $data = $this->readJsonFile(self::$dataFile);
        $id = count($data) + 1;

        $data[] = [
            "id" => $id,
            "name" => $name,
            "description" => $thematique->getDescription()
        ];

        $this->writeJsonFile(self::$dataFile, $data);
    }
}

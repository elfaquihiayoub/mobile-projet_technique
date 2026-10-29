<?php
require_once "Thematique.php";
require_once "BaseService.php";

class GestionThematique extends BaseService
{
    private static $dataFile = __DIR__ . "/../data/thematique.json";

    public function getAll()
    {
        try {
            $jsonData = file_get_contents(self::$dataFile);
            $data = json_decode($jsonData, true);

            $thematiques = [];
            foreach ($data as $item) {
                $thematique = new Thematique($item["name"], $item["description"], $item["id"]);
                $thematiques[] = $thematique;
            }
            return $thematiques;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la lecture du fichier JSON : ");
        }
    }


    public function create(Thematique $thematique)
    {
        try {
            $name = trim($thematique->getName());

            if (strlen($name) < 3) {
                throw new Exception("Le nom doit contenir au moins 3 caractères.");
            }

            $jsonData = file_get_contents(self::$dataFile);
            $data = json_decode($jsonData, true);

            $id = count($data) + 1;

            $data[] = [
                "id" => $id,
                "name" => $name,
                "description" => $thematique->getDescription()
            ];

            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents(self::$dataFile, $jsonData);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

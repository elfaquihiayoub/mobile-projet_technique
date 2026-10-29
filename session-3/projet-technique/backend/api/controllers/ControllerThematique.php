<?php
require_once __DIR__ . "/../../classes/gestionThematique.php";

class ControllerTematique
{
    public function listAll()
    {
        try {

            $gestionThematique = new GestionThematique();
            $thematiques = $gestionThematique->getAll();
            $result = [];
            foreach ($thematiques as $thematique) {
                $result[] = [
                    "id" => $thematique->getId(),
                    "name" => $thematique->getName(),
                    "description" => $thematique->getDescription()
                ];
            }
            header("Content-Type: application/json");
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de la récupération des thématiques"]);
        }
    }
    public function createCategorie()
    {
        header("Content-Type: application/json");
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
        $thematique = new Thematique($data["name"], $data["description"]);
        $gestionThematique = new GestionThematique();
        $gestionThematique->create($thematique);
        echo json_encode($thematique);
    }
}
$controller = new ControllerTematique();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->createCategorie();
} else {
    $controller->listAll();
}

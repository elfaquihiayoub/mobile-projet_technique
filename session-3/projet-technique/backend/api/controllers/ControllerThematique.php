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

            $this->sendJson($result);
        } catch (Throwable $exception) {
            $this->sendJson(["error" => "Erreur lors de la récupération des thématiques."], 500);
        }
    }

    public function createCategorie()
    {
        try {
            $jsonData = file_get_contents("php://input");

            if ($jsonData === false) {
                throw new RuntimeException("Impossible de lire la requête.");
            }

            try {
                $data = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $exception) {
                throw new ValidationException("Le corps de la requête doit être un JSON valide.", 0, $exception);
            }

            if (
                !is_array($data)
                || !isset($data["name"], $data["description"])
                || !is_string($data["name"])
                || !is_string($data["description"])
            ) {
                throw new ValidationException("Les champs name et description sont obligatoires et doivent être des chaînes de caractères.");
            }

            $thematique = new Thematique($data["name"], $data["description"]);
            $gestionThematique = new GestionThematique();
            $gestionThematique->create($thematique);

            $this->sendJson($thematique);
        } catch (ValidationException $exception) {
            $this->sendJson(["error" => $exception->getMessage()], 400);
        } catch (Throwable $exception) {
            $this->sendJson(["error" => "Erreur lors de l'enregistrement de la thématique."], 500);
        }
    }

    private function sendJson($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header("Content-Type: application/json");
        echo json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR);
    }
}

$controller = new ControllerTematique();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->createCategorie();
} else {
    $controller->listAll();
}

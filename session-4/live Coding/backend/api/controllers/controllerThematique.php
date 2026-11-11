<?php



require_once __DIR__ . "/../../services/ThematiqueService.php";

header("Content-Type: application/json");

class ControllerThematique
{

    private ThematiqueService $thematiqueService;

    public function __construct()
    {
        $this->thematiqueService = new ThematiqueService(new ThematiqueDao());
    }

    public function listAll(): void
    {
        $thematiques = $this->thematiqueService->getAll();
        $result = [];
        foreach ($thematiques as $thematique) {
            $result[] = [
                "id" => $thematique->getId(),
                "name" => $thematique->getName(),
                "description" => $thematique->getDescription(),

            ];
        }
        echo json_encode($result);
    }

    public function createThematique()
    {
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
        $thematique = new Thematique($data["name"], $data["description"]);
        $this->thematiqueService->create($thematique);
        echo json_encode($thematique);
    }
}


$controller = new ControllerThematique();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->createThematique();
} else {
    $controller->listAll();
}

<?php 

require_once __DIR__ . "/../backend/classes/gestionThematique.php";

$thematique = new Thematique("sport", "test", 5);
if ((string) $thematique !== "sport (test)") {
    throw new RuntimeException("Thematique string representation is incorrect.");
}

$gestionThematique = new GestionThematique();
if ($gestionThematique->getAll() === []) {
    throw new RuntimeException("Expected to load at least one thematique.");
}

try {
    $gestionThematique->create(new Thematique("ab", "test"));
    throw new RuntimeException("Expected short names to be rejected.");
} catch (ValidationException $exception) {
    if ($exception->getMessage() !== "Le nom doit contenir au moins 3 caractères.") {
        throw $exception;
    }
}

$baseService = new class extends BaseService {
    public function readFile(string $filePath): array
    {
        return $this->readJsonFile($filePath);
    }
};

try {
    $baseService->readFile(__DIR__ . "/missing-data.json");
    throw new RuntimeException("Expected missing files to raise a storage exception.");
} catch (DataStorageException $exception) {
    // Expected: the test path does not exist.
}

echo "Thematique tests passed." . PHP_EOL;

?>
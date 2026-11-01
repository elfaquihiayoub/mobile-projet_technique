<?php

require_once __DIR__ . "/../backend/classes/gestionThematique.php";

function assertTest(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function expectException(string $exceptionClass, callable $operation, ?string $message = null): Throwable
{
    try {
        $operation();
    } catch (Throwable $exception) {
        if (!$exception instanceof $exceptionClass) {
            throw new RuntimeException(
                "Expected {$exceptionClass}, got " . get_class($exception) . ".",
                0,
                $exception
            );
        }

        if ($message !== null && $exception->getMessage() !== $message) {
            throw new RuntimeException(
                "Expected exception message '{$message}', got '{$exception->getMessage()}'.",
                0,
                $exception
            );
        }

        return $exception;
    }

    throw new RuntimeException("Expected {$exceptionClass} to be thrown.");
}

$temporaryDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "thematique-tests-" . bin2hex(random_bytes(6));
if (!mkdir($temporaryDirectory)) {
    throw new RuntimeException("Could not create the temporary test directory.");
}

$temporaryFiles = [
    $temporaryDirectory . DIRECTORY_SEPARATOR . "valid.json",
    $temporaryDirectory . DIRECTORY_SEPARATOR . "invalid.json",
    $temporaryDirectory . DIRECTORY_SEPARATOR . "scalar.json",
    $temporaryDirectory . DIRECTORY_SEPARATOR . "write.json",
    $temporaryDirectory . DIRECTORY_SEPARATOR . "workflow.json",
    $temporaryDirectory . DIRECTORY_SEPARATOR . "invalid-record.json",
];
$directoryPath = $temporaryDirectory . DIRECTORY_SEPARATOR . "not-a-file";
mkdir($directoryPath);

try {
    $thematique = new Thematique("sport", "test", 5);
    assertTest((string) $thematique === "sport (test)", "Thematique string representation is incorrect.");
    assertTest($thematique->getId() === 5, "Thematique ID was not retained.");
    assertTest($thematique->getName() === "sport", "Thematique name was not retained.");
    assertTest($thematique->getDescription() === "test", "Thematique description was not retained.");

    $baseService = new class extends BaseService {
        public function readFile(string $filePath): array
        {
            return $this->readJsonFile($filePath);
        }

        public function writeFile(string $filePath, array $data): void
        {
            $this->writeJsonFile($filePath, $data);
        }
    };

    $validFile = $temporaryFiles[0];
    file_put_contents($validFile, '[{"id":1}]');
    assertTest($baseService->readFile($validFile) === [["id" => 1]], "Valid JSON data was not read.");

    expectException(
        DataStorageException::class,
        fn() => $baseService->readFile($temporaryDirectory . DIRECTORY_SEPARATOR . "missing.json"),
        "Impossible de lire le fichier de données."
    );

    file_put_contents($temporaryFiles[1], "{invalid");
    $invalidJsonException = expectException(
        DataStorageException::class,
        fn() => $baseService->readFile($temporaryFiles[1]),
        "Le fichier de données contient un JSON invalide."
    );
    assertTest($invalidJsonException->getPrevious() instanceof JsonException, "Invalid JSON cause was not preserved.");

    file_put_contents($temporaryFiles[2], "null");
    expectException(
        DataStorageException::class,
        fn() => $baseService->readFile($temporaryFiles[2]),
        "Le fichier de données doit contenir une liste."
    );

    $baseService->writeFile($temporaryFiles[3], [["name" => "saved"]]);
    assertTest(
        $baseService->readFile($temporaryFiles[3]) === [["name" => "saved"]],
        "Written JSON data could not be read back."
    );

    $encodingException = expectException(
        DataStorageException::class,
        fn() => $baseService->writeFile($temporaryFiles[3], ["invalid" => "\xB1\x31"]),
        "Impossible de convertir les données en JSON."
    );
    assertTest($encodingException->getPrevious() instanceof JsonException, "JSON encoding cause was not preserved.");
    expectException(
        DataStorageException::class,
        fn() => $baseService->writeFile($directoryPath, ["name" => "fail"]),
        "Impossible d'enregistrer le fichier de données."
    );

    $dataFileProperty = new ReflectionProperty(GestionThematique::class, "dataFile");
    $originalDataFile = $dataFileProperty->getValue();

    try {
        $dataFileProperty->setValue(null, $temporaryFiles[4]);
        file_put_contents($temporaryFiles[4], "[]");

        $gestionThematique = new GestionThematique();
        $gestionThematique->create(new Thematique("  science  ", "podcasts"));
        $created = $gestionThematique->getAll();
        assertTest(count($created) === 1, "Created thematique was not returned by getAll.");
        assertTest($created[0]->getId() === 1, "Created thematique has an incorrect ID.");
        assertTest($created[0]->getName() === "science", "Created thematique name was not trimmed.");
        assertTest($created[0]->getDescription() === "podcasts", "Created thematique description is incorrect.");

        expectException(
            ValidationException::class,
            fn() => $gestionThematique->create(new Thematique("ab", "invalid")),
            "Le nom doit contenir au moins 3 caractères."
        );
        assertTest(count($gestionThematique->getAll()) === 1, "Rejected creation changed the stored data.");

        $dataFileProperty->setValue(null, $temporaryFiles[5]);
        file_put_contents($temporaryFiles[5], '[{"id":"invalid","name":"valid","description":"record"}]');
        expectException(
            DataStorageException::class,
            fn() => $gestionThematique->getAll(),
            "Le fichier des thématiques contient des données invalides."
        );
    } finally {
        $dataFileProperty->setValue(null, $originalDataFile);
    }
} finally {
    foreach ($temporaryFiles as $temporaryFile) {
        if (is_file($temporaryFile)) {
            unlink($temporaryFile);
        }
    }
    rmdir($directoryPath);
    rmdir($temporaryDirectory);
}

echo "Thematique tests passed." . PHP_EOL;

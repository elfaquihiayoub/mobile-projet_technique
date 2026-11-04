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

$validFile = $temporaryDirectory . DIRECTORY_SEPARATOR . "valid.json";
$invalidFile = $temporaryDirectory . DIRECTORY_SEPARATOR . "invalid.json";
$scalarFile = $temporaryDirectory . DIRECTORY_SEPARATOR . "scalar.json";
$invalidRecordFile = $temporaryDirectory . DIRECTORY_SEPARATOR . "invalid-record.json";
$workflowFile = $temporaryDirectory . DIRECTORY_SEPARATOR . "workflow.json";
$encodingFile = $temporaryDirectory . DIRECTORY_SEPARATOR . "encoding.json";

try {
    $thematique = new Thematique("sport", "test", 5);
    assertTest((string) $thematique === "sport (test)", "Thematique string representation is incorrect.");
    assertTest($thematique->getId() === 5, "Thematique ID was not retained.");
    assertTest($thematique->getName() === "sport", "Thematique name was not retained.");
    assertTest($thematique->getDescription() === "test", "Thematique description was not retained.");

    $baseService = new class extends BaseService {
        public function validateText(string $value, string $fieldName, int $minimumLength): string
        {
            return $this->normalizeAndValidateText($value, $fieldName, $minimumLength);
        }
    };
    assertTest(
        $baseService->validateText("  science  ", "nom", 3) === "science",
        "BaseService did not normalize valid text."
    );
    expectException(
        ValidationException::class,
        fn() => $baseService->validateText("ab", "nom", 3),
        "Le nom doit contenir au moins 3 caractères."
    );

    file_put_contents($validFile, '[{"id":1,"name":"sport","description":"test"}]');
    $dao = new ThematiqueDAO($validFile);
    $found = $dao->findAll();
    assertTest(count($found) === 1 && $found[0] instanceof Thematique, "DAO did not hydrate entities.");
    assertTest($found[0]->getId() === 1 && $found[0]->getName() === "sport", "DAO hydrated incorrect data.");

    expectException(
        DataStorageException::class,
        fn() => (new ThematiqueDAO($temporaryDirectory . DIRECTORY_SEPARATOR . "missing.json"))->findAll(),
        "Impossible de lire le fichier de données."
    );

    file_put_contents($invalidFile, "{invalid");
    $invalidJsonException = expectException(
        DataStorageException::class,
        fn() => (new ThematiqueDAO($invalidFile))->findAll(),
        "Le fichier de données contient un JSON invalide."
    );
    assertTest($invalidJsonException->getPrevious() instanceof JsonException, "Invalid JSON cause was not preserved.");

    file_put_contents($scalarFile, "null");
    expectException(
        DataStorageException::class,
        fn() => (new ThematiqueDAO($scalarFile))->findAll(),
        "Le fichier de données doit contenir une liste."
    );

    file_put_contents($invalidRecordFile, '[{"id":"invalid","name":"valid","description":"record"}]');
    expectException(
        DataStorageException::class,
        fn() => (new ThematiqueDAO($invalidRecordFile))->findAll(),
        "Le fichier des thématiques contient des données invalides."
    );

    file_put_contents($workflowFile, "[]");
    $service = new GestionThematique(new ThematiqueDAO($workflowFile));
    $created = $service->create(new Thematique("  science  ", "podcasts"));
    assertTest($created->getId() === 1, "Created thematique has an incorrect ID.");
    assertTest($created->getName() === "science", "Created thematique name was not trimmed.");
    assertTest($created->getDescription() === "podcasts", "Created thematique description is incorrect.");

    $stored = $service->getAll();
    assertTest(count($stored) === 1, "Created thematique was not returned by getAll.");
    assertTest($stored[0]->getId() === 1, "Stored thematique has an incorrect ID.");

    expectException(
        ValidationException::class,
        fn() => $service->create(new Thematique("ab", "invalid")),
        "Le nom doit contenir au moins 3 caractères."
    );
    assertTest(count($service->getAll()) === 1, "Rejected creation changed the stored data.");

    file_put_contents($encodingFile, "[]");
    $encodingException = expectException(
        DataStorageException::class,
        fn() => (new ThematiqueDAO($encodingFile))->create(new Thematique("valid", "\xB1\x31"))
    );
    assertTest($encodingException->getPrevious() instanceof JsonException, "JSON encoding cause was not preserved.");
    assertTest(file_get_contents($encodingFile) === "[]", "Failed write changed the stored data.");
} finally {
    foreach ([$validFile, $invalidFile, $scalarFile, $invalidRecordFile, $workflowFile, $encodingFile] as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($temporaryDirectory);
}

echo "Thematique tests passed." . PHP_EOL;

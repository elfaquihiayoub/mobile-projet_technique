<?php
require_once __DIR__ . "/Thematique.php";

class DataStorageException extends RuntimeException
{
}

class ThematiqueDAO
{
    private string $dataFile;

    public function __construct(?string $dataFile = null)
    {
        $this->dataFile = $dataFile ?? __DIR__ . "/../data/thematique.json";
    }

    /**
     * @return Thematique[]
     */
    public function findAll(): array
    {
        $records = $this->readRecords();
        $thematiques = [];

        foreach ($records as $record) {
            if (
                !is_array($record)
                || !isset($record["id"], $record["name"], $record["description"])
                || !is_int($record["id"])
                || !is_string($record["name"])
                || !is_string($record["description"])
            ) {
                throw new DataStorageException("Le fichier des thématiques contient des données invalides.");
            }

            $thematiques[] = new Thematique($record["name"], $record["description"], $record["id"]);
        }

        return $thematiques;
    }

    public function create(Thematique $thematique): Thematique
    {
        $thematiques = $this->findAll();
        $nextId = 1;

        foreach ($thematiques as $existingThematique) {
            $nextId = max($nextId, $existingThematique->getId() + 1);
        }

        $records = [];
        foreach ($thematiques as $existingThematique) {
            $records[] = $this->toRecord($existingThematique);
        }

        $records[] = [
            "id" => $nextId,
            "name" => $thematique->getName(),
            "description" => $thematique->getDescription(),
        ];
        $this->writeRecords($records);
        $thematique->setId($nextId);

        return $thematique;
    }

    private function readRecords(): array
    {
        $jsonData = @file_get_contents($this->dataFile);
        if ($jsonData === false) {
            throw new DataStorageException("Impossible de lire le fichier de données.");
        }

        try {
            $records = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new DataStorageException("Le fichier de données contient un JSON invalide.", 0, $exception);
        }

        if (!is_array($records)) {
            throw new DataStorageException("Le fichier de données doit contenir une liste.");
        }

        return $records;
    }

    private function writeRecords(array $records): void
    {
        try {
            $jsonData = json_encode($records, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new DataStorageException("Impossible de convertir les données en JSON.", 0, $exception);
        }

        if (@file_put_contents($this->dataFile, $jsonData, LOCK_EX) === false) {
            throw new DataStorageException("Impossible d'enregistrer le fichier de données.");
        }
    }

    private function toRecord(Thematique $thematique): array
    {
        return [
            "id" => $thematique->getId(),
            "name" => $thematique->getName(),
            "description" => $thematique->getDescription(),
        ];
    }
}

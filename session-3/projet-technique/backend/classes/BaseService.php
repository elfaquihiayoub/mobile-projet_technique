<?php

class DataStorageException extends RuntimeException
{
}

abstract class BaseService
{
    protected function readJsonFile(string $filePath): array
    {
        $jsonData = @file_get_contents($filePath);
        if ($jsonData === false) {
            throw new DataStorageException("Impossible de lire le fichier de données.");
        }

        try {
            $data = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new DataStorageException("Le fichier de données contient un JSON invalide.", 0, $exception);
        }

        if (!is_array($data)) {
            throw new DataStorageException("Le fichier de données doit contenir une liste.");
        }

        return $data;
    }

    protected function writeJsonFile(string $filePath, array $data): void
    {
        try {
            $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new DataStorageException("Impossible de convertir les données en JSON.", 0, $exception);
        }

        if (@file_put_contents($filePath, $jsonData, LOCK_EX) === false) {
            throw new DataStorageException("Impossible d'enregistrer le fichier de données.");
        }
    }
}

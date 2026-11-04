<?php

abstract class BaseService
{
    protected function normalizeAndValidateText(
        string $value,
        string $fieldName,
        int $minimumLength
    ): string
    {
        $normalizedValue = trim($value);

        if (strlen($normalizedValue) < $minimumLength) {
            throw new ValidationException(
                "Le {$fieldName} doit contenir au moins {$minimumLength} caractères."
            );
        }

        return $normalizedValue;
    }
}

<?php

namespace App\Service;

class TextNormalizerService
{
    /**
     * Supprime les accents d'une chaîne de caractères
     * @param string $text
     * @return string
     */
    public function removeAccents(string $text): string
    {
        return transliterator_transliterate('Any-Latin; Latin-ASCII;', $text) ?? $text;
    }
}

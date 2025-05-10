<?php

namespace App\Services;

class HalService
{
    /**
     * Exemple : vérifier si un héritier est bloqué (mahjoub)
     */
    public function isBlocked(string $heirType, array $input): bool
    {
        // Exemple : une mère peut être bloquée si des enfants existent
        if ($heirType === 'alom' && ($input['sons'] ?? 0) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Exemple : déterminer la part fixe d’un héritier selon les règles
     */
    public function getFixedShare(string $heirType, array $input): ?float
    {
        switch ($heirType) {
            case 'azawja':
                return $input['sons'] > 0 ? 0.125 : 0.25;
            case 'alom':
                return ($input['sons'] ?? 0) > 0 ? 1 / 6 : 1 / 3;
            default:
                return null; // Pas de part fixe
        }
    }

    /**
     * Vérifie s'il y a des héritiers agnatiques (ʿaṣaba)
     */
    public function hasAsaba(array $input): bool
    {
        return ($input['sons'] ?? 0) > 0 || ($input['father'] ?? false);
    }
}
